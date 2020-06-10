<?php

namespace App\Models;

use App\BaseModel;

class StockTakeSchedule extends BaseModel
{
    //Set Table
    protected $table = "log_stocktake_schedule";

    // Set Table Primary Key
  	// if not set default : id
  	protected $primaryKey = 'sto_id';

  	/**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    public function details()
	{
	    return $this->hasMany('App\Models\StockTakeScheduleDetail', 'sto_id', 'sto_id');
	}
}
