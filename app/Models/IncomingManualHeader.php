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
    return $this->hasMany('App\Models\IncomingManualDetail', 'arrival_no_header', 'arrival_no');
  }

  public function serial_numbers()
  {
    return $this->hasManyThrough(
      'App\Models\IncomingManualOtherSN',
      'App\Models\IncomingManualDetail',
      'arrival_no_header', // Foreign key on trough table...
      'manual_id', // Foreign key on target table...
      'arrival_no', // Local key on this table...
      'id' // Local key on trough table...
    );
  }

}
