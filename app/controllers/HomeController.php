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
		$plantas = Plantas::where('activa', 1)->get();
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
			//restricción para mostrar solo 25 días en adelante
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
		$filter = DataFilter::source(Reservas::orderBy('fecha', 'desc'));
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
    		$horasConvenio = HorasConvenio::where('id_fecha', $fechasConvenio->id)->delete();
    		$fechasConvenio->delete();
    	}

    	$fechas = FechasReservas::where('id_reservas', $id)->first();
    	if($fechas){
    		$horas = Horas::where('id_fecha', $fechas->id)->delete();
    		$fechas->delete();
    	}

    	return Redirect::to('reservas/list');

    }


    public function ListarPlantas(){

		$filter = DataFilter::source(new Plantas);
		$filter->label('Plantas');
		$filter->link('/plantas/crud', 'Crear Nueva Planta', 'TR');
		$filter->attributes(array('class'=>'form-inline'));
		$filter->add('nombre','Buscar por nombre', 'text');
		$filter->submit('Buscar');
		$filter->reset('Limpiar');
		$filter->build();

		$grid = DataGrid::source($filter);
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
        $edit->add('url_map','URL Mapa','text');
        $edit->add('image_map','Imagen Mapa', 'image')
                        ->rule('mimes:jpeg,png')
                        ->move('img/plantas/');
        $edit->add('email_admin','Correo Administrador','text')->rule('required');
        $edit->add('activa','Activa', 'checkbox');

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
	    $grid->add('num_reservas','Numero de Reservas', true);
	    $grid->edit(url().'/plantas/horas/'.$id_planta.'/crud', 'Editar/Borrar','modify|delete');

		return View::make('planta_hora/list', compact('filter', 'grid'));
	}

	public function CrudPlantasHoras($id){
        $edit = DataEdit::source(new PlantasHoras());
        $edit->link("/plantas/horas/".$id."/list","Lista Horas", "TR")->back();
        $edit->add('hora_planta','Hora', 'text')->rule('required');
        $edit->add('num_reservas','Numero de Reservas', 'text')->rule('required');
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
	    $grid->add('num_reservas','Numero de Reservas', true);
	    $grid->edit(url().'/plantas/horas_weekend/'.$id_planta.'/crud', 'Editar/Borrar','modify|delete');

		return View::make('planta_hora/list', compact('filter', 'grid'));
	}

	public function CrudPlantasHorasWeekend($id){
        $edit = DataEdit::source(new PlantasHorasWeekend());
        $edit->link("/plantas/horas_weekend/".$id."/list","Lista Horas", "TR")->back();
        $edit->add('hora_planta','Hora', 'text')->rule('required');
        $edit->add('num_reservas','Numero de Reservas', 'text')->rule('required');
        $edit->add('id_planta', '', 'hidden')->insertValue($id);

        return $edit->view('planta_hora/crud', compact('edit'));
    }


	public function HorasDisponibles($fecha, $planta, $patente, $convenio){


		$horas = PlantasHoras::where('id_planta', $planta)->lists('hora_planta');

		if($this->isWeekend($fecha)){
			$horas = PlantasHorasWeekend::where('id_planta', $planta)->lists('hora_planta');
		}
		$nombre_planta = Plantas::find($planta)->nombre;
		if($convenio == '1'){
		$horas_ocupadas = HorasConvenio::where('horas_convenio.fecha', $fecha)
						->join('fechas_reservas_convenio', 'horas_convenio.id_fecha', '=', 'fechas_reservas_convenio.id')
						->where('fechas_reservas_convenio.planta', $nombre_planta)
						->where('horas_convenio.lleno', 1)
						->lists('horas_convenio.horas');
		}else{
		$horas_ocupadas = Horas::where('horas.fecha', $fecha)
						->join('fechas_reservas', 'horas.id_fecha', '=', 'fechas_reservas.id')
						->where('fechas_reservas.planta', $nombre_planta)
						->where('horas.lleno', 1)
						->lists('horas.horas');
		}

		$horas_reservar = array();
		foreach($horas as $item){
			$key = array_search($item, $horas_ocupadas);
			if ($key === false) {
				$horas_reservar[] = $item;
			}
		}

		$num = mt_rand(1, 10);

		return View::make('home.horas')->with('horas_reservar', $horas_reservar )
										->with('fecha', $fecha)
										->with('nombre_planta', $nombre_planta)
										->with('convenio', $convenio)
										->with('patente', $patente)
										->with('num', $num)
										->with('planta', $planta);
	}


	public function Reservar(){
		$id_planta = Input::get('planta');
		$fecha = Input::get('fecha');
		$hora = Input::get('hora');
		$planta = Plantas::find($id_planta);
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
		$reserva->planta = $planta->nombre;
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
		$num_hora = HorasConvenio::where('fecha', $fecha)
									->where('id_planta', $id_planta)
									->where('horas', $hora)->count();
		}else{
		$num_fecha = Horas::where('fecha', $fecha)->where('id_planta', $id_planta)->count();
		$num_hora = Horas::where('fecha', $fecha)
						->where('id_planta', $id_planta)
						->where('horas', $hora)->count();
		}

		//lleno la hora de la reserva según el dato en la tabla Horas
		
		$planta_hora_num = PlantasHoras::where('hora_planta', $hora)
							->where('id_planta', $id_planta)->first()
							->num_reservas;
		if($this->isWeekend($fecha)){
			$planta_hora_num = PlantasHorasWeekend::where('hora_planta', $hora)
							->where('id_planta', $id_planta)->first()
							->num_reservas;
		}

		$lleno_hora = 0;
		$num_hora = $num_hora+1;
		if($num_hora >= $planta_hora_num)
		{
			$lleno_hora = 1;
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
			$fechas->planta = $planta->nombre;
			$fechas->id_reservas = $reserva->id;
			$fechas->save();
		}else{
			$fechas = new FechasReservas;
			$fechas->fecha = $fecha;
			$fechas->lleno = $lleno;
			$fechas->planta = $planta->nombre;
			$fechas->id_reservas = $reserva->id;
			$fechas->save();
		}
		
		if($convenio == '1'){
			$horas = new HorasConvenio;
			$horas->horas = $hora;
			$horas->fecha = $fecha;
			$horas->id_fecha = $fechas->id;
			$horas->id_planta = $id_planta;
			$horas->lleno = $lleno_hora;
			$horas->save();
		}else{
			$horas = new Horas;
			$horas->horas = $hora;
			$horas->fecha = $fecha;
			$horas->id_fecha = $fechas->id;
			$horas->id_planta = $id_planta;
			$horas->lleno = $lleno_hora;
			$horas->save();
		}

		//busca el correo por base de datos
		$email_admin = array('dan.avila7@gmail.com');
        $email_admin = $planta->email_admin;
        $url_map = $planta->url_map;
        $image_map = $planta->image_map;

		 $data = array(
          		"nombre"=>$nombre,
                "fecha"=>$fecha,
                "email"=>$email,
                "hora"=>$hora,
                "planta"=>$planta->nombre,
                "tipo_vehiculo"=>$tipo_vehiculo,
                "patente"=>$patente,
                "id_planta"=>$id_planta,
               	"url_map" => $url_map,
               	"image_map" => $image_map
                );

        //email al cliente
        $emails = array($email);
        Mail::send('emails.email', $data, function($message) use ($emails){
			$message->from('no-reply@sandamaso.cl', 'San Damaso - revisiones técnicas');	
			$message->to($emails, 'test')->subject('Reserva recibida');
        });
        	$dataadmin = array(
          		"nombre"=>$nombre,
                "fecha"=>$fecha,
                "email"=>$email,
                "hora"=>$hora,
                "planta"=>$planta->nombre,
                "patente"=>$patente,
                "convenio"=>$convenio,
                "tipo_vehiculo"=>$tipo_vehiculo,
                "tipo_revision"=>$tipo_revision,
                "telefono"=>$telefono,
                "email"=>$email,
                "comentario"=>$comentario
                );
		
			Mail::send('emails.emailadmin', $dataadmin, function($message) use ($email_admin){
	          	$message->from('no-reply@sandamaso.cl', 'San Damaso - Admin');
	            $message->to($email_admin, 'test')->subject('Nueva Reserva');
	        });

	        return View::make('home.reservado')->with('nombre', $nombre)
										->with('fecha', $fecha)
										->with('planta', $planta->nombre)
										->with('email', $email)
										->with('hora', $hora)
										->with('id_planta', $id_planta)
										->with('url_map', $url_map);
		}else{
			 return View::make('home.ocupada');
		}
		
	}


	public function EmailToShare(){

		$email = Input::get('email');
		$data = array();
		Mail::send('emails.share', $data, function($message) use ($email){
	          	$message->from('no-reply@sandamaso.cl', 'San Damaso');
	            $message->to($email, 'test')->subject('Reserva tu hora.');
	    });

		return Response::json(array('success' => 'true'));
	}
}
