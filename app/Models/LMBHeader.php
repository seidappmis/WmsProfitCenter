<?php

namespace App\Models;

use DB;
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

  public function getStartDate()
  {
    return $this->details()->select(DB::raw('MIN(created_at) as start_date'))->first()->start_date;
  }

  public function detail_created_date()
  {
    return $this->details()->select(DB::raw('MIN(created_at) as created_start_date, MAX(created_at) AS created_end_date'))->first();
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
      ->selectRaw('
        wms_lmb_detail.delivery_no
        , wms_lmb_detail.model
        , wms_lmb_detail.invoice_no
        , wms_lmb_detail.ean_code
        , wms_lmb_detail.cbm_unit
        , wms_lmb_detail.picking_id
        , wms_lmb_detail.city_code
        , wms_lmb_detail.kode_customer
        , wms_lmb_detail.code_sales
        , COUNT(serial_number) AS quantity
        , SUM(cbm_unit) as cbm
        , wms_pickinglist_detail.delivery_items
        , wms_pickinglist_detail.line_no
        , wms_pickinglist_detail.kode_customer
        , wms_pickinglist_header.city_name
        , tr_concept.ship_to
        ')
      ->leftjoin('wms_pickinglist_detail', function ($join) {
        $join->on('wms_pickinglist_detail.invoice_no', '=', 'wms_lmb_detail.invoice_no');
        $join->on('wms_pickinglist_detail.delivery_no', '=', 'wms_lmb_detail.delivery_no');
        $join->on('wms_pickinglist_detail.delivery_items', '=', 'wms_lmb_detail.delivery_items');
        $join->on('wms_pickinglist_detail.model', '=', 'wms_lmb_detail.model');
        $join->on('wms_pickinglist_detail.header_id', '=', 'wms_lmb_detail.picking_id');
      })
      ->leftjoin('tr_concept', function ($join) {
        $join->on('tr_concept.invoice_no', '=', 'wms_lmb_detail.invoice_no');
        $join->on('tr_concept.delivery_no', '=', 'wms_lmb_detail.delivery_no');
        $join->on('tr_concept.delivery_items', '=', 'wms_lmb_detail.delivery_items');
        $join->on('tr_concept.model', '=', 'wms_lmb_detail.model');
      })
      ->leftjoin('wms_pickinglist_header', 'wms_pickinglist_header.id', '=', 'wms_pickinglist_detail.header_id');

    if ($this->cabang->hq) {
      $details->leftjoin('log_manifest_detail', function ($join) {
        $join->on('log_manifest_detail.invoice_no', '=', 'wms_lmb_detail.invoice_no');
        $join->on('log_manifest_detail.delivery_no', '=', 'wms_lmb_detail.delivery_no');
        $join->on('log_manifest_detail.delivery_items', '=', 'wms_pickinglist_detail.delivery_items');
      })
        ->whereNull('log_manifest_detail.id');
    } else {
      $details->leftjoin('wms_branch_manifest_detail', function ($join) {
        $join->on('wms_branch_manifest_detail.invoice_no', '=', 'wms_lmb_detail.invoice_no');
        $join->on('wms_branch_manifest_detail.delivery_no', '=', 'wms_lmb_detail.delivery_no');
        $join->on('wms_branch_manifest_detail.delivery_items', '=', 'wms_pickinglist_detail.delivery_items');
      })
        ->whereNull('wms_branch_manifest_detail.id');
    }

	$details->groupByRaw('invoice_no, delivery_no, model, d_lmb.delivery_items, ean_code, cbm_unit, picking_id, city_code, wms_lmb_detail.kode_customer, wms_pickinglist_detail.kode_customer, code_sales, line_no');
    $details->orderBy('wms_lmb_detail.delivery_no');

    return $details;
  }

  public function getCustomer()
  {
    $pickingDetail = $this->picking->details;
    $customer      = '';
    foreach ($pickingDetail as $key => $value) {
      $rs_customer[$value->customer()] = $value;
    }

    foreach ($rs_customer as $key => $value) {
      $customer .= (!empty($customer) ? ',' : '');
      $customer .= $key;
    }
    return $customer;
  }

  public function picking()
  {
    return $this->belongsTo('App\Models\PickinglistHeader', 'driver_register_id', 'driver_register_id');
  }

  public function getInvoiceNo(){
    return $this->details()
    ->select(DB::raw('GROUP_CONCAT(DISTINCT(invoice_no) SEPARATOR ",  ") AS rs_invoice_no'))
    ->first()->rs_invoice_no;
  }

  public function getPickingNo($data)
  {
    $rs_pickinglistHeader = \App\Models\PickinglistHeader::where('driver_register_id', $data->driver_register_id)->get();
    $picking_no           = '';
    foreach ($rs_pickinglistHeader as $key => $value) {
      $picking_no .= !empty($picking_no) ? ', ' : '';
      $picking_no .= $value->picking_no;
    }
    return $picking_no;
  }

  public static function noManifestLMBHeader($as = false, $branch = false)
  {
    $lmbHeader = LMBHeader::selectRaw('wms_lmb_header.*')
      ->leftjoin('log_cabang', 'log_cabang.kode_cabang', '=', 'wms_lmb_header.kode_cabang');

    if ($branch) {
      $lmbHeader->where('log_cabang.hq', 0);
      $lmbHeader->where('wms_lmb_header.kode_cabang', auth()->user()->cabang->kode_cabang);
    } else {
      $lmbHeader->where('log_cabang.hq', 1);
      $lmbHeader->where('wms_lmb_header.kode_cabang', auth()->user()->cabang->kode_cabang);
    }

    if (auth()->user()->cabang->hq) {
      $lmbHeader->leftjoin('log_manifest_header', 'log_manifest_header.driver_register_id', '=', 'wms_lmb_header.driver_register_id')
        // ->where('log_cabang.hq', 1)
        ->whereNull('log_manifest_header.driver_register_id') // yang belum ada Manifest
      ;

      if (!$as) {
        $lmbHeader->leftjoin('tr_driver_registered', 'tr_driver_registered.id', '=', 'wms_lmb_header.driver_register_id')
          ->whereNotNull('tr_driver_registered.id');
      }
    } else {
      $lmbHeader->leftjoin('wms_branch_manifest_header', 'wms_branch_manifest_header.driver_register_id', '=', 'wms_lmb_header.driver_register_id')
        // ->where('log_cabang.hq', 0)
        ->whereNull('wms_branch_manifest_header.driver_register_id') // yang belum ada Manifest
      ;
    }
    // ->where('area', auth()->user()->area) // yang se area

    return $lmbHeader;
  }

	public function hasManifestComplete(){
		if ($this->send_manifest) {
			if (auth()->user()->cabang->hq) {
				return LogManifestHeader::where('driver_register_id', $this->driver_register_id)
					->where('status_complete', 1)->count() > 0;
			} else {
				return WMSBranchManifestHeader::where('driver_register_id', $this->driver_register_id)
					->where('status_complete', 1)->count() > 0;
			}
		} else {
			return false;
		}
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
