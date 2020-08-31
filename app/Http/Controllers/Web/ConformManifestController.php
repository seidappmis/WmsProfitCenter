<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\LogManifestHeader;
use App\Models\WMSBranchManifestDetail;
use App\Models\WMSBranchManifestHeader;
use DataTables;
use Illuminate\Http\Request;

class ConformManifestController extends Controller
{
  public function index()
  {
    return view('web.incoming.conform-manifest.index');
  }

  public function listManifestHQ(Request $request)
  {
    if ($request->ajax()) {
      $query = LogManifestHeader::select(
        'log_manifest_header.*'
      )->leftjoin('log_manifest_detail', 'log_manifest_detail.do_manifest_no', '=', 'log_manifest_header.do_manifest_no')
        ->where('log_manifest_detail.kode_cabang', auth()->user()->cabang->kode_cabang)
        ->groupBy('log_manifest_header.do_manifest_no');

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
          $action .= ' ' . get_button_view(url('conform-manifest/' . $data->do_manifest_no) . '/hq', 'View for Conform');
          return $action;
        })
        ->rawColumns(['do_status', 'action']);

      return $datatables->make(true);
    }
  }

  public function listManifestBranch(Request $request)
  {
    if ($request->ajax()) {
      $query = WMSBranchManifestHeader::select('wms_branch_manifest_header.*')
        ->leftjoin('wms_branch_manifest_detail', function ($join) {
          $join->on('wms_branch_manifest_detail.do_manifest_no', '=', 'wms_branch_manifest_header.do_manifest_no')->where('wms_branch_manifest_detail.status_confirm', 0);
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
          $action .= ' ' . get_button_view(url('conform-manifest/' . $data->do_manifest_no) . '/branch', 'View for Conform');
          return $action;
        })
        ->rawColumns(['do_status', 'action']);

      return $datatables->make(true);
    }
  }

  public function viewForConformHQ($id)
  {
    $data['manifestHeader'] = LogManifestHeader::findOrFail($id);
    $data['type']           = 'HQ';
    return view('web.incoming.conform-manifest.view', $data);
  }

  public function viewForConformBranch($id)
  {
    $data['manifestHeader'] = WMSBranchManifestHeader::findOrFail($id);
    $data['type']           = 'Branch';
    return view('web.incoming.conform-manifest.view', $data);
  }

  public function conform(Request $request, $id)
  {
    $manifestHeader = WMSBranchManifestHeader::findOrFail($id);
    if (empty($request->input('manifest_detail'))) {
      return sendError('Please, Selected item');
    }
    if ($request->input('status') == 'hold_transit') {
      foreach ($request->input('manifest_detail') as $key => $value) {
        $manifesDetail                      = WMSBranchManifestDetail::findOrFail($key);
        $manifesDetail->actual_time_arrival = date('Y-m-d H:i:s', strtotime($request->input('hold_transit')));
        $manifesDetail->save();
      }
    } else {
      foreach ($request->input('manifest_detail') as $key => $value) {
        $manifesDetail                 = WMSBranchManifestDetail::findOrFail($key);
        $manifesDetail->status_confirm = 1;
        $manifesDetail->confirm_date   = date('Y-m-d H:i:s', strtotime($request->input('arrival_date')));
        $manifesDetail->confirm_by     = auth()->user()->id;
        $manifesDetail->do_reject      = !empty($request->input('rejected')) ? 1 : 0;
        $manifesDetail->save();
      }
    }

    return sendSuccess('Success', $manifestHeader);
  }

}
