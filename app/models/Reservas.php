<?php
class Reservas extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'reservas';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	public function fechas_reservas(){
        return $this->hasMany('FechasReservas', 'id_reservas');
    }

    public function fechas_reservas_convenio(){
        return $this->hasOne('FechasReservasConvenio', 'id_reservas');
    }
}