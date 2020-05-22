<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterVehicleExpedition extends Model
{
<<<<<<< HEAD
    //
=======
    //Set Table
    protected $table = "tr_vehicle_expedition";

    /**
     * Get the vehicle type.
     */
    public function VehicleDetail()
    {
        return $this->belongsTo('App\Models\VehicleDetail', 'vehicle_code_type', 'vehicle_code_type');
    }

    /**
     * Get the expedition.
     */
    public function MasterExpedition()
    {
        return $this->belongsTo('App\Models\MasterExpedition', 'expedition_code','code');
    }
>>>>>>> d1cdb8e83bc346942575886709760ef7480793b7
}
