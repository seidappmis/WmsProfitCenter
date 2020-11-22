<?php

namespace App\Models;

use App\BaseModel;

class DamageGoodsReportDetail extends BaseModel
{
   //Set Table
   protected $table = "dur_dgr_detail";

   public function damagegoodsreport()
   {
      return $this->belongsTo('App\Models\DamageGoodsReportDetail');
   }

   public function Model()
   {
      return $this->belongsTo('App\Models\MasterModel', 'model_name', 'model_name');
   }
}
