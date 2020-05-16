<?php

namespace App\Models;

use App\BaseModel;

class VehicleDetail extends BaseModel
{
    //Set Table
    //if not set default : vehicledetails
    protected $table = "vehicle_type_details";

    /**
     * Get the vehicle group that owns the vehicle detail.
     */
    public function vehicle()
    {
        return $this->belongsTo('App\Models\Vehicle');
    }
}
