<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\WMSBranchManifestDetail;
use App\Models\WMSBranchManifestHeader;
use DataTables;
use Illuminate\Http\Request;

class BillingReturnController extends Controller
{
  public function index(Request $request)
  {
    return view('web.incoming.billing-return.index');
  }

  public function listPendingBillingBranch(Request $request)
  {
    if ($request->ajax()) {
      $query = WMSBranchManifestHeader::select('wms_branch_manifest_header.*')
        ->leftjoin('wms_branch_manifest_detail', function ($join) {
          $join->on('wms_branch_manifest_detail.do_manifest_no', '=', 'wms_branch_manifest_header.do_manifest_no')
            ->where('wms_branch_manifest_detail.status_confirm', 1)
            ->whereNull('wms_branch_manifest_detail.doc_do_return_date')
          ;
        })
        ->whereNotNull('wms_branch_manifest_detail.do_manifest_no')
        ->where('wms_branch_manifest_header.kode_cabang', auth()->user()->cabang->kode_cabang)
        ->groupBy('wms_branch_manifest_detail.do_manifest_no')
      ;

      $datatables = DataTables::of($query)
        ->addIndexColumn() //DT_RowIndex (Penomoran)
        ->addColumn('source', function ($data) {
          return 'BRANCH';
        })
        ->addColumn('action', function ($data) {
          $action = '';
          $action .= ' ' . get_button_view(url('billing-return/' . $data->do_manifest_no . '/view-for-submit'), 'View for Submit');
          return $action;
        })
        ->rawColumns(['do_status', 'action']);

      return $datatables->make(true);
    }
  }

  public function listReturnBillingBranch(Request $request)
  {
    if ($request->ajax()) {
      $query = WMSBranchManifestHeader::select('wms_branch_manifest_header.*')
        ->leftjoin('wms_branch_manifest_detail', function ($join) {
          $join->on('wms_branch_manifest_detail.do_manifest_no', '=', 'wms_branch_manifest_header.do_manifest_no')
            ->where('wms_branch_manifest_detail.status_confirm', 1)
            ->whereNotNull('wms_branch_manifest_detail.doc_do_return_date')
          ;
        })
        ->whereNotNull('wms_branch_manifest_detail.do_manifest_no')
        ->where('wms_branch_manifest_header.kode_cabang', auth()->user()->cabang->kode_cabang)
        ->groupBy('wms_branch_manifest_detail.do_manifest_no')
      ;

      $datatables = DataTables::of($query)
        ->addIndexColumn() //DT_RowIndex (Penomoran)
        ->addColumn('picking_no', function ($data) {
          return $data->picking->picking_no;
        })
        ->addColumn('status', function ($data) {
          return $data->status();
        })
        ->addColumn('action', function ($data) {
          $action = '';
          $action .= ' ' . get_button_view(url('billing-return/' . $data->do_manifest_no), 'View');
          return $action;
        })
        ->rawColumns(['do_status', 'action']);

      return $datatables->make(true);
    }
  }

  public function showSubmit($id)
  {
    $data['manifest']  = WMSBranchManifestHeader::findOrFail($id);
    $data['type_show'] = 'showSubmit';

    return view('web.incoming.billing-return.view', $data);
  }

  public function show($id)
  {
    $data['manifest']  = WMSBranchManifestHeader::findOrFail($id);
    $data['type_show'] = 'show';

    return view('web.incoming.billing-return.view', $data);
  }

  public function conform(Request $request, $id)
  {
    $manifestHeader = WMSBranchManifestHeader::findOrFail($id);
    if (empty($request->input('manifest_detail'))) {
      return sendError('Please, Selected item');
    }
    foreach ($request->input('manifest_detail') as $key => $value) {
      $manifesDetail                     = WMSBranchManifestDetail::findOrFail($key);
      $manifesDetail->doc_do_return_date = date('Y-m-d H:i:s', strtotime($request->input('doc_do_return_date')));
      $manifesDetail->save();
    }

    return sendSuccess('Success', $manifestHeader);
  }
}
