<?php
class Horas extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'horas';
	public $timestamps = false;

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */

	public function fechas_reservas(){
        return $this->belongsTo('FechasReservas', 'id_fecha');
    }

}