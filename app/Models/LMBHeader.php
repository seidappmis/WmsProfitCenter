<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LMBHeader extends Model
{
  protected $table      = 'wms_lmb_header';
  protected $primaryKey = 'driver_register_id';
  public $incrementing  = false;

  public function details()
  {
    return $this->hasMany('App\Models\LMBDetail', 'driver_register_id', 'driver_register_id');
  }

  public function do_details()
  {
    return $this->details()
      ->selectRaw('wms_lmb_detail.*, COUNT(serial_number) AS quantity, SUM(cbm_unit) as cbm, wms_pickinglist_detail.delivery_items, wms_pickinglist_detail.line_no, wms_pickinglist_detail.kode_customer')
      ->leftjoin('wms_pickinglist_detail', function ($join) {
        $join->on('wms_pickinglist_detail.invoice_no', '=', 'wms_lmb_detail.invoice_no');
        $join->on('wms_pickinglist_detail.delivery_no', '=', 'wms_lmb_detail.delivery_no');
        $join->on('wms_pickinglist_detail.header_id', '=', 'wms_lmb_detail.picking_id');
      })
      ->leftjoin('log_manifest_detail', function ($join) {
        $join->on('log_manifest_detail.invoice_no', '=', 'wms_lmb_detail.invoice_no');
        $join->on('log_manifest_detail.delivery_no', '=', 'wms_lmb_detail.delivery_no');
        $join->on('log_manifest_detail.delivery_items', '=', 'wms_pickinglist_detail.delivery_items');
      })
      ->whereNull('log_manifest_detail.id')
      ->groupByRaw('delivery_no, model')
    ;
  }

  public function picking()
  {
    return $this->belongsTo('App\Models\PickinglistHeader', 'driver_register_id', 'driver_register_id');
  }

  public static function noManifestLMBHeader()
  {
    return LMBHeader::selectRaw('wms_lmb_header.*')
      ->leftjoin('log_manifest_header', 'log_manifest_header.driver_register_id', '=', 'wms_lmb_header.driver_register_id')
      ->whereNull('log_manifest_header.driver_register_id') // yang belum ada Manifest
    // ->where('area', auth()->user()->area) // yang se area
    ;
  }

  public function cabang()
  {
    return $this->belongsTo('App\Models\MasterCabang', 'kode_cabang', 'kode_cabang');
  }

  public function driverRegistered()
  {
    return $this->belongsTo('App\Models\DriverRegistered', 'driver_register_id', 'id');
  }
}
