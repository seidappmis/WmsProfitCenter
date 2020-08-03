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

  /**
   * Status Manifest Normal:
   * DO Items Not Found Belum terdapat DO pada Manifest 
   * Complete & Waiting Confirm.  Semua DO telah di Assign, Menunggu Confirm Cabang 
   * Full D/O Confirm  Semua DO telah di Confirm oleh tujuan
   * Partial D/O Confirm  Sebagian DO telah di Confirm oleh Tujuan
   * 
   * @return [type] [status]
   */
  public function status()
  {
    if ($this->details->count() == 0) {
      return 'DO Items Not Found';
    } elseif ($this->status_complete) {
      return 'Complete';
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
