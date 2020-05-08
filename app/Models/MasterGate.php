<?php

namespace App\Models;

use App\BaseModel;

class MasterGate extends BaseModel
{
  // Set Table Primary Key
  // if not set default : id
  protected $primaryKey = 'gate_number';

  /**
     * Get the Area that owns the Gate.
     */
    public function MasterArea()
    {
        return $this->belongsTo('App\Models\MasterArea', 'area_code');
    }
}
