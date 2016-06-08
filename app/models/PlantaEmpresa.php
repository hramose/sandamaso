<?php
class PlantaEmpresa extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'planta_empresa';
	public $timestamps = false;

	public function empresas(){
        return $this->belongsTo('Empresas', 'id_empresa');
    }

}