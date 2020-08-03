<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\LMBHeader;
use App\Models\LogManifestHeader;
use DataTables;
use DB;
use Illuminate\Http\Request;

class ManifestASController extends Controller
{
  public function index(Request $request)
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
          $action .= ' ' . get_button_view(url('manifest-as/' . $data->driver_register_id . '/edit'), 'View');
          return $action;
        })
        ->rawColumns(['do_status', 'action']);

      return $datatables->make(true);
    }

    return view('web.outgoing.manifest-as.index');
  }
  public function lmbWaitingManifest(Request $request)
  {
    if ($request->ajax()) {
      $query = LMBHeader::noManifestLMBHeader()->where('wms_lmb_header.expedition_code', '=', 'AS')->get();

      $datatables = DataTables::of($query)
        ->addIndexColumn() //DT_RowIndex (Penomoran)
        ->addColumn('picking_no', function ($data) {
          return $data->picking->picking_no;
        })
        ->addColumn('action', function ($data) {
          $action = '';
          $action .= ' ' . get_button_view(url('manifest-as/' . $data->driver_register_id . '/create-manifest'), 'Create');
          return $action;
        })
        ->rawColumns(['do_status', 'action']);

      return $datatables->make(true);
    }
  }
}
