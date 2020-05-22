<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DriverRegistered extends Model
{
  protected $table      = "tr_driver_registered";
  protected $primaryKey = 'id';
  public $incrementing  = false;

  public function vehicle()
   {
       return $this->belongsTo('App\Models\VehicleDetail','vehicle_code_type','vehicle_code_type');
   }
}
