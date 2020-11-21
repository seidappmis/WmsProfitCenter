<?php

namespace App\Models;

use App\Models\WMSBranchManifestDetail;
use DB;
use Illuminate\Database\Eloquent\Model;

class WMSBranchManifestHeader extends Model
{
  protected $table      = 'wms_branch_manifest_header';
  protected $primaryKey = 'do_manifest_no';
  public $incrementing  = false;

  public function lmb()
  {
    return $this->belongsTo('App\Models\LMBHeader', 'driver_register_id', 'driver_register_id');
  }

  public function details()
  {
    return $this->hasMany('App\Models\WMSBranchManifestDetail', 'do_manifest_no', 'do_manifest_no');
  }

  public function getUnconfirmedDetails()
  {
    return $this
      ->details
      ->where('status_confirm', 0)
      ->whereIn('kode_cabang', auth()->user()->getStringGrantCabang())
    ;
  }

  public function picking()
  {
    return $this->belongsTo('App\Models\PickinglistHeader', 'driver_register_id', 'driver_register_id');
  }

  public function status()
  {
    $total_detail_tcs_do = $this->lmb->do_details->count();
    // $total_detail_manifest_do = $this->details->count();
    $total_detail_manifest_do = WMSBranchManifestDetail::select(DB::raw('COUNT(id) AS countManifestDO'))
      ->leftjoin('wms_branch_manifest_header', 'wms_branch_manifest_header.do_manifest_no', '=', 'wms_branch_manifest_detail.do_manifest_no')
      ->where('wms_branch_manifest_header.driver_register_id', $this->driver_register_id)
      ->first()->countManifestDO;
    $total_unconfirm_detail = WMSBranchManifestDetail::select(DB::raw('COUNT(id) AS countUnconfirmDetail'))
      ->leftjoin('wms_branch_manifest_header', 'wms_branch_manifest_header.do_manifest_no', '=', 'wms_branch_manifest_detail.do_manifest_no')
      ->where('wms_branch_manifest_header.driver_register_id', $this->driver_register_id)
      ->where('wms_branch_manifest_detail.status_confirm', 0)
      ->first()->countUnconfirmDetail;

    if ($total_detail_tcs_do > $total_detail_manifest_do) {
      return '<span class="red-text">DO Items Not Found</span>';
    } elseif ($this->status_complete && $total_unconfirm_detail == 0) {
      return 'Full D/O Confirmed';
    } elseif ($this->status_complete && $total_unconfirm_detail > 0 && $total_unconfirm_detail < $total_detail_manifest_do) {
      return 'Partial D/O Confirmed';
    } elseif ($this->status_complete) {
      return 'Complete & Waiting Confirm';
    } elseif (!$this->status_complete) {
      return 'Ready to Complete';
    } else {
      return '';
      // return 'Waiting D/O';
    }
  }
}
