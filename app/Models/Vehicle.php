<?php

namespace App\Models;

use App\BaseModel;

class Vehicle extends BaseModel
{
    //Set Table
    //if not set default : vehicles
    protected $table = "vehicle_type_groups";

     /**
     * Get the vehicle details for the vehicle group.
     */
    public function details()
  	{
    	return $this->hasMany('App\Models\VehicleDetail', 'vehicle_group_id');
  	}
}
