<?php

namespace App\Models;

use App\BaseModel;

class DamageGoodsReport extends BaseModel
{
   //Set Table
   protected $table = "dur_dgr";

   public function damagegoodsreport()
   {
      return $this->belongsTo('App\Models\DamageGoodsReport');
   }

   public function Model()
   {
      return $this->belongsTo('App\Models\MasterModel', 'model_name', 'model_name');
   }

   public function details()
   {
      return $this->hasMany('App\Models\DamageGoodsReportDetail', 'dur_dgr_id');
   }
}
