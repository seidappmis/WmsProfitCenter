<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterVehicleExpedition extends Model
{
    //Set Table
    protected $table = "tr_vehicle_expedition";


    public function VehicleDetail()
    {
        return $this->belongsTo('App\Models\VehicleDetail', 'vehicle_code_type', 'vehicle_code_type');
    }

    public function MasterExpedition()
    {
        return $this->belongsTo('App\Models\MasterExpedition', 'expedition_code', 'code');
    }

    public function destination_data()
    {
        return $this->belongsTo('App\Models\MasterDestination', 'destination', 'destination_number');
    }
}
