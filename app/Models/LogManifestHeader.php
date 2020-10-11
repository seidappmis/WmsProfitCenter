<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\LogManifestDetail;
use DB;

class LogManifestHeader extends Model
{
  protected $table      = 'log_manifest_header';
  protected $primaryKey = 'do_manifest_no';
  public $incrementing  = false;

  public function details()
  {
    return $this->hasMany('App\Models\LogManifestDetail', 'do_manifest_no', 'do_manifest_no');
  }

  public function getUnconfirmedDetails()
  {
    return $this
      ->details
      ->where('status_confirm', 0)
      ->whereIn('kode_cabang', auth()->user()->getStringGrantCabang())
    ;
  }

  /**
   * Status Manifest Normal:
   * 1. Create Manifest --> DO Items Not Found
   * 2. Create Manifest DO sudah masuk sebagian --> DO Items Not Found
   * 3. Create Manifest DO sudah masuk semua --> Ready To Complete
   * 4. Manifest dicomplete --> Complete & Waitng Confirm
   * 5. Manifest Partial DO confirm --> Partial D/O Confirmed
   * 6. Manifest Full DO confirm --> Full D/O Confirmed
   *
   * @return [type] [status]
   */
  public function status()
  {
    $total_detail_tcs_do      = $this->lmb->do_details->count();
    // $total_detail_manifest_do = $this->details->count();
    $total_detail_manifest_do = LogManifestDetail::select(DB::raw('COUNT(id) AS countManifestDO'))
    ->leftjoin('log_manifest_header', 'log_manifest_header.do_manifest_no', '=', 'log_manifest_detail.do_manifest_no')
    ->where('log_manifest_header.driver_register_id', $this->driver_register_id)
    ->first()->countManifestDO;
    $total_unconfirm_detail   = LogManifestDetail::select(DB::raw('COUNT(id) AS countUnconfirmDetail'))
    ->leftjoin('log_manifest_header', 'log_manifest_header.do_manifest_no', '=', 'log_manifest_detail.do_manifest_no')
    ->where('log_manifest_header.driver_register_id', $this->driver_register_id)
    ->where('log_manifest_detail.status_confirm', 0)
    ->first()->countUnconfirmDetail;

    // if ($total_detail_tcs_do > $total_detail_manifest_do) {
    if ($total_detail_manifest_do == 0) {
      return '<span class="red-text">DO Items Not Found</span>';
    } elseif ($total_detail_tcs_do > $total_detail_manifest_do) {
      return '<span class="red-text">Not sign all DO Items</span>';
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

  public function lmb()
  {
    return $this->belongsTo('App\Models\LMBHeader', 'driver_register_id', 'driver_register_id');
  }

  public function picking()
  {
    return $this->belongsTo('App\Models\PickinglistHeader', 'driver_register_id', 'driver_register_id');
  }

  
}
