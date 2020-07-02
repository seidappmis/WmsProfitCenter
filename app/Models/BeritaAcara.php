<?php

namespace App\Models;

use App\BaseModel;

class BeritaAcara extends BaseModel
{
    //Set Table
    protected $table = "clm_berita_acara";

    // Set Table Primary Key
  	// if not set default : id
  	// protected $primaryKey = 'berita_acara_id';

  	/**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    // protected $keyType = 'string';

    public function details()
  	{
    	return $this->hasMany('App\Models\BeritaAcaraDetail', 'berita_acara_id');
  	}

    public function Expedition()
    {
      return $this->belongsTo('App\Models\MasterExpedition', 'expedition_code', 'code');
    }

    public function Driver()
    {
      return $this->belongsTo('App\Models\MasterDriver', 'driver_name', 'driver_name');
    }

    public function Vehicle()
    {
      return $this->belongsTo('App\Models\MasterVehicleExpedition', 'vehicle_number', 'vehicle_number');
    }
}
