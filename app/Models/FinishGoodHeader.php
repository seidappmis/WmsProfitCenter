<?php

namespace App\Models;

use App\BaseModel;
use DB;

class FinishGoodHeader extends BaseModel
{
    protected $table      = 'log_finish_good_header';
  	protected $primaryKey = 'receipt_no';
  	public $incrementing  = false;

  	public function details()
  	{
       return $this->hasMany('App\Models\FinishGoodDetail', 'receipt_no_header', 'receipt_no');
  	}

    public function ticketNo(){
      return $this->details()->select(DB::raw('GROUP_CONCAT(DISTINCT log_finish_good_detail.bar_ticket_header) AS bar_ticket_header'))->first()->bar_ticket_header;
    }

}
