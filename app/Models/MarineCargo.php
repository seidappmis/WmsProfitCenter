<?php

namespace App\Models;

use App\BaseModel;
use DB;

class MarineCargo extends BaseModel
{
   //Set Table
   protected $table = "dur_marine_cargo";

   public function details()
   {
      return \App\Models\BeritaAcaraDuringDetail::select(
         'dur_berita_acara_detail.*',
         'wms_master_model.price_carton_box'
      )
         ->leftjoin('dur_dgr_detail', 'dur_dgr_detail.berita_acara_during_detail_id', '=', 'dur_berita_acara_detail.id')
         ->leftjoin('wms_master_model', 'wms_master_model.model_name', '=', 'dur_berita_acara_detail.model_name')
         ->where('dur_dgr_detail.dur_dgr_id', $this->dur_dgr_id)
         ->orderBy('dur_berita_acara_detail.claim')
         ->orderBy('dur_berita_acara_detail.model_name')
         ->get();
   }

   // Penomoran Notice of Claim "<sequence>/SEID/ACC/<bulan>/<tahun>"
   public static function getNoticeOfClaimNo($dur_dgr_no)
   {
      $suffix = '/SEID/ACC/' . date('m') . '/' . date('Y');

      $marineCargo = MarineCargo::select('notice_of_claim_no')
         ->orderBy('created_at', 'desc')
         ->first();

      $lastNo = 0;

      if (empty($marineCargo)) {
         $notice_of_claim_no = [];
      } else {
         $notice_of_claim_no = explode('/', $marineCargo->notice_of_claim_no);
      }



      if (
         !empty($notice_of_claim_no[3])
         && $notice_of_claim_no[3] == date('m')
         && $notice_of_claim_no[4] == date('Y')
      ) {
         $lastNo = (int) $notice_of_claim_no[0];
      }

      $dgr = explode('/', $dur_dgr_no);

      // $max_no = str_pad($lastNo + 1, 3, 0, STR_PAD_LEFT);

      return $dgr[0] . $suffix;
   }

   public function dgr()
   {
      return $this->belongsTo('App\Models\DamageGoodsReport', 'dur_dgr_id');
   }

   public function getInvoiceNo()
   {
      return \App\Models\BeritaAcaraDuringDetail::select(
         DB::raw('GROUP_CONCAT(DISTINCT dur_berita_acara.invoice_no SEPARATOR ",") AS invoice_no')
      )
         ->leftjoin('dur_berita_acara', 'dur_berita_acara.id', '=', 'dur_berita_acara_detail.berita_acara_during_id')
         ->leftjoin('dur_dgr_detail', 'dur_dgr_detail.berita_acara_during_detail_id', '=', 'dur_berita_acara_detail.id')
         ->where('dur_dgr_detail.dur_dgr_id', $this->dur_dgr_id)
         ->first()
         ->invoice_no;
   }
   public function getBLNo()
   {
      return \App\Models\BeritaAcaraDuringDetail::select(
         DB::raw('GROUP_CONCAT(DISTINCT dur_berita_acara.bl_no SEPARATOR ",") AS bl_no')
      )
         ->leftjoin('dur_berita_acara', 'dur_berita_acara.id', '=', 'dur_berita_acara_detail.berita_acara_during_id')
         ->leftjoin('dur_dgr_detail', 'dur_dgr_detail.berita_acara_during_detail_id', '=', 'dur_berita_acara_detail.id')
         ->where('dur_dgr_detail.dur_dgr_id', $this->dur_dgr_id)
         ->first()
         ->bl_no;
   }

   public function getNatureOfClaim()
   {
      return \App\Models\BeritaAcaraDuringDetail::select(
         DB::raw('GROUP_CONCAT(DISTINCT dur_berita_acara_detail.category_damage SEPARATOR ",") AS category_damage')
      )
         ->leftjoin('dur_dgr_detail', 'dur_dgr_detail.berita_acara_during_detail_id', '=', 'dur_berita_acara_detail.id')
         ->where('dur_dgr_detail.dur_dgr_id', $this->dur_dgr_id)
         ->first()
         ->category_damage;
   }
}
