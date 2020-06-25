<?php

namespace App\Models;

use App\BaseModel;

class VehicleDetail extends BaseModel
{
    //Set Table
    //if not set default : vehicledetails
    protected $table = "tr_vehicle_type_detail";

    /**
     * Get the vehicle group that owns the vehicle detail.
     */
    public function vehicle()
    {
        return $this->belongsTo('App\Models\Vehicle');
    }
}
