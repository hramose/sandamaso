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

		$fecha_desde = date("d-m-Y", strtotime('+1 day'));
		$plantas = Plantas::all();
		return View::make('home.home')->with('fechas_reservar','')
									->with('planta', '')
									->with('plantas', $plantas)
									->with('id_planta', '')
									->with('convenio', '')
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
		$esconvenio = Input::get('convenio');

		if($esconvenio){
			$convenio = '1';
		}else{
			$convenio = '0';
		}
		
		$start = date("Y-m-d", strtotime($fecha_desde));
		$end = date("Y-m-d", strtotime($fecha_hasta));
		
		$plantas = Plantas::all();

		$start = new DateTime($start);
		$end = new DateTime($end);
		
		if($convenio){
			$fechas = FechasReservasConvenio::whereBetween('fecha', array($start, $end))
								->where('lleno', 1)
								->where('planta', $planta->nombre)
								->lists('fecha');
		}else{
			$fechas = FechasReservas::whereBetween('fecha', array($start, $end))
								->where('lleno', 1)
								->where('planta', $planta->nombre)
								->lists('fecha');
								//echo $planta->nombre;
		}
		
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
									->with('convenio', $convenio)
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
			$date = str_replace('/', '-', Input::get('fecha')[0]);
			$fecha1 = date('Y-m-d', strtotime($date));
		}
		if(Input::get('fecha')[1] != ''){
			$date = str_replace('/', '-', Input::get('fecha')[1]);
			$fecha2 = date('Y-m-d', strtotime($date));
		}
		//echo Input::get('fecha')[1];
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
		$filter->build();

		$grid = DataSet::source($filter);
	    /*$grid->attributes(array("class"=>"table table-striped"));
	    $grid->add('nombre','Nombre', true);
	    $grid->add('email','Email', true);
	    $grid->add('patente','Patente', true);
	    $grid->add('planta','Planta', true);
	    $grid->add('convenio','Convenio', true);
	    $grid->add('tipo_vehiculo','Tipo Vehículo', true);
	   	$grid->add('{{ date("d-m-Y",strtotime($fecha)) }}','Fecha', true);
	   	$grid->add('hora','Hora', true);
		$grid->edit(url().'/reservas/crud', 'Borrar','delete');*/
	    $grid->paginate(10);
	    $grid->build();

		return View::make('reservas/list', compact('filter', 'grid'));
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
    		//$horasConvenio = HorasConvenio::where('id_fecha', $fechasConvenio->id)->delete();
    		//$fechasConvenio->delete();
    	}

    	$fechas = FechasReservas::where('id_reservas', $id)->first();
    	if($fechas){
    		//echo 'encuentra fechasReservas';
    		$horas = Horas::where('id_fecha', $fechas->id)->delete();
    		$fechas->delete();
    	}

    	return Redirect::to('reservas/list');

    }


    public function ListarPlantas(){

		$filter = DataFilter::source(new Plantas);
		$filter->label('Restricciones');
		//$filter->link('/plantas/crud', 'Crear Nuevo', 'TR');
		$filter->attributes(array('class'=>'form-inline'));
		$filter->add('nombre','Buscar por nombre', 'text');
		$filter->submit('Buscar');
		$filter->reset('Limpiar');
		//$filter->build();

		$grid = DataGrid::source($filter);
	    /*$grid->attributes(array("class"=>"table table-striped"));
	    $grid->add('nombre','Nombre', true);
	    $grid->add('sabados','Sabados', true);
	    $grid->add('dias_restriccion','Primeros/Ultimos días', true);
	    $grid->add('num_dias','Numero de Días', true);
	    $grid->edit(url().'/plantas/crud', 'Editar','modify');*/
	    $grid->paginate(10);
	    $grid->build();


		return View::make('plantas/list', compact('filter', 'grid'));
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

     public function ListarPlantasHoras($id_planta){

		$filter = DataFilter::source(PlantasHoras::where('id_planta', $id_planta));
		$nombre = Plantas::find($id_planta)->nombre;
		$filter->label('Horas Semana Planta '.$nombre);
		$filter->link("/plantas/list","Lista de Plantas", "TR");
		$filter->link("/plantas/horas/".$id_planta."/crud","Agregar Hora", "TR");
		$grid = DataGrid::source($filter);
	    $grid->attributes(array("class"=>"table table-striped"));
	    $grid->add('hora_planta','Hora', true);
	    $grid->edit(url().'/plantas/horas/'.$id_planta.'/crud', 'Borrar/Editar','modify|delete');

		return View::make('planta_hora/list', compact('filter', 'grid'));
	}

	public function CrudPlantasHoras($id){
        $edit = DataEdit::source(new PlantasHoras());
        $edit->link("/plantas/horas/".$id."/list","Lista Horas", "TR")->back();
        $edit->add('hora_planta','Hora', 'text')->rule('required');
        $edit->add('id_planta', '', 'hidden')->insertValue($id);

        return $edit->view('planta_hora/crud', compact('edit'));
    }

    public function ListarPlantasHorasWeekend($id_planta){

		$filter = DataFilter::source(PlantasHorasWeekend::where('id_planta', $id_planta));
		$nombre = Plantas::find($id_planta)->nombre;
		$filter->label('Horas Fin de Semana Planta '.$nombre);
		$filter->link("/plantas/list","Lista de Plantas", "TR");
		$filter->link("/plantas/horas_weekend/".$id_planta."/crud","Agregar Hora", "TR");
		$grid = DataGrid::source($filter);
	    $grid->attributes(array("class"=>"table table-striped"));
	    $grid->add('hora_planta','Hora', true);
	    $grid->edit(url().'/plantas/horas_weekend/'.$id_planta.'/crud', 'Borrar/Editar','modify|delete');

		return View::make('planta_hora/list', compact('filter', 'grid'));
	}

	public function CrudPlantasHorasWeekend($id){
        $edit = DataEdit::source(new PlantasHorasWeekend());
        $edit->link("/plantas/horas_weekend/".$id."/list","Lista Horas", "TR")->back();
        $edit->add('hora_planta','Hora', 'text')->rule('required');
        $edit->add('id_planta', '', 'hidden')->insertValue($id);

        return $edit->view('planta_hora/crud', compact('edit'));
    }


	public function HorasDisponibles($fecha, $planta, $patente, $convenio){


		$horas = PlantasHoras::where('id_planta', $planta)->lists('hora_planta');

		if($this->isWeekend($fecha)){
			$horas = PlantasHorasWeekend::where('id_planta', $planta)->lists('hora_planta');
		}


		/*if($planta == '1'){
			$horas = array(
				'08:00','08:30',
				'09:00','09:30',
				'10:00','10:30',
				'11:00','11:30',
				'12:00','12:30',
				'13:00','15:00',
				'15:30','16:00',
				'16:30','17:00',
				'17:30'
				);	
			if($this->isWeekend($fecha)){
				$horas = array(
						'08:30',
				'09:00','09:30',
				'10:00','10:30',
				'11:00','11:30',
				'12:00','12:30',
				'13:00'
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
			'16:00','16:30'
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
				'18:30'
				);	
			if($this->isWeekend($fecha)){
				$horas = array(
				'09:00','09:30',
				'10:00','10:30',
				'11:00','11:30',
				'12:00','12:30',
				'13:00','13:30'
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
				'17:00','17:30'
				);
			if($this->isWeekend($fecha)){
				$horas = array(
				'09:00','09:30',
				'10:00','10:30',
				'11:00','11:30',
				'12:00','12:30',
				'13:00','13:30'
				);
			}
		}
		if($planta == '6'){
			$horas = array(
				'08:00','08:15',
				'08:30','08:45',
				'09:00','09:15',
				'09:30','09:45',
				'10:00','10:15',
				'10:30','10:45',
				'11:00','11:15',
				'11:30','11:45',
				'12:00','12:15',
				'12:30','12:45',
				'13:00','13:15',
				'13:30','13:45',
				'14:00','14:15',
				'14:30','14:45',
				'15:00','15:15',
				'15:30','15:45',
				'16:00','16:15',
				'16:30','16:45',
				'17:00','17:15',
				'17:30'
				);
			if($this->isWeekend($fecha)){
				$horas = array(
				'08:00','08:15',
				'08:30','08:45',
				'09:00','09:15',
				'09:30','09:45',
				'10:00','10:15',
				'10:30','10:45',
				'11:00','11:15',
				'11:30','11:45',
				'12:00','12:15',
				'12:30','12:45',
				'13:00','13:15',
				'13:30','13:45',
				'14:00','14:15',
				'14:30','14:45',
				'15:00','15:15',
				'15:30'
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
				'17:00','17:30'
				);
			if($this->isWeekend($fecha)){
				$horas = array(
				'08:30',
				'09:00','09:30',
				'10:00','10:30',
				'11:00','11:30',
				'12:00','12:30',
				'13:00'
				);
			}
		}
		if($planta == '8'){
			$horas = array(
				'09:00','09:30',
				'10:00','10:30',
				'11:00','11:30',
				'12:00','12:30',
				'13:00','13:30',
				'14:00','14:30',
				'15:00','15:30',
				'16:00','16:30',
				'17:00','17:30'
				);
			if($this->isWeekend($fecha)){
				$horas = array(
				'09:00','09:30',
				'10:00','10:30',
				'11:00','11:30',
				'12:00','12:30',
				'13:00'
				);
			}
		}*/
		$nombre_planta = Plantas::find($planta)->nombre;
		if($convenio == '1'){
		$horas_ocupadas = HorasConvenio::where('horas_convenio.fecha', $fecha)
						->join('fechas_reservas_convenio', 'horas_convenio.id_fecha', '=', 'fechas_reservas_convenio.id')
						->where('fechas_reservas_convenio.planta', $nombre_planta)
						->lists('horas_convenio.horas');
		}else{
		$horas_ocupadas = Horas::where('horas.fecha', $fecha)
						->join('fechas_reservas', 'horas.id_fecha', '=', 'fechas_reservas.id')
						->where('fechas_reservas.planta', $nombre_planta)
						->lists('horas.horas');
		}

		$horas_reservar = array();
		foreach($horas as $item){
			$key = array_search($item, $horas_ocupadas);
			if ($key === false) {
				$horas_reservar[] = $item;
			}
		}

		return View::make('home.horas')->with('horas_reservar', $horas_reservar )
										->with('fecha', $fecha)
										->with('nombre_planta', $nombre_planta)
										->with('convenio', $convenio)
										->with('patente', $patente)
										->with('planta', $planta);
	}


	public function Reservar(){
		$id_planta = Input::get('planta');
		$fecha = Input::get('fecha');
		$hora = Input::get('hora');
		$planta = Plantas::find($id_planta)->nombre;
		$nombre = Input::get('nombre');
		$email = Input::get('email');
		$telefono = Input::get('telefono');
		$patente = Input::get('patente');
		$comentario = '';
		$convenio = Input::get('convenio');
		$tipo_vehiculo = Input::get('tipo_vehiculo');
		$tipo_revision = Input::get('tipo_revision');
		$ip = '';
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
		    $ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
		    $ip = $_SERVER['REMOTE_ADDR'];
		}


		$count_reserva = Reservas::where('email', $email)
							->where('patente', $patente)
							->where('fecha', $fecha)->count();
		
		if($count_reserva == 0)
		{
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
		$reserva->ip = $ip;
		$reserva->save();
		
		if($convenio == '1'){
		$num_fecha = HorasConvenio::where('fecha', $fecha)->where('id_planta', $id_planta)->count();
		}else{
		$num_fecha = Horas::where('fecha', $fecha)->where('id_planta', $id_planta)->count();
		}
		//crear tabla horas por planta y asignar las horas de cada planta
		//cada vez q se llenen las horas comparar según planta y ver el total de horas reservadas
		//si son iguales, se debe agregar lleno al día
		$lleno = 0;
		$num_total = PlantasHoras::where('id_planta', $id_planta)->count();
	
		if($num_fecha >= $num_total){
			$lleno = 1;
		}

		if($convenio == '1'){
			$fechas = new FechasReservasConvenio;
			$fechas->fecha = $fecha;
			$fechas->lleno = $lleno;
			$fechas->planta = $planta;
			$fechas->id_reservas = $reserva->id;
			$fechas->save();
		}else{
			$fechas = new FechasReservas;
			$fechas->fecha = $fecha;
			$fechas->lleno = $lleno;
			$fechas->planta = $planta;
			$fechas->id_reservas = $reserva->id;
			$fechas->save();
		}
		
		if($convenio == '1'){
			$horas = new HorasConvenio;
			$horas->horas = $hora;
			$horas->fecha = $fecha;
			$horas->id_fecha = $fechas->id;
			$horas->id_planta = $id_planta;
			$horas->save();
		}else{
			$horas = new Horas;
			$horas->horas = $hora;
			$horas->fecha = $fecha;
			$horas->id_fecha = $fechas->id;
			$horas->id_planta = $id_planta;
			$horas->save();
		}

		 $data = array(
          		"nombre"=>$nombre,
                "fecha"=>$fecha,
                "email"=>$email,
                "hora"=>$hora,
                "planta"=>$planta,
                "tipo_vehiculo"=>$tipo_vehiculo,
                "patente"=>$patente
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
        //agregar validaciones para enviar el correo según planta
        $emails = array('dan.avila7@gmail.com');
        switch (Input::get('planta')) {
        	case '1':
        		$emails = array('placillab@sandamaso.cl');
        		break;
        	case '2':
        		$emails = array('antofagasta@sandamaso.cl');
        		break;
        	case '3':
        		$emails = array('calama@sandamaso.cl');        		
        		break;
        	case '4':
        		$emails = array('ing.godoy@hotmail.com');
        		break;
        	case '5':
        		$emails = array('copiapo@sandamaso.cl');
        		break;
        	case '6':
        		$emails = array('quilicura@sandamaso.cl');
        		break;
        	case '7':
        		$emails = array('salto@sandamaso.cl');
        		break;
        	case '8':
        		$emails = array('colina@sandamaso.cl');
        		break;
        	default:
        		$emails = array('dan.avila7@gmail.com');
        		break;
        }
		
			Mail::send('emails.emailadmin', $dataadmin, function($message) use ($emails){
	          	$message->from('no-reply@sandamaso.cl', 'San Damaso - Admin');
	            $message->to($emails, 'test')->subject('Nueva Reserva');
	        });

	        return View::make('home.reservado')->with('nombre', $nombre)
										->with('fecha', $fecha)
										->with('planta', $planta)
										->with('email', $email)
										->with('hora', $hora);
		}else{

			 return View::make('home.ocupada');
		}
		
	}
}
