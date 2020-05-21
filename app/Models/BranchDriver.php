<?php

namespace App\Models;

use App\BaseModel;

class BranchDriver extends BaseModel
{
  protected $table      = "wms_branch_driver";
  protected $primaryKey = 'driver_id';
  public $incrementing  = false;

  public function expedition()
  {
    return $this->belongsTo('App\Models\BranchExpedition', 'expedition_code', 'code');
  }
}
