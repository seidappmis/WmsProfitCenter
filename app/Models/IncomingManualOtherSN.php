<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IncomingManualOtherSN extends Model
{
	use HasCompositePrimaryKey;
  protected $table      = "log_incoming_manual_other_sn";
  protected $primaryKey = ['manual_id', 'serialnumber'];
  public $incrementing  = false;
}
