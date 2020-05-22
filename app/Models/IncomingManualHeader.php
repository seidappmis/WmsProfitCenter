<?php

namespace App\Models;

use App\BaseModel;

class IncomingManualHeader extends BaseModel
{
  protected $table      = 'log_incoming_manual_header';
  protected $primaryKey = 'arrival_no';
  public $incrementing  = false;

  public function details()
  {
    return $this->hasMany('App\Models\IncomingManualDetail', 'arrival_no', 'arrival_no_header');
  }
}
