<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\LMBDetail;
use DataTables;
use Illuminate\Http\Request;

class SerialNumberTraceController extends Controller
{
  public function index(Request $request)
  {
    if ($request->ajax()) {
      $query = LMBDetail::select(
        'wms_lmb_detail.*',
        'wms_lmb_header.lmb_date',
        'log_manifest_header.do_manifest_no'
      )
        ->leftjoin('wms_lmb_header', 'wms_lmb_header.driver_register_id', '=', 'wms_lmb_detail.driver_register_id')
        ->leftjoin('log_manifest_header', 'log_manifest_header.driver_register_id', '=', 'wms_lmb_detail.driver_register_id')
        ->leftjoin('log_manifest_detail', 'log_manifest_header.do_manifest_no', '=', 'wms_lmb_detail.driver_register_id')
        ->where('wms_lmb_detail.model', $request->input('model'))
        ->where('wms_lmb_detail.serial_number', $request->input('serial_number'))
      ;
      $datatables = DataTables::of($query);

      return $datatables->make(true);
    }

    return view('web.report.serial-number-trace.index');
  }
}
