<?php

class BuscadorController extends BaseController {

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

	public function SaveSessionIdEmpresa(){
		Session::put('id_empresa', Input::get('id'));			
		return Response::json(Session::get('id_empresa'));
	}


	public function BuscarReserva(){
		//TODO CUANDO NO HAY HORAS INGRESADDAS EN LA BD IGUAL TIRA LAS FECHAS
		// ESTÁ BIEN PARA EL CLIENTE PERO HAY Q VER POR Q HACE ESO
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
			Session::forget('id_empresa');
		}
		
		$start = date("Y-m-d", strtotime($fecha_desde));
		$end = date("Y-m-d", strtotime($fecha_hasta));
		
		$plantas = Plantas::all();

		$start = new DateTime($start);
		$end = new DateTime($end);

		$id_empresa = Session::get('id_empresa');
		
		// cada reserva por convenio debe guardar el id de la empresa en BD

		// pregunto por cada día cuantas reservas se hicieron para esa empresa

		// si es menor al numero de limite dejo reservar
		// si es igual al limite no muestro ese día
		
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
		$carga = 0;
		if($count > 0)
		{
			$carga = 1;
		}

		return View::make('home.home')->with('fecha_desde', $fecha_desde )
									->with('fecha_hasta', $fecha_hasta)
									->with('convenio', $convenio)
									->with('planta', $planta->nombre)
									->with('id_planta', $id_planta)
									->with('plantas', $plantas)
									->with('patente', $patente)
									->with('carga', $carga)
									->with('fechas_reservar', $fechas_reservar);
	}

	public function HorasDisponibles($fecha, $planta, $patente, $convenio){


		$horas = PlantasHoras::where('id_planta', $planta)->lists('hora_planta');
		
		$nombre_empresa = '';
		if(Session::get('id_empresa') !== NULL)
		{
			$nombre_empresa = Empresas::find(Session::get('id_empresa'))->nombre;
		}		

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
										->with('nombre_empresa', $nombre_empresa)
										->with('planta', $planta);
	}

	function isWeekend($date) {
    	return (date('N', strtotime($date)) >= 6);
	}


}
