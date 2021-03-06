<?php

class InformesController extends BaseController {


	public function General(){

		$reservas = Reservas::all();
		$start = new DateTime(Input::get('fecha_desde'));
		$end = new DateTime(Input::get('fecha_hasta'));
		$query = Reservas::select('nombre','email', 'telefono', 'patente', "convenio", 'tipo_vehiculo', 'planta', 'fecha', 'hora', 'created_at as creado');

				if(Input::get('fecha_desde') != ''){
						$query->whereBetween('fecha', array($start, $end));
				}
				if(Input::get('planta') != ''){
						$query->where('planta', 'like', '%'.Input::get('planta').'%');
				}
				if(Input::get('nombre') != ''){
					$query->where('nombre', 'like', '%'.Input::get('nombre').'%');
				}
				if(Input::get('patente') != ''){
					$query->where('patente', 'like', '%'.Input::get('patente').'%');
				}
				if(Input::get('email') != ''){
					$query->where('email', 'like', '%'.Input::get('email').'%');
				}
		$reservas = $query->orderBy('fecha')->get();

		Excel::create('Reservas Generales', function($excel) use($reservas){
    		$excel->sheet('Reservas', function($sheet) use($reservas) {
	        	$sheet->fromModel($reservas);
	        	$sheet->setOrientation('landscape');
    		});
		})->export('xls');
	}

	public function PorDia(){
		$start = new DateTime(Input::get('fecha'));
		$id_planta = Input::get('id_planta');

		if($id_planta){
			$planta = Plantas::find($id_planta)->nombre;
			$reservas = Reservas::where('fecha', $start)
				->where('planta', $planta)
				->select('nombre','email', 'telefono', 'patente', 'tipo_vehiculo', 'planta', 'fecha', 'hora')
				->orderBy('hora')->get();
		}else{
			$reservas = Reservas::where('fecha', $start)
				->select('nombre','email', 'telefono', 'patente', 'tipo_vehiculo', 'planta', 'fecha', 'hora')
				->orderBy('hora')->get();
		}

		Excel::create('Reservas Por Día', function($excel) use($reservas){
    		$excel->sheet('Reservas', function($sheet) use($reservas) {
	        	$sheet->fromModel($reservas);
	        	$sheet->setOrientation('landscape');
    		});
		})->export('xls');

	}

	public function PorDiaGet(){
		$fecha = date("d-m-Y");
		$plantas = Plantas::all();
		return View::make('reservas.pordia')
						->with('plantas', $plantas)
						->with('planta', '')
						->with('id_planta','')
						->with('fecha',$fecha);
	}

	public function ListarCorreos(){
		$filter = DataFilter::source(new RegistroCorreos);
		$filter->label('Registro de Correos de Recordatorio.');
		$filter->attributes(array('class'=>'form-inline'));
		$filter->link("/admin","Volver al Menú", "TR");
		$filter->add('email','Buscar por email', 'text');
		$filter->add('patente','Buscar por patente', 'text');
		$filter->add('patente','Buscar por patente', 'text');
		$filter->add('planta','Buscar por planta', 'text');
		$filter->add('fecha','Fecha Reserva','daterange')->format('d/m/Y', 'es');
		$filter->add('created_at','Fecha Enviado','daterange')->format('d/m/Y', 'es');
		$filter->submit('Buscar');
		$filter->reset('Limpiar');
		$grid = DataGrid::source($filter);
	    $grid->attributes(array("class"=>"table table-striped"));
	    $grid->add('email','Email', true);
	    $grid->add('patente','Patente', true);
	    $grid->add('planta','Planta', true);
	    $grid->add('fecha','Fecha', true);
	    $grid->add('hora','Hora', true);
	    $grid->add('created_at','Creado', true);
	    $grid->paginate(20);

		return View::make('home/registro_correos', compact('filter', 'grid'));
	}


	public function SendRememberEmail(){

		$date_back = date("Y-m-d",strtotime('+1 day'));
		$reservas = Reservas::where('fecha', $date_back)->get();
		foreach ($reservas as $reserva) {

			$planta = Plantas::where('nombre', $reserva->planta)->first();
			$email = $reserva->email;
			$data = array(
				'nombre'=>$reserva->nombre,
				'fecha' => date("d-m-Y", strtotime($reserva->fecha)),
				'nombre_planta' => $reserva->planta,
				'url_map' => $planta->url_map,
				'image_map' => $planta->image_map,
				'hora' => $reserva->hora,
				'patente' => $reserva->patente,
				'tipo_vehiculo' => $reserva->tipo_vehiculo
				);

			Mail::send('emails.emailremember', $data, function($message) use ($email){
	          	$message->from('no-reply@sandamaso.cl', 'San Damaso');
	            $message->to($email, 'test')->subject('Recordatorio de reserva.');
	    	});
			//guarda el envió de correos
	    	DB::table('registro_correos')->insert(
    			array('email' => $email,
    				 'patente' => $reserva->patente,
    				 'planta' => $reserva->planta,
    				 'fecha' => $reserva->fecha,
    				 'hora' => $reserva->hora,
    				 'date_back' => $date_back)
			);
		}

		Mail::send('emails.emailremember', $data, function($message){
	          	$message->from('no-reply@sandamaso.cl', 'San Damaso');
	            $message->to('dan.avila7@gmail.com', 'test')->subject('Recordatorio de reserva. (correos enviados)');
	    	});
	}
}
