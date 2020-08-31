<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LOGConceptOverload extends Model
{
  protected $table      = "log_concept_overload";
  protected $primaryKey = ['invoice_no', 'line_no'];
  public $incrementing  = false;

  public $timestamps = false;
}
