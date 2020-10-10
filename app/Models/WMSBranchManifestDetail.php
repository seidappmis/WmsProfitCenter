<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WMSBranchManifestDetail extends Model
{
  protected $table = 'wms_branch_manifest_detail';

  public function status(){
    if ($this->status_confirm) {
      return 'Confirmed';
    }

    return '';
  }
}
