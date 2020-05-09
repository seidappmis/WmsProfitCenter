<?php

namespace App\Models;

use App\BaseModel;

class Gate extends BaseModel
{
    /**
     * Get the Area that owns the Gate.
     */
    public function area()
    {
        return $this->belongsTo('App\Models\Area', 'area_id');
    }
}
