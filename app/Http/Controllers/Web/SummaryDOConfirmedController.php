<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\LogManifestDetail;
use Illuminate\Http\Request;

class SummaryDOConfirmedController extends Controller
{
  public function index(Request $request)
  {
    return view('web.report.summary-do-confirmed.index');
  }

  public function export(Request $request)
  {
    $details = LogManifestDetail::select(
      'log_manifest_detail.*',
      'log_cabang.kode_customer'
    )
      ->leftjoin('log_cabang', 'log_cabang.kode_cabang', '=', 'log_manifest_detail.kode_cabang')
      ->where('log_cabang.kode_cabang', $request->input('cabang'))
      ->where('log_manifest_detail.do_date', '>=', date('Y-m-d', strtotime($request->input('do_date_from'))))
      ->where('log_manifest_detail.do_date', '<=', date('Y-m-d', strtotime($request->input('do_date_to'))))
    ;

    if (!empty($request->input('delivery_no_from'))) {
      $details->where('log_manifest_detail.delivery_no', '>=', $request->input('delivery_no_from'));
    }
    if (!empty($request->input('delivery_no_to'))) {
      $details->where('log_manifest_detail.delivery_no', '<=', $request->input('delivery_no_to'));
    }

    if (!empty($request->input('do_internal_from'))) {
      $details->where('log_manifest_detail.do_internal', '>=', $request->input('do_internal_from'));
    }
    if (!empty($request->input('do_internal_to'))) {
      $details->where('log_manifest_detail.do_internal', '<=', $request->input('do_internal_to'));
    }

    if (!empty($request->input('confirm_date_from'))) {
      $details->where('log_manifest_detail.confirm_date', '>=', $request->input('confirm_date_from'));
    }
    if (!empty($request->input('confirm_date_to'))) {
      $details->where('log_manifest_detail.confirm_date', '<=', $request->input('confirm_date_to'));
    }

    if (!empty($request->input('status_confirm'))) {
      $details->where('log_manifest_detail.confirm_date', '=', $request->input('status_confirm'));
    }

    $data['details'] = $details->get();

    return view('web.report.summary-do-confirmed.print', $data);
  }
}
