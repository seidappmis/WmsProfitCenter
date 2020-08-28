<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\LogManifestHeader;
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
      $query = WMSBranchManifestHeader::
        where('kode_cabang', auth()->user()->cabang->kode_cabang);

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
    return view('web.incoming.conform-manifest.view', $data);
  }

  public function viewForConformBranch($id)
  {
    $data['manifestHeader'] = WMSBranchManifestHeader::findOrFail($id);
    return view('web.incoming.conform-manifest.view', $data);
  }

}
