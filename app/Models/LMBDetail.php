<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LMBDetail extends Model
{
  protected $table      = 'wms_lmb_detail';
  protected $primaryKey = 'serial_number';
  public $incrementing  = false;

  public static function getSerialNumberTrace($request)
  {
    $LMB = LMBDetail::select('wms_lmb_detail.*', 'wms_lmb_header.kode_cabang', 'log_cabang.hq')
      ->leftjoin('wms_lmb_header', 'wms_lmb_header.driver_register_id', '=', 'wms_lmb_detail.driver_register_id')
      ->leftjoin('log_cabang', 'wms_lmb_header.kode_cabang', '=', 'log_cabang.kode_cabang')
      ->where('wms_lmb_detail.model', $request->input('model'))
      ->where('wms_lmb_detail.serial_number', $request->input('serial_number'))
      ->first();

    $isHQ = !empty($LMB->hq) ? $LMB->hq : 0;

    $serial_number = LMBDetail::select(
      'wms_lmb_detail.*',
      'wms_lmb_header.lmb_date',
      'log_cabang.kode_customer AS from',
      ($isHQ ? 'log_manifest_header.do_manifest_no' : 'wms_branch_manifest_header.do_manifest_no'),
      ($isHQ ? 'log_manifest_detail.actual_time_arrival' : 'wms_branch_manifest_detail.actual_time_arrival')
    )
      ->leftjoin('wms_lmb_header', 'wms_lmb_header.driver_register_id', '=', 'wms_lmb_detail.driver_register_id')
      ->leftjoin('log_cabang', 'wms_lmb_header.kode_cabang', '=', 'log_cabang.kode_cabang')
    ;

    if ($isHQ) {
      $serial_number->leftjoin('log_manifest_header', 'log_manifest_header.driver_register_id', '=', 'wms_lmb_detail.driver_register_id');
      $serial_number->leftjoin('log_manifest_detail', function ($join) {
        $join->on('log_manifest_header.do_manifest_no', '=', 'log_manifest_detail.do_manifest_no');
        $join->on('wms_lmb_detail.model', '=', 'log_manifest_detail.model');
        $join->on('wms_lmb_detail.delivery_no', '=', 'log_manifest_detail.delivery_no');
        $join->on('wms_lmb_detail.invoice_no', '=', 'log_manifest_detail.invoice_no');
      });
    } else {
      $serial_number->leftjoin('wms_branch_manifest_header', 'wms_branch_manifest_header.driver_register_id', '=', 'wms_lmb_detail.driver_register_id');
      $serial_number->leftjoin('wms_branch_manifest_detail', function ($join) {
        $join->on('wms_branch_manifest_header.do_manifest_no', '=', 'wms_branch_manifest_detail.do_manifest_no');
        $join->on('wms_lmb_detail.model', '=', 'wms_branch_manifest_detail.model');
        $join->on('wms_lmb_detail.delivery_no', '=', 'wms_branch_manifest_detail.delivery_no');
        $join->on('wms_lmb_detail.invoice_no', '=', 'wms_branch_manifest_detail.invoice_no');
      });
    }

    $serial_number->groupBy('wms_lmb_detail.serial_number');

    $serial_number->where('wms_lmb_detail.model', $request->input('model'));
    $serial_number->where('wms_lmb_detail.serial_number', $request->input('serial_number'));

    return $serial_number;
  }
}
