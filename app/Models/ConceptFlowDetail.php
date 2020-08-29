<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConceptFlowDetail extends Model
{
  protected $table      = "tr_concept_flow_detail";
  protected $primaryKey = ['invoice_no', 'line_no'];
  public $incrementing  = false;
  public $timestamps    = false;
}
