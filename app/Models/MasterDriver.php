<?php

namespace App\Models;

use App\BaseModel;

class MasterDriver extends BaseModel
{
   protected $table = "tr_driver";
   protected $primaryKey="driver_id";
   public $incrementing=false;
   public function expedition()
   {
       return $this->belongsTo('App\Models\MasterExpedition','expedition_code','code');
   }
}
