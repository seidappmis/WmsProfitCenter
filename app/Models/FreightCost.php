<?php

namespace App\Models;

use App\BaseModel;;

class FreightCost extends BaseModel
{
    //Set Table
    protected $table = "log_freight_cost";

    /**
     * Get the Area.
     */
    public function Area()
    {
        return $this->belongsTo('App\Models\Area', 'area');
    }

    /**
     * Get the destination city.
     */
    public function DestinationCity()
    {
        return $this->belongsTo('App\Models\DestinationCity', 'city_code');
    }

    /**
     * Get the expedition.
     */
    public function MasterExpedition()
    {
        return $this->belongsTo('App\Models\MasterExpedition', 'expedition_code');
    }

    /**
     * Get the vehicle type.
     */
    public function VehicleDetail()
    {
        return $this->belongsTo('App\Models\VehicleDetail', 'vehicle_code_type');
    }
}
