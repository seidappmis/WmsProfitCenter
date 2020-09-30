<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\ConceptFlowHeader;
use DataTables;
use Illuminate\Http\Request;

class LoadingStatusListController extends Controller
{
  public function index(Request $request)
  {
    if ($request->ajax()) {
      $query = ConceptFlowHeader::getLoadingSummary($request);

      if (!empty($request->input('invoice_no'))) {
        $query->where('tr_concept.invoice_no', $request->input('invoice_no'));
      }

      if (!empty($request->input('delivery_no'))) {
        $query->where('tr_concept.delivery_no', $request->input('delivery_no'));
      }

      if (!empty($request->input('vehicle_number'))) {
        $query->where('tr_driver_registered.vehicle_number', $request->input('vehicle_number'));
      }

      if (!empty($request->input('destination_number'))) {
        $query->where('tr_concept_truck_flow.destination_number', $request->input('destination_number'));
      }

      if (!empty($request->input('expedition_code'))) {
        $query->where('tr_driver_registered.expedition_code', $request->input('expedition_code'));
      }

      if (!empty($request->input('vehicle_code_type'))) {
        $query->where('tr_concept.vehicle_code_type', $request->input('vehicle_code_type'));
      }

      if (!empty($request->input('do_manifest_no'))) {
        $query->where('tr_concept_truck_flow.do_manifest_no', $request->input('do_manifest_no'));
      }

      if (!empty($request->input('start_upload_concept_date'))) {
        $query->where('tr_concept.created_at', '>=', $request->input('start_upload_concept_date'));
      }

      if (!empty($request->input('end_upload_concept_date'))) {
        $query->where('tr_concept.created_at', '<=', $request->input('end_upload_concept_date'));
      }

      if (!empty($request->input('start_register_driver_date'))) {
        $query->where('tr_driver_register.created_at', '>=', $request->input('start_register_driver_date'));
      }

      if (!empty($request->input('end_register_driver_date'))) {
        $query->where('tr_driver_register.created_at', '<=', $request->input('end_register_driver_date'));
      }

      if (!empty($request->input('start_mapping_concept_date'))) {
        $query->where('tr_concept_flow_header.created_at', '>=', $request->input('start_mapping_concept_date'));
      }

      if (!empty($request->input('end_mapping_concept_date'))) {
        $query->where('tr_concept_flow_header.created_at', '<=', $request->input('end_mapping_concept_date'));
      }

      if (!empty($request->input('start_loading_start_date'))) {
        $query->where('tr_concept_truck_flow.start_date', '>=', $request->input('start_loading_start_date'));
      }

      if (!empty($request->input('end_loading_start_date'))) {
        $query->where('tr_concept_truck_flow.start_date', '<=', $request->input('end_loading_start_date'));
      }

      if (!empty($request->input('start_loading_finish_date'))) {
        $query->where('tr_concept_truck_flow.end_date', '>=', $request->input('start_loading_finish_date'));
      }

      if (!empty($request->input('end_loading_finish_date'))) {
        $query->where('tr_concept_truck_flow.end_date', '<=', $request->input('end_loading_finish_date'));
      }

      if (!empty($request->input('start_complete_date'))) {
        $query->where('tr_concept_truck_flow.complete_date', '>=', $request->input('start_complete_date'));
      }

      if (!empty($request->input('end_complete_date'))) {
        $query->where('tr_concept_truck_flow.complete_date', '<=', $request->input('end_complete_date'));
      }

      if (!empty($request->input('status'))) {
        $query->having('status', $request->input('status'));
      }

      $datatables = DataTables::of($query)
      ;

      return $datatables->make(true);
    }

    return view('web.report.loading-status-list.index');
  }
}
