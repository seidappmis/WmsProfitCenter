<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Concept extends Model
{
  protected $table      = "tr_concept";
  protected $primaryKey = ['invoice_no', 'line_no'];
  public $incrementing  = false;

  public function destination()
  {
    return $this->belongsTo('App\Models\MasterDestination', 'destination_number', 'destination_number');
  }

}
