<?php

namespace App\Models;

use App\BaseModel;

class Gate extends BaseModel
{
    //Set Table
    protected $table = "tr_gate";

    /**
     * Get the Area that owns the Gate.
     */
    public function Area()
    {
        return $this->belongsTo('App\Models\Area', 'area');
    }
}
