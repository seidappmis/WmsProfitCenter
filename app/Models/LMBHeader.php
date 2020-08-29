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

  // public function do_details()
  // {
  //   return $this->details()
  //     ->selectRaw('wms_lmb_detail.*, COUNT(serial_number) AS quantity, SUM(cbm_unit) as cbm, wms_pickinglist_detail.delivery_items, wms_pickinglist_detail.line_no, wms_pickinglist_detail.kode_customer')
  //     ->leftjoin('wms_pickinglist_detail', function ($join) {
  //       $join->on('wms_pickinglist_detail.invoice_no', '=', 'wms_lmb_detail.invoice_no');
  //       $join->on('wms_pickinglist_detail.delivery_no', '=', 'wms_lmb_detail.delivery_no');
  //       $join->on('wms_pickinglist_detail.header_id', '=', 'wms_lmb_detail.picking_id');
  //     })
  //     ->leftjoin('log_manifest_detail', function ($join) {
  //       $join->on('log_manifest_detail.invoice_no', '=', 'wms_lmb_detail.invoice_no');
  //       $join->on('log_manifest_detail.delivery_no', '=', 'wms_lmb_detail.delivery_no');
  //       $join->on('log_manifest_detail.delivery_items', '=', 'wms_pickinglist_detail.delivery_items');
  //     })
  //     ->whereNull('log_manifest_detail.id')
  //     ->groupByRaw('delivery_no, model')
  //   ;
  // }

  // DO DETAIL FROM TCS
  public function do_details()
  {
    $details = $this->details()
      ->selectRaw('wms_lmb_detail.*, COUNT(serial_number) AS quantity, SUM(cbm_unit) as cbm, wms_pickinglist_detail.delivery_items, wms_pickinglist_detail.line_no, wms_pickinglist_detail.kode_customer')
      ->leftjoin('wms_pickinglist_detail', function ($join) {
        $join->on('wms_pickinglist_detail.invoice_no', '=', 'wms_lmb_detail.invoice_no');
        $join->on('wms_pickinglist_detail.delivery_no', '=', 'wms_lmb_detail.delivery_no');
        $join->on('wms_pickinglist_detail.header_id', '=', 'wms_lmb_detail.picking_id');
      })
    ;

    if ($this->cabang->hq) {
      $details->leftjoin('log_manifest_detail', function ($join) {
        $join->on('log_manifest_detail.invoice_no', '=', 'wms_lmb_detail.invoice_no');
        $join->on('log_manifest_detail.delivery_no', '=', 'wms_lmb_detail.delivery_no');
        $join->on('log_manifest_detail.delivery_items', '=', 'wms_pickinglist_detail.delivery_items');
      })
        ->whereNull('log_manifest_detail.id')
        ->groupByRaw('delivery_no, model');
    } else {
      $details->leftjoin('wms_branch_manifest_detail', function ($join) {
        $join->on('wms_branch_manifest_detail.invoice_no', '=', 'wms_lmb_detail.invoice_no');
        $join->on('wms_branch_manifest_detail.delivery_no', '=', 'wms_lmb_detail.delivery_no');
        $join->on('wms_branch_manifest_detail.delivery_items', '=', 'wms_pickinglist_detail.delivery_items');
      })
        ->whereNull('wms_branch_manifest_detail.id')
        ->groupByRaw('delivery_no, model');
    }

    return $details;
  }

  public function getCustomer()
  {
    $pickingDetail = $this->picking->details;
    $customer      = '';
    foreach ($pickingDetail as $key => $value) {
      $customer .= $value->customer();
    }
    return $customer;
  }

  public function picking()
  {
    return $this->belongsTo('App\Models\PickinglistHeader', 'driver_register_id', 'driver_register_id');
  }

  public function getPickingNo($data){
    $rs_pickinglistHeader = \App\Models\PickinglistHeader::where('driver_register_id', $data->driver_register_id)->get();
    $picking_no = '';
    foreach ($rs_pickinglistHeader as $key => $value) {
      $picking_no .= !empty($picking_no) ? ', ' : '';
      $picking_no .= $value->picking_no;
    }
    return $picking_no;
  }

  public static function noManifestLMBHeader()
  {
    $lmbHeader = LMBHeader::selectRaw('wms_lmb_header.*')
    ->where('wms_lmb_header.kode_cabang', auth()->user()->cabang->kode_cabang);

    if (auth()->user()->cabang->hq) {
      $lmbHeader->leftjoin('log_manifest_header', 'log_manifest_header.driver_register_id', '=', 'wms_lmb_header.driver_register_id')
        ->whereNull('log_manifest_header.driver_register_id') // yang belum ada Manifest
        ->leftjoin('tr_driver_registered', 'tr_driver_registered.id', '=', 'log_manifest_header.driver_register_id')
        ->whereNotNull('tr_driver_registered.id')
      ;
    } else {
      $lmbHeader->leftjoin('wms_branch_manifest_header', 'wms_branch_manifest_header.driver_register_id', '=', 'wms_lmb_header.driver_register_id')
        ->whereNull('wms_branch_manifest_header.driver_register_id') // yang belum ada Manifest
      ;
    }
    // ->where('area', auth()->user()->area) // yang se area

    return $lmbHeader;

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
