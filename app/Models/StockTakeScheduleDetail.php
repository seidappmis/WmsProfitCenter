<?php

namespace App\Models;

use App\BaseModel;

class StockTakeScheduleDetail extends BaseModel
{
    //Set Table
    protected $table = "log_stocktake_schedule_detail";

    public function schedules()
  	{
    	return $this->belongsTo('App\Models\StockTakeSchedule', 'sto_id', 'sto_id');
  	}
}
