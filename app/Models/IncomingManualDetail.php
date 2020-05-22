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
}
