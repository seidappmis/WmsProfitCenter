<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Concept;
use App\Models\DriverRegistered;
use DB;
use Illuminate\Http\Request;

class TruckingMonitorController extends Controller
{
  public function getVehicleStandby(Request $request)
  {
    $query = DriverRegistered::select('tr_driver_registered.*', 'tr_vehicle_type_detail.cbm_min', 'tr_vehicle_type_detail.cbm_max', 'tr_expedition.sap_vendor_code')
      ->toBase()->where('tr_driver_registered.area', $request->input('area'))
      ->leftjoin('tr_vehicle_type_detail', 'tr_vehicle_type_detail.vehicle_code_type', '=', 'tr_driver_registered.vehicle_code_type')
      ->leftjoin('wms_pickinglist_header', 'wms_pickinglist_header.driver_register_id', '=', 'tr_driver_registered.id')
      ->leftjoin('tr_expedition', 'tr_expedition.code', '=', 'tr_driver_registered.expedition_code')
      ->whereNull('wms_pickinglist_header.driver_register_id')
      ->whereNull('datetime_out')
    ;

    $result = [
      'total_vehicle' => $query->count(),
      'top15'         => $query->limit(15)->get(),
    ];

    return sendSuccess("Vehicle Standby retrive.", $result);
  }

  public function getDeliveryOrder(Request $request)
  {
    $top15 = Concept::selectRaw('
          tr_concept.*,
          SUM(tr_concept.cbm) AS total_cbm,
          tr_destination.destination_description AS destination_name,
          COUNT(tr_concept.line_no) AS total_do_items
        ')
      ->leftjoin('tr_destination', 'tr_destination.destination_number', '=', 'tr_concept.destination_number')
      ->leftjoin('wms_pickinglist_detail', function ($join) {
        $join->on('wms_pickinglist_detail.invoice_no', '=', 'tr_concept.invoice_no');
        $join->on('wms_pickinglist_detail.delivery_no', '=', 'tr_concept.delivery_no');
      })
      ->whereNull('wms_pickinglist_detail.id') // Ambil yang belum masuk picking list
      ->where('area', $request->input('area'))
      ->groupBy('tr_concept.invoice_no', 'tr_concept.delivery_no')
      ->limit(15)
    ;

    $shipment = DB::select('SELECT COUNT(*) AS total_shipment FROM (
              SELECT tr_concept.* FROM `tr_concept` LEFT JOIN `tr_destination` ON `tr_destination`.`destination_number` = `tr_concept`.`destination_number` LEFT JOIN `wms_pickinglist_detail` ON `wms_pickinglist_detail`.`invoice_no` = `tr_concept`.`invoice_no` AND `wms_pickinglist_detail`.`delivery_no` = `tr_concept`.`delivery_no` WHERE `wms_pickinglist_detail`.`id` IS NULL AND `area` = :area GROUP BY tr_concept.`invoice_no`
              )AS t', ['area' => $request->input('area')]);

    $result = [
      'shipment' => $shipment[0],
      'top15'    => $top15->get(),
    ];

    return sendSuccess("Vehicle Standby retrive.", $result);
  }
}
