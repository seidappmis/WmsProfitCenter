<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\IncomingManualDetail;
use DataTables;
use DB;
use Illuminate\Http\Request;

class SummaryIncomingReportController extends Controller
{
  public function index(Request $request)
  {
    if ($request->ajax()) {
      $query = IncomingManualDetail::select(
        'log_incoming_manual_detail.*',
        'wms_master_model.ean_code',
        'log_incoming_manual_header.invoice_no',
        'log_incoming_manual_header.document_date',
        'log_incoming_manual_header.vendor_name',
        'log_incoming_manual_header.expedition_name',
        'log_incoming_manual_header.area',
        DB::raw('log_incoming_manual_header.arrival_no AS receipt_no'),
        DB::raw('log_incoming_manual_header.inc_type AS type'),
        DB::raw('log_incoming_manual_header.po AS delivery_ticket'),
        DB::raw('wms_master_storage.sto_type_desc AS storage_location'),
        DB::raw('users.username AS created_by_name')
      )
        ->leftjoin('log_incoming_manual_header', 'log_incoming_manual_header.arrival_no', '=', 'log_incoming_manual_detail.arrival_no_header')
        ->leftjoin('wms_master_model', 'wms_master_model.model_name', '=', 'log_incoming_manual_detail.model')
        ->leftjoin('wms_master_storage', 'wms_master_storage.id', '=', 'log_incoming_manual_detail.storage_id')
        ->leftjoin('users', 'users.id', '=', 'log_incoming_manual_header.created_by')
      ;

      $query->where('log_incoming_manual_header.created_at', '>=', date('Y-m-d', strtotime($request->input('start_date'))));
      $query->where('log_incoming_manual_header.created_at', '<=', date('Y-m-d', strtotime($request->input('end_date'))));

      if (!empty($request->input('area'))) {
        $query->where('log_incoming_manual_header.area', $request->input('area'));
      }
      if (!empty($request->input('cabang'))) {
        $query->where('log_incoming_manual_header.kode_cabang', $request->input('cabang'));
      }

      $datatables = DataTables::of($query)
        ->editColumn('created_at', function ($data) {
          return $data->created_at;
        })
      ;

      return $datatables->make(true);
    }

    return view('web.report.summary-incoming-report.index');
  }
}
