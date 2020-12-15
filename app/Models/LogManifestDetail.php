<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

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

  public function status()
  {
    return $this->status_confirm ? 'Confirmed' : '';
  }

  public function do_print()
  {
    return !empty($this->do_internal) ? $this->do_internal : $this->delivery_no;
  }

  public static function listDO($do_manifest_no)
  {
    return LogManifestDetail::select(
      'log_manifest_detail.*',
      DB::raw('IF(log_manifest_detail.code_sales = "BR", log_cabang.long_description, log_manifest_detail.ship_to) AS ship_to'),
      'log_manifest_header.status_complete'
    )
      ->leftjoin('log_manifest_header', 'log_manifest_header.do_manifest_no', '=', 'log_manifest_detail.do_manifest_no')
      ->leftjoin('log_cabang', 'log_cabang.kode_cabang', '=', 'log_manifest_detail.kode_cabang')
      ->where('log_manifest_detail.do_manifest_no', $do_manifest_no)
      ->orderBy('log_manifest_detail.do_manifest_no')
    ;
  }
}
