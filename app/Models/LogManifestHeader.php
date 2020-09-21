<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
      ->where('kode_cabang', auth()->user()->cabang->kode_cabang)
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
    $total_detail_manifest_do = $this->details->count();
    $total_unconfirm_detail   = $this->details->where('status_confirm', 0)->count();

    if ($total_detail_tcs_do > $total_detail_manifest_do) {
      return 'DO Items Not Found';
    } elseif ($this->status_complete && $total_unconfirm_detail == 0) {
      return 'Full D/O Confirmed';
    } elseif ($this->status_complete && $total_unconfirm_detail > 0) {
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
