<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DriverRegistered extends Model
{
  protected $table      = "tr_driver_registered";
  protected $primaryKey = 'id';
  public $incrementing  = false;

  public function vehicle()
  {
    return $this->belongsTo('App\Models\VehicleDetail', 'vehicle_code_type', 'vehicle_code_type');
  }

  public function expedition()
  {
    return $this->belongsTo('App\Models\MasterExpedition', 'expedition_code', 'code');
  }

	public static function transporterWaitingConcept($request){
		return DriverRegistered::select('tr_driver_registered.*', 'tr_vehicle_type_detail.cbm_max', 'tr_expedition.sap_vendor_code')
		->toBase()->where('tr_driver_registered.area', $request->input('area'))
		->leftjoin('tr_vehicle_type_detail', 'tr_vehicle_type_detail.vehicle_code_type', '=', 'tr_driver_registered.vehicle_code_type')
		->leftjoin('tr_expedition', 'tr_expedition.code', '=', 'tr_driver_registered.expedition_code')
		//->whereNull('tr_driver_registered.has_manifest')
		//->whereNull('tr_driver_registered.has_pickinglist')
		->whereNull('tr_driver_registered.has_manifest_complete')
		->whereNull('datetime_out');
	}

  public static function transporterWaitingConcept_old($request)
  {
    return DriverRegistered::select('tr_driver_registered.*', 'tr_vehicle_type_detail.cbm_max', 'tr_expedition.sap_vendor_code')
      ->toBase()->where('tr_driver_registered.area', $request->input('area'))
      ->leftjoin('tr_vehicle_type_detail', 'tr_vehicle_type_detail.vehicle_code_type', '=', 'tr_driver_registered.vehicle_code_type')
      ->leftjoin('wms_pickinglist_header', 'wms_pickinglist_header.driver_register_id', '=', 'tr_driver_registered.id')
      ->leftjoin('tr_expedition', 'tr_expedition.code', '=', 'tr_driver_registered.expedition_code')
      ->leftjoin('log_manifest_header', 'log_manifest_header.r_driver_register_id', '=', 'tr_driver_registered.id')
      ->whereNull('log_manifest_header.driver_register_id')
      ->whereNull('wms_pickinglist_header.driver_register_id')
      ->whereNull('datetime_out');
  }
}
