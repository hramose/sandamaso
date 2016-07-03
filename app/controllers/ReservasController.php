<?php

class ReservasController extends BaseController {

	public function ListarReservas(){
		$fecha1=null;
		$fecha2=null;
		if(Input::get('fecha')[0] != ''){
			$date = str_replace('/', '-', Input::get('fecha')[0]);
			$fecha1 = date('Y-m-d', strtotime($date));
		}
		if(Input::get('fecha')[1] != ''){
			$date = str_replace('/', '-', Input::get('fecha')[1]);
			$fecha2 = date('Y-m-d', strtotime($date));
		}

		$filter = DataFilter::source(Reservas::where('convenio', 0)->orderBy('fecha', 'desc'));

		$link = '?nombre='.Input::get('nombre').'&email='.Input::get('email').'&patente='.Input::get('patente').'&planta='.Input::get('planta').'&fecha_desde='.$fecha1.'&fecha_hasta='.$fecha2;
		$filter->attributes(array('class'=>'form-inline'));
		$filter->add('nombre','Buscar por nombre', 'text');
		$filter->add('email','Buscar por email', 'text');
		$filter->add('patente','Buscar por patente', 'text');
		$filter->add('planta','Buscar por planta', 'text');
		$filter->add('fecha','Fecha Reserva','daterange')->format('d/m/Y', 'es');
		$filter->submit('Buscar');
		//$filter->reset('Limpiar');
		$filter->build();

		$grid = DataSet::source($filter);
	    $grid->paginate(10);
	    $grid->build();

		return View::make('reservas/list', compact('filter', 'grid', 'link'));
	}

    public function ListarReservasConvenio(){
        $fecha1=null;
        $fecha2=null;
        if(Input::get('fecha')[0] != ''){
            $date = str_replace('/', '-', Input::get('fecha')[0]);
            $fecha1 = date('Y-m-d', strtotime($date));
        }
        if(Input::get('fecha')[1] != ''){
            $date = str_replace('/', '-', Input::get('fecha')[1]);
            $fecha2 = date('Y-m-d', strtotime($date));
        }

        //print_r(Reservas::with('fechas_reservas_convenio.empresa')->where('convenio', 1)->orderBy('fecha', 'desc')->take(1)->get()->toArray());
        $filter = DataFilter::source(Reservas::with('fechas_reservas_convenio.empresa')->where('convenio', 1)->orderBy('fecha', 'desc'));

        $link = '?nombre='.Input::get('nombre').'&email='.Input::get('email').'&patente='.Input::get('patente').'&planta='.Input::get('planta').'&fecha_desde='.$fecha1.'&fecha_hasta='.$fecha2;
        $filter->attributes(array('class'=>'form-inline'));
        $filter->add('nombre','Buscar por nombre', 'text');
        $filter->add('email','Buscar por email', 'text');
        $filter->add('patente','Buscar por patente', 'text');
        $filter->add('planta','Buscar por planta', 'text');
        $filter->add('fecha','Fecha Reserva','daterange')->format('d/m/Y', 'es');
        $filter->submit('Buscar');
        //$filter->reset('Limpiar');
        $filter->build();

        $grid = DataSet::source($filter);
        $grid->paginate(10);
        $grid->build();

        return View::make('reservas/list_convenio', compact('filter', 'grid', 'link'));
    }


	public function Crudreservas(){
        $edit = DataEdit::source(new Reservas());
        $edit->link("/","Lista Reservas", "TR")->back();
        return $edit->view('reservas/crud', compact('edit'));
    }

    public function DeleteReservas($id){
    	$reserva = Reservas::find($id)->delete();
    	$fechasConvenio = FechasReservasConvenio::where('id_reservas', $id)->first();
    	if($fechasConvenio){
    		$horasConvenio = HorasConvenio::where('id_fecha', $fechasConvenio->id)->delete();
    		$fechasConvenio->delete();
    	}

    	$fechas = FechasReservas::where('id_reservas', $id)->first();
    	if($fechas){
    		$horas = Horas::where('id_fecha', $fechas->id)->delete();
    		$fechas->delete();
    	}

    	return Redirect::to('admin/reservas/list');

    }


}
