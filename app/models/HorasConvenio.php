<?php
class HorasConvenio extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'horas_convenio';
	public $timestamps = false;

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */

	public function fechas_reservas(){
        return $this->belongsTo('FechasReservasConvenio', 'id_fecha');
    }

}