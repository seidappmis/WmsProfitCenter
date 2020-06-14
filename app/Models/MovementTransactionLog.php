<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modul :
 * Incoming > Incoming Import/OEM/ , Conform Manifest.
 * Outgoing > Complete
 * Inventory > Adjust Inventory Movement, Cancel Movement
 */
class MovementTransactionLog extends Model
{
  protected $table      = "wms_movement_transaction_log";
  protected $primaryKey = 'log_id';
  public $incrementing  = false;
}
