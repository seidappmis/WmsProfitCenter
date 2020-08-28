<?php

namespace App\Models;

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
}
