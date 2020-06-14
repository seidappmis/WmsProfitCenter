<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdjustmentLog extends Model
{
  protected $table      = "wms_adjustment_log";
  protected $primaryKey = 'log_id';
  public $incrementing  = false;
}
