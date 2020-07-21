<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PickinglistHeader extends Model
{
  protected $table     = 'wms_pickinglist_header';
  public $incrementing = false;

  public function details()
  {
    return $this->hasMany('App\Models\PickinglistDetail', 'header_id', 'id');
  }

  public function lmb_details()
  {
    return $this->hasMany('App\Models\LMBDetail', 'picking_id', 'picking_no');
  }

  public function vehicle(){
    return $this->belongsTo('App\Models\VehicleDetail', 'vehicle_code_type', 'vehicle_code_type');
  }

  public function gate(){
    return $this->belongsTo('App\Models\Gate', 'gate_number', 'gate_number');
  }

  public static function noLMBPickingList()
  {
    return PickinglistHeader::selectRaw('wms_pickinglist_header.*')
      ->leftjoin('wms_lmb_header', 'wms_lmb_header.driver_register_id', '=', 'wms_pickinglist_header.driver_register_id')
      // ->whereNotNull('wms_pickinglist_header.driver_register_id') // yang sudah ada driver
      ->whereNull('wms_lmb_header.driver_register_id') // yang belum ada LMB
      ->where('wms_pickinglist_header.kode_cabang', auth()->user()->cabang->kode_cabang) // yang se area
      ->has('lmb_details')
      // ->where('area', auth()->user()->area) // yang se area
      ;
  }
}
