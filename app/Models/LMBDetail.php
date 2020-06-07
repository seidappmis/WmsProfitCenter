<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LMBDetail extends Model
{
  protected $table      = 'wms_lmb_detail';
  protected $primaryKey = 'serial_number';
  public $incrementing  = false;
}
