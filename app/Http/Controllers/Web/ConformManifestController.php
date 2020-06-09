<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\LogManifestHeader;
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
      $query = LogManifestHeader::all();

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
          $action .= ' ' . get_button_view(url('conform-manifest/' . $data->driver_register_id), 'View for Conform');
          return $action;
        })
        ->rawColumns(['do_status', 'action']);

      return $datatables->make(true);
    }
  }

  public function listManifestBranch(Request $request)
  {
    if ($request->ajax()) {
      $query = LogManifestHeader::all();

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
          $action .= ' ' . get_button_view(url('conform-manifest/' . $data->driver_register_id), 'View for Conform');
          return $action;
        })
        ->rawColumns(['do_status', 'action']);

      return $datatables->make(true);
    }
  }
}
