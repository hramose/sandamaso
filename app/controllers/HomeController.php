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
		return View::make('home.home')->with('fechas_reservar','')
									->with('planta', '')
									->with('fecha_desde', $fecha_desde)
									->with('fecha_hasta', '');
	}

	public function BuscarReserva(){
		$planta = Input::get('planta');
		$fecha_desde = Input::get('fecha_desde');
		$fecha_hasta = Input::get('fecha_hasta');
		$start = date("Y-m-d", strtotime($fecha_desde));
		$end = date("Y-m-d", strtotime($fecha_hasta));

		$start = new DateTime($start);
		$end = new DateTime($end);
		
		$fechas = FechasReservas::whereBetween('fecha', array($start, $end))
								->where('lleno', 1)
								->where('planta', $planta)
								->lists('fecha');
		
		$oneday = new DateInterval("P1D");

		//dias de la semana que calzan en las fechas
		$days = array();
		foreach(new DatePeriod($start, $oneday, $end->add($oneday)) as $day) {
		    $day_num = $day->format("N");
		    if($day_num < 6) { 
		        $days[] = $day->format("Y-m-d");
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
									->with('planta', $planta)
									->with('fechas_reservar', $fechas_reservar);
	}

	public function HorasDisponibles($fecha, $planta){
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
			'19:00','19:30',
			'20:00','20:30'
			);
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
										->with('planta', $planta);
	}


	public function Reservar(){
		$fecha = Input::get('fecha');
		$hora = Input::get('hora');
		$planta = Input::get('planta');
		$nombre = Input::get('nombre');
		$email = Input::get('email');
		$telefono = Input::get('telefono');
		$patente = Input::get('patente');
		$comentario = Input::get('comentario');
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

		return View::make('home.reservado')->with('nombre', $nombre)
										->with('fecha', $fecha)
										->with('email', $email)
										->with('hora', $hora);
	}
}
