<?php
class FechasReservas extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'fechas_reservas';
	public $timestamps = false;

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	 public function horas(){
        return $this->hasMany('Horas', 'id');
    }

    public function reservas(){
        return $this->belongsTo('Reservas', 'id_reservas');
    }

}