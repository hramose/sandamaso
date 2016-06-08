<?php
class Plantas extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'plantas';
	public $timestamps = false;

	public function empresas()
	{
	    return $this->belongsToMany('Empresas', 'planta_empresa', 
	      'id_planta', 'id_empresa');
	}

}