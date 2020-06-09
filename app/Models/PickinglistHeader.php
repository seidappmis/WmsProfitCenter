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

  public static function noLMBPickingList()
  {
    return PickinglistHeader::selectRaw('wms_pickinglist_header.*')
      ->leftjoin('wms_lmb_header', 'wms_lmb_header.driver_register_id', '=', 'wms_pickinglist_header.driver_register_id')
      ->whereNotNull('wms_pickinglist_header.driver_register_id') // yang sudah ada driver
      ->whereNull('wms_lmb_header.driver_register_id') // yang belum ada LMB
      ->where('area', auth()->user()->area) // yang se area
      ;
  }
}
