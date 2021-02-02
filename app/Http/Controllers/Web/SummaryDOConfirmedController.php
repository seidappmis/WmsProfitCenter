<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\LogManifestDetail;
use App\Models\WMSBranchManifestDetail;
use Illuminate\Http\Request;
use DB;

class SummaryDOConfirmedController extends Controller
{
  public function index(Request $request)
  {
    return view('web.report.summary-do-confirmed.index');
  }

  public function export(Request $request)
  {
    $details = LogManifestDetail::select(
      'log_manifest_detail.do_date',
      'log_manifest_detail.delivery_no',
      'log_manifest_detail.do_internal',
      'log_manifest_detail.confirm_date',
      'log_manifest_detail.status_confirm',
      'log_manifest_detail.do_manifest_no',
      'log_cabang.kode_customer'
    )
      ->leftjoin('log_cabang', 'log_cabang.kode_cabang', '=', 'log_manifest_detail.kode_cabang')
      ->where('log_cabang.kode_cabang', $request->input('cabang'))
      ->where('log_manifest_detail.do_date', '>=', date('Y-m-d', strtotime($request->input('do_date_from'))))
      ->where('log_manifest_detail.do_date', '<=', date('Y-m-d', strtotime($request->input('do_date_to'))) . '  23:59:59')
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
      $details->where(DB::raw('DATE(log_manifest_detail.confirm_date)'), '>=', $request->input('confirm_date_from'));
    }
    if (!empty($request->input('confirm_date_to'))) {
      $details->where(DB::raw('DATE(log_manifest_detail.confirm_date)'), '<=', $request->input('confirm_date_to') . '  23:59:59');
    }

    if ($request->input('status_confirm') != '') {
      $details->where('log_manifest_detail.status_confirm', '=', $request->input('status_confirm'));
    }

    $branch_details = WMSBranchManifestDetail::select(
      'wms_branch_manifest_detail.do_date',
      'wms_branch_manifest_detail.delivery_no',
      'wms_branch_manifest_detail.do_internal',
      'wms_branch_manifest_detail.confirm_date',
      'wms_branch_manifest_detail.status_confirm',
      'wms_branch_manifest_detail.do_manifest_no',
      'log_cabang.kode_customer'
    )
      ->leftjoin('log_cabang', 'log_cabang.kode_cabang', '=', 'wms_branch_manifest_detail.kode_cabang')
      ->where('log_cabang.kode_cabang', $request->input('cabang'))
      ->where('wms_branch_manifest_detail.do_date', '>=', date('Y-m-d', strtotime($request->input('do_date_from'))))
      ->where('wms_branch_manifest_detail.do_date', '<=', date('Y-m-d', strtotime($request->input('do_date_to'))) . '  23:59:59')
    ;

    if (!empty($request->input('delivery_no_from'))) {
      $branch_details->where('wms_branch_manifest_detail.delivery_no', '>=', $request->input('delivery_no_from'));
    }
    if (!empty($request->input('delivery_no_to'))) {
      $branch_details->where('wms_branch_manifest_detail.delivery_no', '<=', $request->input('delivery_no_to'));
    }

    if (!empty($request->input('do_internal_from'))) {
      $branch_details->where('wms_branch_manifest_detail.do_internal', '>=', $request->input('do_internal_from'));
    }
    if (!empty($request->input('do_internal_to'))) {
      $branch_details->where('wms_branch_manifest_detail.do_internal', '<=', $request->input('do_internal_to'));
    }

    if (!empty($request->input('confirm_date_from'))) {
      $branch_details->where(DB::raw('DATE(wms_branch_manifest_detail.confirm_date)'), '>=', $request->input('confirm_date_from'));
    }
    if (!empty($request->input('confirm_date_to'))) {
      $branch_details->where(DB::raw('DATE(wms_branch_manifest_detail.confirm_date)'), '<=', $request->input('confirm_date_to') . '  23:59:59');
    }

    if ($request->input('status_confirm') != '') {
      $branch_details->where('wms_branch_manifest_detail.status_confirm', '=', $request->input('status_confirm'));
    }

    $details->union($branch_details);

    $data['details'] = $details->get();

    return view('web.report.summary-do-confirmed.print', $data);
  }
}
