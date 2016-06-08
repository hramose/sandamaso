<?php
class Empresas extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'empresas';
	public $timestamps = false;


	public function empresas()
	{
	    return $this->belongsToMany('Plantas', 'planta_empresa', 
	      'id_empresa', 'id_planta');
	}

}