<?php

namespace App\Models;

use App\BaseModel;

class IncomingManualDetail extends BaseModel
{
  protected $table = 'log_incoming_manual_detail';

  public function header()
  {
    return $this->belongsTo('App\Models\IncomingManualHeader', 'arrival_no', 'arrival_no_header');
  }

  public function model_data()
  {
    return $this->belongsTo('App\Models\MasterModel', 'model', 'model_name');
  }

  public function storage()
  {
    return $this->belongsTo('App\Models\StorageMaster', 'storage_id', 'id');
  }

  public function serial_numbers()
  {
    return $this->hasMany('App\Models\IncomingManualOtherSN', 'manual_id', 'id');
  }
}
