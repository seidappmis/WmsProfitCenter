<?php

namespace App\Models;

use App\BaseModel;

class MasterDriver extends BaseModel
{
   protected $table = "master_driver";
   protected $primaryKey="dirver_id";
   public $incrementing=false;
   public function expedition()
   {
       return $this->belongsTo('App\Models\MasterExpedition','expedition_code','code');
   }
}
