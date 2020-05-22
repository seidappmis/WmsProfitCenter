<?php

namespace App\Models;

use App\BaseModel;;

class FreightCost extends BaseModel
{
    //Set Table
    protected $table = "log_freight_cost";

    /**
     * Get the Area.
     */
    public function Area()
    {
        return $this->belongsTo('App\Models\Area', 'area');
    }
}
