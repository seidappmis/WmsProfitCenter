<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterDriver extends BaseModel
{
   public function master_expedition()
   {
       return $this->belongTo('App\Models\MasterExpedition','expedition_name');
   }
}
