<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogManifestDetail extends Model
{
  protected $table = 'log_manifest_detail';

  public function getDesc()
  {
    if ($this->tcs) {
      return 'TCS';
    } elseif ($this->do_return) {
      return "Return";
    } else {
      return 'Manual';
    }
  }

  public static function listDO($do_manifest_no)
  {
    return LogManifestDetail::select('log_manifest_detail.*', 'log_manifest_header.status_complete')
        ->leftjoin('log_manifest_header', 'log_manifest_header.do_manifest_no', '=', 'log_manifest_detail.do_manifest_no')
        ->where('log_manifest_detail.do_manifest_no', $do_manifest_no)
        ;
  }
}
