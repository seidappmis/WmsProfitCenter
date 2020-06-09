<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ManualConcept extends Model
{
  protected $table      = "wms_manual_concept";
  protected $primaryKey = ['invoice_no', 'delivery_no', 'delivery_items'];
  public $incrementing  = false;

  public function cabang()
  {
    return $this->belongsTo('App\Models\MasterModel', 'model_name', 'model');
  }
}
