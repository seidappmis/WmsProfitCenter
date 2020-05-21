<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BranchExpeditionVehicle extends Model
{
  protected $table = "wms_branch_expedition_vehicle";

  public function vehicle()
  {
    return $this->belongsTo('App\Models\VehicleDetail', 'vehicle_code_type', 'vehicle_code_type');
  }

  public function expedition()
  {
    return $this->belongsTo('App\Models\BranchExpedition', 'expedition_code', 'code');
  }

  public function destination_data()
  {
    return $this->belongsTo('App\Models\MasterDestination', 'destination', 'destination_number');
  }
}
