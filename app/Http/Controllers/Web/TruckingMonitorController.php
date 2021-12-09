<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Concept;
use App\Models\DriverRegistered;
use App\Models\PickinglistHeader;
use DataTables;
use DB;
use Illuminate\Http\Request;

class TruckingMonitorController extends Controller
{
  public function getLoadingStatus(Request $request)
  {
    if ($request->ajax()) {
      $query = PickinglistHeader::select(
        'wms_pickinglist_header.id',
        'wms_pickinglist_header.picking_date',
        'wms_pickinglist_header.vehicle_number',
        'wms_pickinglist_header.driver_name',
        'wms_pickinglist_header.city_name',
        'wms_pickinglist_header.expedition_name',
        'wms_pickinglist_header.storage_type',
        'wms_pickinglist_header.gate_number',
        'tr_vehicle_type_detail.vehicle_description',
        'tr_vehicle_type_detail.cbm_max',
        DB::raw('tr_vehicle_type_group.group_name AS vehicle_group_name'),
        DB::raw('tr_workflow.step_description AS status'),
        DB::raw('SUM(wms_pickinglist_detail.cbm) as total_cbm'),
        DB::raw('GROUP_CONCAT(DISTINCT tr_destination.destination_description SEPARATOR ",<br>") as destination_name')
      )
        ->leftjoin('tr_concept_flow_header', 'tr_concept_flow_header.driver_register_id', '=', 'wms_pickinglist_header.driver_register_id')
        ->leftjoin('tr_workflow', 'tr_workflow.id', '=', 'tr_concept_flow_header.workflow_id')
        ->leftjoin('wms_pickinglist_detail', 'wms_pickinglist_detail.header_id', '=', 'wms_pickinglist_header.id')
        ->leftjoin('wms_lmb_header', 'wms_lmb_header.driver_register_id', '=', 'wms_pickinglist_header.driver_register_id')
        ->leftjoin('tr_concept', function ($join) {
          $join->on('tr_concept.invoice_no', '=', 'wms_pickinglist_detail.invoice_no');
          $join->on('tr_concept.line_no', '=', 'wms_pickinglist_detail.line_no');
        })
        ->leftjoin('tr_destination', 'tr_destination.destination_number', '=', 'tr_concept.destination_number')
        ->leftjoin('tr_vehicle_type_detail', 'tr_vehicle_type_detail.vehicle_code_type', '=', 'wms_pickinglist_header.vehicle_code_type')
        ->leftjoin('tr_vehicle_type_group', 'tr_vehicle_type_group.id', '=', 'tr_vehicle_type_detail.vehicle_group_id')
        ->whereNull('wms_pickinglist_header.deleted_at')
        ->where('wms_pickinglist_header.area', $request->input('area'))
        ->where('tr_concept_flow_header.workflow_id', '<=', 4)
        ->groupBy('wms_pickinglist_header.driver_register_id')
      ;

      $datatables = DataTables::of($query)
        ->addIndexColumn() //DT_RowIndex (Penomoran)
        ->rawColumns(['driver_name', 'do_status', 'picking_no', 'action']);

      return $datatables->make(true);
    }
  }

  public function getAfterLoadingStatus(Request $request)
  {
    if ($request->ajax()) {
      $query = PickinglistHeader::select(
        'wms_pickinglist_header.id',
        'wms_pickinglist_header.picking_date',
        'wms_pickinglist_header.vehicle_number',
        'wms_pickinglist_header.driver_name',
        'wms_pickinglist_header.city_name',
        'wms_pickinglist_header.expedition_name',
        'wms_pickinglist_header.storage_type',
        'wms_pickinglist_header.gate_number',
        'tr_vehicle_type_detail.vehicle_description',
        'tr_vehicle_type_detail.cbm_max',
        'log_manifest_header.do_manifest_no',
        DB::raw('tr_vehicle_type_group.group_name AS vehicle_group_name'),
        DB::raw('tr_workflow.step_description AS status'),
        DB::raw('SUM(wms_pickinglist_detail.cbm) as total_cbm'),
        DB::raw('GROUP_CONCAT(DISTINCT tr_destination.destination_description SEPARATOR ",<br>") as destination_name')
      )
        ->leftjoin('log_manifest_header', 'log_manifest_header.driver_register_id', '=', 'wms_pickinglist_header.driver_register_id')
        ->leftjoin('tr_concept_flow_header', 'tr_concept_flow_header.driver_register_id', '=', 'wms_pickinglist_header.driver_register_id')
        ->leftjoin('tr_workflow', 'tr_workflow.id', '=', 'tr_concept_flow_header.workflow_id')
        ->leftjoin('wms_pickinglist_detail', 'wms_pickinglist_detail.header_id', '=', 'wms_pickinglist_header.id')
        ->leftjoin('wms_lmb_header', 'wms_lmb_header.driver_register_id', '=', 'wms_pickinglist_header.driver_register_id')
        ->leftjoin('tr_concept', function ($join) {
          $join->on('tr_concept.invoice_no', '=', 'wms_pickinglist_detail.invoice_no');
          $join->on('tr_concept.line_no', '=', 'wms_pickinglist_detail.line_no');
        })
        ->leftjoin('tr_destination', 'tr_destination.destination_number', '=', 'tr_concept.destination_number')
        ->leftjoin('tr_vehicle_type_detail', 'tr_vehicle_type_detail.vehicle_code_type', '=', 'wms_pickinglist_header.vehicle_code_type')
        ->leftjoin('tr_vehicle_type_group', 'tr_vehicle_type_group.id', '=', 'tr_vehicle_type_detail.vehicle_group_id')
        ->whereNull('wms_pickinglist_header.deleted_at')
        ->where('wms_pickinglist_header.area', $request->input('area'))
        ->where('tr_concept_flow_header.workflow_id', '=', 5)
        ->groupBy('wms_pickinglist_header.driver_register_id')
      ;

      $datatables = DataTables::of($query)
        ->addIndexColumn() //DT_RowIndex (Penomoran)
        ->rawColumns(['driver_name', 'do_status', 'picking_no', 'action']);

      return $datatables->make(true);
    }
  }

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
      ->leftjoin('wms_pickinglist_detail', 'wms_pickinglist_detail.tr_concept_id', '=', 'tr_concept.id')
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
