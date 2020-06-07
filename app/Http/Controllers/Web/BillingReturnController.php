<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\LogManifestHeader;
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
          $action .= ' ' . get_button_view(url('billing-return/' . $data->driver_register_id . '/view-for-submit'), 'View for Submit');
          return $action;
        })
        ->rawColumns(['do_status', 'action']);

      return $datatables->make(true);
    }
  }

  public function listReturnBillingBranch(Request $request)
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
          $action .= ' ' . get_button_view(url('conform-manifest/' . $data->driver_register_id), 'View');
          return $action;
        })
        ->rawColumns(['do_status', 'action']);

      return $datatables->make(true);
    }
  }

  public function showSubmit($id)
  {
    return view('web.incoming.billing-return.view');
  }

  public function show($id)
  {
    return view('web.incoming.billing-return.view');
  }
}
