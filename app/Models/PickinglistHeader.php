<?php

namespace App\Models;

use App\BaseModel;
use DB;

class PickinglistHeader extends BaseModel
{
  protected $table     = 'wms_pickinglist_header';
  public $incrementing = false;

  public function details()
  {
    return $this->hasMany('App\Models\PickinglistDetail', 'header_id', 'id');
  }

	public function getDetailCount(){
		if ($this->detail_count == null) {
			//$this->detail_count = $this->details()->count();
			$this->detail_count = PickinglistDetail::where(['header_id' => $this->id])->limit(2)->get()->count(); //sementara hanya bisa cek jika ada detail
			$this->save();
		}
		return $this->detail_count;
	}

  public function getConceptData()
  {
    if ($this->HQ) {
      $concept = $this->details()->select(
        'tr_concept.*'
      )
        ->leftjoin('tr_concept', function ($join) {
          $join->on('tr_concept.invoice_no', '=', 'wms_pickinglist_detail.invoice_no');
          $join->on('tr_concept.line_no', '=', 'wms_pickinglist_detail.line_no');
        })
        ->orderBy('tr_concept.delivery_no');
    } else {
      $concept = $this->details()->select(
        'wms_manual_concept.*',
        DB::raw('wms_manual_concept.long_description_customer AS ship_to')
      )
        ->leftjoin('wms_manual_concept', function ($join) {
          $join->on('wms_manual_concept.invoice_no', '=', 'wms_pickinglist_detail.invoice_no');
          $join->on('wms_manual_concept.delivery_no', '=', 'wms_pickinglist_detail.delivery_no');
          $join->on('wms_manual_concept.delivery_items', '=', 'wms_pickinglist_detail.delivery_items');
        })
        ->orderBy('wms_manual_concept.delivery_no');
    }

    return $concept->get();
  }

  public function detailWithLMB()
  {
    return $this
      ->details()
      ->select(
        'wms_pickinglist_detail.*',
        // DB::raw('wms_lmb_detail.serial_number AS quantity_in_lmb')
        DB::raw('COUNT(wms_lmb_detail.serial_number) AS quantity_in_lmb')
      )
      /*->leftjoin('wms_lmb_detail', function ($join) {
        $join->on('wms_lmb_detail.picking_id', '=', 'wms_pickinglist_detail.header_id');
        $join->on('wms_lmb_detail.delivery_no', '=', 'wms_pickinglist_detail.delivery_no');
        $join->on('wms_lmb_detail.invoice_no', '=', 'wms_pickinglist_detail.invoice_no');
        $join->on('wms_lmb_detail.ean_code', '=', 'wms_pickinglist_detail.ean_code');
        $join->on('wms_lmb_detail.delivery_items', '=', 'wms_pickinglist_detail.delivery_items');
      })*/
	  ->leftjoin('wms_lmb_detail', 'wms_lmb_detail.picking_detail_id', '=', 'wms_pickinglist_detail.id')
      ->groupBy(
        'wms_pickinglist_detail.header_id',
        'wms_pickinglist_detail.invoice_no',
        'wms_pickinglist_detail.delivery_no',
        'wms_pickinglist_detail.delivery_items',
        'wms_pickinglist_detail.ean_code'
      );
  }

  public function driver_register()
  {
    return $this->belongsTo('App\Models\DriverRegistered', 'driver_register_id', 'id');
  }

  public function createdBy()
  {
    return $this->belongsTo('App\User', 'created_by', 'id');
  }

  public function lmb_header()
  {
    return $this->belongsTo('App\Models\LMBHeader', 'driver_register_id', 'driver_register_id');
  }

  public function lmb_details()
  {
    return $this->hasMany('App\Models\LMBDetail', 'picking_id', 'picking_no');
  }

	public function getLmbDetCount(){
		if ($this->lmb_detail_count == null && $this->lmb_detail_count !== 0) {
			//$this->lmb_detail_count = $this->lmb_details()->count();
			$this->lmb_detail_count = LMBDetail::where(['picking_id' => $this->id])->limit(1)->get()->count(); //sementara hanya bisa cek jika ada lmb detail
			$this->save();
		}
		return $this->lmb_detail_count;
	}

  public function vehicle()
  {
    return $this->belongsTo('App\Models\VehicleDetail', 'vehicle_code_type', 'vehicle_code_type');
  }

  public function gate()
  {
    return $this->belongsTo('App\Models\Gate', 'gate_number', 'gate_number');
  }

  public static function getDestinationName($pickinglistHeader)
  {
    return $pickinglistHeader->expedition_code == 'AS' ? "Ambil Sendiri" : ($pickinglistHeader->hq ? $pickinglistHeader->destination_name : $pickinglistHeader->city_name);
  }

  public static function getDestinationNumber($pickinglistHeader)
  {
    return $pickinglistHeader->expedition_code == 'AS' ? "Ambil Sendiri" : ($pickinglistHeader->hq ? $pickinglistHeader->destination_number : $pickinglistHeader->city_code);
  }

  public function cabang()
  {
    return $this->belongsTo('App\Models\MasterCabang', 'kode_cabang', 'kode_cabang');
  }

  public function storage()
  {
    return $this->belongsTo('App\Models\StorageMaster');
  }

  public static function noLMBPickingList()
  {
    return PickinglistHeader::selectRaw('wms_pickinglist_header.*')
      ->leftjoin('wms_lmb_header', 'wms_lmb_header.driver_register_id', '=', 'wms_pickinglist_header.driver_register_id')
      ->leftjoin('wms_lmb_detail', 'wms_lmb_detail.picking_id', '=', 'wms_pickinglist_header.picking_no')
      // ->whereNotNull('wms_pickinglist_header.driver_register_id') // yang sudah ada driver
      ->whereNull('wms_lmb_header.driver_register_id') // yang belum ada LMB
      ->whereNotNull('wms_lmb_detail.serial_number') // yang punya detail
      ->where('wms_pickinglist_header.kode_cabang', auth()->user()->cabang->kode_cabang) // yang se area
      ->groupBy('wms_pickinglist_header.driver_register_id')
      // ->has('lmb_details')
      // ->where('area', auth()->user()->area) // yang se area
    ;
  }
}
