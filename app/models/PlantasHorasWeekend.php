<?php
class PlantasHorasWeekend extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'plantas_horas_weekend';
	public $timestamps = false;

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */

	public function plantas(){
        return $this->belongsTo('Plantas', 'id_planta');
    }

}