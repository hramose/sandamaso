<?php

class InformesController extends BaseController {


	public function General($planta = null, $fecha_desde = null, $fecha_hasta = null){

		$reservas = Reservas::all();
		$start = new DateTime($fecha_desde);
		$end = new DateTime($fecha_hasta);
				if(isset($planta) && isset($fecha_desde)){
					$reservas = Reservas::where('planta', $planta)
								->whereBetween('fecha', array($start, $end))
								->select('nombre','email', 'telefono', 'patente', "convenio", 'tipo_vehiculo', 'planta', 'fecha', 'hora')->orderBy('hora')->get();
				}else{
					if(isset($planta) && !isset($fecha_desde)){
						$reservas = Reservas::where('planta', $planta)
						->select('nombre','email', 'telefono', 'patente', "convenio", 'tipo_vehiculo', 'planta', 'fecha', 'hora')->orderBy('hora')->get();
					}else{
						if(!isset($planta) && isset($fecha_desde)){
							$reservas = Reservas::whereBetween('fecha', array($start, $end))
							->select('nombre','email', 'telefono', 'patente', "convenio", 'tipo_vehiculo', 'planta', 'fecha', 'hora')->orderBy('hora')->get();
						}
					}
				}
		Excel::create('Reservas Generales', function($excel) use($reservas){
    		$excel->sheet('Reservas', function($sheet) use($reservas) {
	        	$sheet->fromModel($reservas);
	        	$sheet->setOrientation('landscape');
    		});
		})->export('xls');

	}

	public function GeneralFechas($fecha_desde = null, $fecha_hasta = null){

		$reservas = Reservas::all();
		$start = new DateTime($fecha_desde);
		$end = new DateTime($fecha_hasta);
				if(isset($planta) && isset($fecha_desde)){
					$reservas = Reservas::where('planta', $planta)
								->whereBetween('fecha', array($start, $end))
								->select('nombre','email', 'telefono', 'patente', "convenio", 'tipo_vehiculo', 'planta', 'fecha', 'hora')->orderBy('hora')->get();
				}else{
					if(isset($planta) && !isset($fecha_desde)){
						$reservas = Reservas::where('planta', $planta)
						->select('nombre','email', 'telefono', 'patente', "convenio", 'tipo_vehiculo', 'planta', 'fecha', 'hora')->orderBy('hora')->get();
					}else{
						if(!isset($planta) && isset($fecha_desde)){
							$reservas = Reservas::whereBetween('fecha', array($start, $end))
							->select('nombre','email', 'telefono', 'patente', "convenio", 'tipo_vehiculo', 'planta', 'fecha', 'hora')->orderBy('hora')->get();
						}
					}
				}
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


	public function SendRememberEmail(){

		$date_back = date("Y-m-d",strtotime('-1 day'));
		$reservas = Reservas::where('fecha', $date_back)->get();
		foreach ($reservas as $reserva) {
			
			$planta = Planta::where('nombre', $reserva->planta)->first();

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
		}
	}
}
