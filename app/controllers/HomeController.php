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
		return View::make('home.home')->with('fechas_reservar',array())
									->with('planta', '')
									->with('plantas', $plantas)
									->with('id_planta', '')
									->with('convenio', '')
									->with('patente', '')
									->with('carga', -1)
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

	function isWeekend($date) {
    	return (date('N', strtotime($date)) >= 6);
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
		
		$nombre_empresa = '';
		if(Session::get('id_empresa') !== NULL)
		{
			$nombre_empresa = Empresas::find(Session::get('id_empresa'))->nombre;
		}

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
		//si llegó a este punto ya pasó por los filtros de fechas y horas llenas así que se hace la reserva de inmediafo
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
		//saco el numero de horas para esta planta en este día
		$num_fecha = HorasConvenio::where('fecha', $fecha)->where('id_planta', $id_planta)->count();
		//saco el numero de horas para esta planta en esta fecha en este día
		$num_hora = HorasConvenio::where('fecha', $fecha)
									->where('id_planta', $id_planta)
									->where('horas', $hora)->count();
		}else{
		$num_fecha = Horas::where('fecha', $fecha)->where('id_planta', $id_planta)->count();
		$num_hora = Horas::where('fecha', $fecha)
						->where('id_planta', $id_planta)
						->where('horas', $hora)->count();
		}

		
		//si es con convenio el numero de horas por planta cambia a el numero de limite de horas por planta
		if($convenio == '1'){
			$id_empresa = Session::get('id_empresa');
			$planta_hora_num = Empresas::find($id_empresa)->limite;
		}else{
			$planta_hora_num = PlantasHoras::where('hora_planta', $hora)
							->where('id_planta', $id_planta)->first()
							->num_reservas;
			if($this->isWeekend($fecha)){
				$planta_hora_num = PlantasHorasWeekend::where('hora_planta', $hora)
								->where('id_planta', $id_planta)->first()
								->num_reservas;
			}
		}
		

		$lleno_hora = 0;
		//le sumo 1 a las horas por q es la hora que voy a guardar ahora
		//eso quiere decir que cuento la hora actual y la comparo con el numero de horas que permite la planta por día
		$num_hora = $num_hora+1;
		if($num_hora >= $planta_hora_num)
		{
			$lleno_hora = 1;
		}

		//crear tabla horas por planta y asignar las horas de cada planta
		//cada vez q se llenen las horas comparar según planta y ver el total de horas reservadas
		//si son iguales, se debe agregar lleno al día
		$lleno = 0;
		//este numero es mentiroso, se debería calcular el total de cupos por cada hora que exista
		if($convenio == '1'){
			$num_horas_planta = PlantasHoras::where('id_planta', $id_planta)->count();
			// por convenio = num de plantas * limite
			$num_total = $num_horas_planta * $planta_hora_num;
		}else{
			// sin convenio = guardo el numero de horas de cada planta y lo multiplico por 
			$horas_planta = PlantasHoras::where('id_planta', $id_planta)->get();
			if($this->isWeekend($fecha)){
				$horas_planta = PlantasHorasWeekend::where('id_planta', $id_planta)->get();
			}
			$count_horas = 0;
			foreach ($horas_planta as $hora_p) {
				$count_horas = $count_horas + $hora_p->num_reservas;
			}
			$num_total = $count_horas * PlantasHoras::where('id_planta', $id_planta)->count();	
		}
		
		//pregunto si el numero de fechas reservadas es igual al numero total de horas que se pueden reservar
		if($num_fecha >= $num_total){
			$lleno = 1;
		}

		if($convenio == '1'){
			$fechas = new FechasReservasConvenio;
			$fechas->fecha = $fecha;
			$fechas->lleno = $lleno;
			$fechas->planta = $planta->nombre;
			$fechas->id_reservas = $reserva->id;
			$fechas->id_empresa = Session::get('id_empresa');
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
               	"image_map" => $image_map,
               	"convenio" => $convenio,
               	"nombre_empresa" => $nombre_empresa
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
                "comentario"=>$comentario,
                "convenio" => $convenio,
                "nombre_empresa" => $nombre_empresa
                );
			//email al admin
			Mail::send('emails.emailadmin', $dataadmin, function($message) use ($email_admin){
	          	$message->from('no-reply@sandamaso.cl', 'San Damaso - Admin');
	            $message->to($email_admin, 'test')->subject('Nueva Reserva');
	        });

	        return View::make('home.reservado')->with('nombre', $nombre)
										->with('fecha', $fecha)
										->with('planta', $planta->nombre)
										->with('email', $email)
										->with('hora', $hora)
										->with('convenio', $convenio)
										->with('nombre_empresa', $nombre_empresa)
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
