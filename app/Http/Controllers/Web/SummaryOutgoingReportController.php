<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\LogManifestHeader;
use DataTables;
use DB;
use Illuminate\Http\Request;

class SummaryOutgoingReportController extends Controller
{
  public function index(Request $request)
  {
    if ($request->ajax()) {
      $query = $this->getSummaryOutgoingReport($request);

      $datatables = DataTables::of($query)
      ;

      return $datatables->make(true);
    }

    return view('web.report.summary-outgoing-report.index');
  }

  public static function getSummaryOutgoingReport($request)
  {
    $query = LogManifestHeader::select(
      'log_manifest_header.*',
      'log_manifest_detail.invoice_no',
      'log_manifest_detail.delivery_no',
      'log_manifest_detail.lead_time',
      'log_manifest_detail.do_internal',
      'log_manifest_detail.delivery_items',
      'log_manifest_detail.do_date',
      'log_manifest_detail.reservasi_no',
      'log_manifest_detail.quantity',
      'log_manifest_detail.sold_to_code',
      'log_manifest_detail.sold_to',
      'log_manifest_detail.ship_to',
      'log_manifest_detail.ship_to_code',
      'log_manifest_detail.region',
      'log_manifest_detail.model',
      'log_manifest_detail.code_sales',
      'log_manifest_detail.status_confirm',
      'log_manifest_detail.confirm_date',
      'log_manifest_detail.actual_time_arrival',
      'log_manifest_detail.actual_loading_date',
      'log_manifest_detail.doc_do_return_date',
      DB::raw('log_manifest_detail.do_reject AS status_reject'),
      DB::raw('DATE_ADD(do_manifest_date, INTERVAL log_manifest_detail.lead_time DAY) AS eta'),
      DB::raw('log_manifest_detail.cbm AS detail_cbm'),
      DB::raw('IF(log_manifest_detail.status_confirm, "Delivered", "") AS delivery_status'),
      DB::raw('IF(log_manifest_detail.status_confirm, "Confirmed", "") AS confirm'),
      DB::raw('(log_manifest_detail.cbm * log_manifest_detail.quantity) AS detail_total_cbm'),
      DB::raw('wms_master_model.description AS model_description'),
      DB::raw('IF(log_manifest_detail.status_confirm IS NULL, "", IF(log_manifest_detail.status_confirm = 1, "Confirmed", IF(log_manifest_detail.status_confirm = 0 && log_manifest_header.status_complete = 1, "Delivery", IF(log_manifest_detail.status_confirm = 0 && log_manifest_header.status_complete = 0, "Waiting Complete", "")))) AS status'),
      DB::raw('IF(log_manifest_detail.tcs IS NULL, "", IF(log_manifest_detail.tcs = 1, "TCS",IF(log_manifest_detail.tcs = 0 && log_manifest_detail.do_return = 0, "MANUAL", ""))) AS `desc`'),
      DB::raw('uconfirm.username AS confirm_by'),
      DB::raw('uc.username AS created_by_name'),
      DB::raw('um.username AS updated_by_name')
    )
      ->leftjoin('log_manifest_detail', 'log_manifest_detail.do_manifest_no', '=', 'log_manifest_header.do_manifest_no')
      ->leftjoin('wms_master_model', 'wms_master_model.model_name', '=', 'log_manifest_detail.model')
      ->leftjoin(DB::raw('users AS uc'), 'uc.id', '=', 'log_manifest_header.created_by')
      ->leftjoin(DB::raw('users AS um'), 'um.id', '=', 'log_manifest_header.updated_by')
      ->leftjoin(DB::raw('users AS uconfirm'), 'uconfirm.id', '=', 'log_manifest_header.updated_by')
    ;

    $query->where('log_manifest_header.area', $request->input('area'));

    if (!empty($request->input('start_do_manifest_date'))) {
      $query->where('log_manifest_header.do_manifest_date', '>=', $request->input('start_do_manifest_date'));
    }
    if (!empty($request->input('end_do_manifest_date'))) {
      $query->where('log_manifest_header.do_manifest_date', '<=', $request->input('end_do_manifest_date'));
    }

    if (!empty($request->input('start_do_date'))) {
      $query->where('log_manifest_header.do_date', '>=', $request->input('start_do_date'));
    }
    if (!empty($request->input('end_do_date'))) {
      $query->where('log_manifest_header.do_date', '<=', $request->input('end_do_date'));
    }

    if (!empty($request->input('start_actual_time_arrival'))) {
      $query->where('log_manifest_detail.actual_time_arrival', '>=', $request->input('start_actual_time_arrival'));
    }
    if (!empty($request->input('end_actual_time_arrival'))) {
      $query->where('log_manifest_detail.actual_time_arrival', '<=', $request->input('end_actual_time_arrival'));
    }

    if (!empty($request->input('start_unloading_date'))) {
      $query->where('log_manifest_detail.actual_loading_date', '>=', $request->input('start_unloading_date'));
    }
    if (!empty($request->input('end_unloading_date'))) {
      $query->where('log_manifest_detail.actual_loading_date', '<=', $request->input('end_unloading_date'));
    }

    if (!empty($request->input('start_doc_do_return_date'))) {
      $query->where('log_manifest_detail.doc_do_return_date', '>=', $request->input('start_doc_do_return_date'));
    }
    if (!empty($request->input('end_doc_do_return_date'))) {
      $query->where('log_manifest_detail.doc_do_return_date', '<=', $request->input('end_doc_do_return_date'));
    }

    if (!empty($request->input('do_manifest_no'))) {
      $query->where('log_manifest_header.do_manifest_no', $request->input('do_manifest_no'));
    }

    if (!empty($request->input('invoice_no'))) {
      $query->where('log_manifest_detail.invoice_no', $request->input('invoice_no'));
    }

    if (!empty($request->input('delivery_no'))) {
      $query->where('log_manifest_detail.delivery_no', $request->input('delivery_no'));
    }

    return $query;
  }
}
