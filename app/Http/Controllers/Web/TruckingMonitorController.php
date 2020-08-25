<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\DriverRegistered;
use Illuminate\Http\Request;

class TruckingMonitorController extends Controller
{
  public function getVehicleStandby(Request $request)
  {
    $query = DriverRegistered::select('tr_driver_registered.*','tr_vehicle_type_detail.cbm_min', 'tr_vehicle_type_detail.cbm_max', 'tr_expedition.sap_vendor_code')
      ->toBase()->where('tr_driver_registered.area', $request->input('area'))
      ->leftjoin('tr_vehicle_type_detail', 'tr_vehicle_type_detail.vehicle_code_type', '=', 'tr_driver_registered.vehicle_code_type')
      ->leftjoin('wms_pickinglist_header', 'wms_pickinglist_header.driver_register_id', '=', 'tr_driver_registered.id')
      ->leftjoin('tr_expedition', 'tr_expedition.code', '=', 'tr_driver_registered.expedition_code')
      ->whereNull('wms_pickinglist_header.driver_register_id')
      ->whereNull('datetime_out')
      ;

    $result = [
      'total_vehicle' => $query->count(),
      'top15' => $query->limit(15)->get()
    ];

    return sendSuccess("Vehicle Standby retrive.", $result);
      

  }
}
