<?php

namespace App\Models;

use App\BaseModel;

class FinishGoodDetail extends BaseModel
{
    protected $table = 'log_finish_good_detail';

    public function header()
  	{
       return $this->belongsTo('App\Models\FinishGoodHeader', 'receipt_no', 'receipt_no_header');
  	}

  	public function storage()
  	{
    	return $this->belongsTo('App\Models\StorageMaster', 'storage_id', 'id');
  	}
}
