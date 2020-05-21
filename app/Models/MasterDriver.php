<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterDriver extends BaseModel
{
   protected $table = "master_driver";
   protected $primaryKey="dirver_id";
   public $incrementing=false;
   public function expedition()
   {
       return $this->belongTo('App\Models\MasterExpedition','expedition_name','expedition_name');
   }
}
