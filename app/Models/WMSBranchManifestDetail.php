<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WMSBranchManifestDetail extends Model
{
  protected $table = 'wms_branch_manifest_detail';

  public function status()
  {
    if ($this->status_confirm) {
      return 'Confirmed';
    }

    return '';
  }

  public static function getDesc($data)
  {
    return $data->manifest_type == "REGULAR" ? 'NORMAL' : '';
  }

  public static function listDO($do_manifest_no)
  {
    return WMSBranchManifestDetail::select(
      'wms_branch_manifest_detail.*',
      'wms_branch_manifest_header.status_complete',
      'wms_branch_manifest_header.manifest_type'
    )
      ->leftjoin('wms_branch_manifest_header', 'wms_branch_manifest_header.do_manifest_no', '=', 'wms_branch_manifest_detail.do_manifest_no')
      ->where('wms_branch_manifest_detail.do_manifest_no', $do_manifest_no)
    ;
  }
}
