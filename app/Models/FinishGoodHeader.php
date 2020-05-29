<?php

namespace App\Models;

use App\BaseModel;

class FinishGoodHeader extends BaseModel
{
    protected $table      = 'log_finish_good_header';
  	protected $primaryKey = 'receipt_no';
  	public $incrementing  = false;

  	public function details()
  	{
       return $this->hasMany('App\Models\FinishGoodDetail', 'receipt_no_header', 'receipt_no');
  	}

}
