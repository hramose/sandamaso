<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function Index(){

		$fecha_desde = date("d-m-Y");
		$plantas = Plantas::all();
		return View::make('home.home')->with('fechas_reservar','')
									->with('planta', '')
									->with('plantas', $plantas)
									->with('id_planta', '')
									->with('carga', 1)
									->with('patente', '')
									->with('fecha_desde', $fecha_desde)
									->with('fecha_hasta', '');
	}

	public function IndexAdmin(){
		if (Auth::check()){
            return View::make('home.admin');
        }else{
            return View::make('home.login'); 
        }
	}

	public function Login(){
		$credentials = array(
        'email' => Input::get('email'),
        'password' => Input::get('password'));
        if(Auth::attempt($credentials)){
            $user = User::where('email', '=', Input::get('email'))->firstOrFail();
            Auth::login($user);
            return View::make('home.admin');
        }else{
            return View::make('home.login')->withErrors('incorrecto');
        }   
    }

    public function Logout(){
		Auth::logout();
        return Redirect::to('/admin');
	}

     public function CerrarSesionGet(){
        Auth::logout();
        return View::make('home.admin'); 
    }

	public function BuscarReserva(){
		$id_planta = Input::get('id_planta');
		$planta = Plantas::find($id_planta);
		$fecha_desde = Input::get('fecha_desde');
		$fecha_hasta = Input::get('fecha_hasta');
		$patente = Input::get('patente');
		$start = date("Y-m-d", strtotime($fecha_desde));
		$end = date("Y-m-d", strtotime($fecha_hasta));
		$plantas = Plantas::all();

		$start = new DateTime($start);
		$end = new DateTime($end);

		echo $planta->num_dias;
		echo '<br/>';
		echo $planta->sabados;
		echo '<br/>';
		echo $planta->dias_restriccion;
		
		$fechas = FechasReservas::whereBetween('fecha', array($start, $end))
								->where('lleno', 1)
								->where('planta', $planta->nombre)
								->lists('fecha');
		
		$oneday = new DateInterval("P1D");

		//dias de la semana que calzan en las fechas
		$days = array();
		foreach(new DatePeriod($start, $oneday, $end->add($oneday)) as $day) {
		    $day_num = $day->format("N");
		    $dia =  $day->format('d');
		    $max = 30 - $planta->num_dias;
		    if($planta->sabados == 0 && $planta->dias_restriccion == 1){
		    	if($day_num <= 6 && $dia > $planta->num_dias && $dia < $max){
		        	$days[] = $day->format("Y-m-d");
		    	} 
		    }else{
		    	if($planta->sabados == 0 && $planta->dias_restriccion == 0){
		    		if($day_num <= 6){
		        	$days[] = $day->format("Y-m-d");
		    		} 
		    	}else{
		    		if($planta->sabados == 1 && $planta->dias_restriccion == 1){
		    			if($day_num <= 5 && $dia > $planta->num_dias && $dia < $max){
		        			$days[] = $day->format("Y-m-d");
		    			} 
		    		}else{
		    			if($planta->sabados == 1 && $planta->dias_restriccion == 0){
		    				if($day_num <= 5){
		        				$days[] = $day->format("Y-m-d");
		    				}
		    			}
		    		}
		    	}
		    }
		    	
		}    

		$fechas_reservar = array();
		$count=0;
		foreach($days as $item){
			$key = array_search($item, $fechas);
			if ($key === false) {
				$fechas_reservar[] = $item;
			}
			$count++;
			if($count >= 25){
				break;
			}
		}

		return View::make('home.home')->with('fecha_desde', $fecha_desde )
									->with('fecha_hasta', $fecha_hasta)
									->with('planta', $planta->nombre)
									->with('id_planta', $id_planta)
									->with('plantas', $plantas)
									->with('patente', $patente)
									->with('carga', 0)
									->with('fechas_reservar', $fechas_reservar);
	}

	function isWeekend($date) {
    	return (date('N', strtotime($date)) >= 6);
	}


	public function ListarReservas(){
		$fecha1=null;
		$fecha2=null;
		if(Input::get('fecha')[0] != ''){
			$fecha1 = date('Y-d-m', strtotime(Input::get('fecha')[0]));
		}
		if(Input::get('fecha')[1] != ""){
			$fecha2 = date('Y-d-m', strtotime(Input::get('fecha')[1]));
		}
		$filter = DataFilter::source(new Reservas);
		$filter->link('/informes/general/'.Input::get('planta').'/'.$fecha1.'/'.$fecha2,'Exportar', 'TR');
		$filter->attributes(array('class'=>'form-inline'));
		$filter->add('nombre','Buscar por nombre', 'text');
		$filter->add('email','Buscar por email', 'text');
		$filter->add('patente','Buscar por patente', 'text');
		$filter->add('planta','Buscar por planta', 'text');
		$filter->add('fecha','Fecha Reserva','daterange')->format('d/m/Y', 'es');
		$filter->submit('Buscar');
		$filter->reset('Limpiar');

		$grid = DataGrid::source($filter);
	    $grid->attributes(array("class"=>"table table-striped"));
	    $grid->add('nombre','Nombre', true);
	    $grid->add('email','Email', true);
	    $grid->add('patente','Patente', true);
	    $grid->add('planta','Planta', true);
	    $grid->add('tipo_vehiculo','Tipo Vehículo', true);
	   	$grid->add('{{ date("d-m-Y",strtotime($fecha)) }}','Fecha', true);
	   	$grid->add('hora','Hora', true);
		//$grid->edit(url().'/reservas/crud', 'Ver|Editar|Borrar','delete');
	    $grid->paginate(10);

		return View::make('reservas/list', compact('filter', 'grid', 'etapa'));
	}

	public function Crudreservas(){
        $edit = DataEdit::source(new Reservas());
        $edit->link("/","Lista Reservas", "TR")->back();
        return $edit->view('reservas/crud', compact('edit'));
    }


    public function ListarPlantas(){

		$filter = DataFilter::source(new Plantas);
		$filter->label('Restricciones');
		//$filter->link('/plantas/crud', 'Crear Nuevo', 'TR');
		$filter->attributes(array('class'=>'form-inline'));
		$filter->add('nombre','Buscar por nombre', 'text');
		$filter->submit('Buscar');
		$filter->reset('Limpiar');

		$grid = DataGrid::source($filter);
	    $grid->attributes(array("class"=>"table table-striped"));
	    $grid->add('nombre','Nombre', true);
	    $grid->add('sabados','Sabados', true);
	    $grid->add('dias_restriccion','Primeros/Ultimos días', true);
	    $grid->add('num_dias','Numero de Días', true);
	    $grid->edit(url().'/plantas/crud', 'Editar','modify');
	    $grid->paginate(10);

		return View::make('plantas/list', compact('filter', 'grid', 'etapa'));
	}

	public function CrudPlantas(){
        $edit = DataEdit::source(new Plantas());
        $edit->link("/plantas/list","Lista Plantas", "TR")->back();
        $edit->add('nombre','Nombre', 'text')->rule('required');
        $edit->add('sabados','Sabados', 'checkbox');
        $edit->add('dias_restriccion','Primeros/Ultimos Días','checkbox');
        $edit->add('num_dias','Numero de Días','text')->rule('required');

        return $edit->view('plantas/crud', compact('edit'));
    }


	public function HorasDisponibles($fecha, $planta, $patente){
		$horas = array(
			'07:00','07:30',
			'08:00','08:30',
			'09:00','09:30',
			'10:00','10:30',
			'11:00','11:30',
			'12:00','12:30',
			'13:00','13:30',
			'14:00','14:30',
			'15:00','15:30',
			'16:00','16:30',
			'17:00','17:30',
			'18:00','18:30',
			'19:00'
			);
		if($this->isWeekend($fecha)){
			$horas = array(
			'08:30',
			'09:00','09:30',
			'10:00','10:30',
			'11:00','11:30',
			'12:00','12:30',
			'13:00','13:30'
			);
		}
		if($planta == '1'){
			$horas = array(
				'08:00','08:30',
				'09:00','09:30',
				'10:00','10:30',
				'11:00','11:30',
				'12:00','12:30',
				'13:00','15:00',
				'15:30','16:00',
				'16:30','17:00',
				'17:30','18:00'
				);	
			if($this->isWeekend($fecha)){
				$horas = array(
						'08:30',
				'09:00','09:30',
				'10:00','10:30',
				'11:00','11:30',
				'12:00','12:30',
				'13:00','13:30'
				);
			}
		}
		if($planta == '2' || $planta == '3'){
			$horas = array(
			'09:00','09:30',
			'10:00','10:30',
			'11:00','11:30',
			'12:00','12:30',
			'13:00','13:30',
			'14:00','14:30',
			'15:00','15:30',
			'16:00','16:30',
			'17:00'
			);
		}
		if($planta == '4'){
			$horas = array(
				'09:00','09:30',
				'10:00','10:30',
				'11:00','11:30',
				'12:00','12:30',
				'13:00','15:00',
				'15:30','16:00',
				'16:30','17:00',
				'17:30','18:00',
				'18:30','19:00'
				);	
			if($this->isWeekend($fecha)){
				$horas = array(
				'09:00','09:30',
				'10:00','10:30',
				'11:00','11:30',
				'12:00','12:30',
				'13:00','13:30',
				'14:00'
				);
			}
		}
		if($planta == '5'){
			$horas = array(
				'09:00','09:30',
				'10:00','10:30',
				'11:00','11:30',
				'12:00','12:30',
				'13:00','13:30',
				'14:00','14:30',
				'15:00','15:30',
				'16:00','16:30',
				'17:00','17:30',
				'18:00'
				);
			if($this->isWeekend($fecha)){
				$horas = array(
				'09:00','09:30',
				'10:00','10:30',
				'11:00','11:30',
				'12:00','12:30',
				'13:00','13:30',
				'14:00'
				);
			}
		}
		if($planta == '6'){
			$horas = array(
				'07:00','07:30',
				'08:00','08:30',
				'09:00','09:30',
				'10:00','10:30',
				'11:00','11:30',
				'12:00','12:30',
				'13:00','13:30',
				'14:00','14:30',
				'15:00','15:30',
				'16:00','16:30',
				'17:00','17:30',
				'18:00','18:30',
				'19:00'
				);
			if($this->isWeekend($fecha)){
				$horas = array(
				'07:00','07:30',
				'08:00','08:30',
				'09:00','09:30',
				'10:00','10:30',
				'11:00','11:30',
				'12:00','12:30',
				'13:00','13:30',
				'14:00','14:30',
				'15:00','15:30',
				'16:00'
				);
			}
		}
		if($planta == '7'){
			$horas = array(
				'08:00','08:30',
				'09:00','09:30',
				'10:00','10:30',
				'11:00','11:30',
				'12:00','12:30',
				'13:00','13:30',
				'14:00','14:30',
				'15:00','15:30',
				'16:00','16:30',
				'17:00','17:30',
				'18:00'
				);
			if($this->isWeekend($fecha)){
				$horas = array(
				'08:30',
				'09:00','09:30',
				'10:00','10:30',
				'11:00','11:30',
				'12:00','12:30',
				'13:00','13:30'
				);
			}
		}
		$horas_ocupadas = Horas::where('horas.fecha', $fecha)
						->join('fechas_reservas', 'horas.id_fecha', '=', 'fechas_reservas.id')
						->where('fechas_reservas.planta', $planta)->lists('horas.horas');

		$horas_reservar = array();
		foreach($horas as $item){
			$key = array_search($item, $horas_ocupadas);
			if ($key === false) {
				$horas_reservar[] = $item;
			}
		}

		return View::make('home.horas')->with('horas_reservar', $horas_reservar )
										->with('fecha', $fecha)
										->with('patente', $patente)
										->with('planta', $planta);
	}


	public function Reservar(){
		$fecha = Input::get('fecha');
		$hora = Input::get('hora');
		$planta = Plantas::find(Input::get('planta'))->nombre;
		$nombre = Input::get('nombre');
		$email = Input::get('email');
		$telefono = Input::get('telefono');
		$patente = Input::get('patente');
		$comentario = '';
		$convenio = Input::get('convenio');
		$tipo_vehiculo = Input::get('tipo_vehiculo');
		$tipo_revision = Input::get('tipo_revision');


		$reserva = new Reservas;
		$reserva->planta = $planta;
		$reserva->nombre = $nombre;
		$reserva->email = $email;
		$reserva->comentario = $comentario;
		$reserva->telefono = $telefono;
		$reserva->patente = $patente;
		$reserva->convenio = $convenio;
		$reserva->tipo_vehiculo = $tipo_vehiculo;
		$reserva->tipo_revision = $tipo_revision;
		$reserva->fecha = $fecha;
		$reserva->hora = $hora;
		$reserva->save();

		$num_fecha = Horas::where('fecha', $fecha)->count();
		$lleno = 0;
		if($num_fecha == 28){
			$lleno = 1;
		}

		$fechas = new FechasReservas;
		$fechas->fecha = $fecha;
		$fechas->lleno = $lleno;
		$fechas->planta = $planta;
		$fechas->id_reservas = $reserva->id;
		$fechas->save();

		$horas = new Horas;
		$horas->horas = $hora;
		$horas->fecha = $fecha;
		$horas->id_fecha = $fechas->id;
		$horas->save();


		 $data = array(
          		"nombre"=>$nombre,
                "fecha"=>$fecha,
                "email"=>$email,
                "hora"=>$hora,
                "planta"=>$planta
                );

		 $dataadmin = array(
          		"nombre"=>$nombre,
                "fecha"=>$fecha,
                "email"=>$email,
                "hora"=>$hora,
                "planta"=>$planta,
                "patente"=>$patente,
                "convenio"=>$convenio,
                "tipo_vehiculo"=>$tipo_vehiculo,
                "tipo_revision"=>$tipo_revision,
                "telefono"=>$telefono,
                "email"=>$email,
                "comentario"=>$comentario
                );
        //email al cliente
        $emails = array($email);
        Mail::send('emails.email', $data, function($message) use ($emails){
			$message->from('no-reply@sandamaso.cl', 'San Damaso - revisiones técnicas');	
			$message->to($emails, 'test')->subject('Reserva recibida');
        });

        //email al admin
        //quilicura@sandamaso.cl
		$emails = array('dan.avila7@gmail.com');
		Mail::send('emails.emailadmin', $dataadmin, function($message) use ($emails){
          	$message->from('no-reply@sandamaso.cl', 'San Damaso - Admin');
            $message->to($emails, 'test')->subject('Nueva Reserva');
        });


		return View::make('home.reservado')->with('nombre', $nombre)
										->with('fecha', $fecha)
										->with('planta', $planta)
										->with('email', $email)
										->with('hora', $hora);
	}
}
