<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\LogManifestHeader;
use DataTables;
use Illuminate\Http\Request;

class CompleteController extends Controller
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
          $action .= ' ' . get_button_view(url('complete/' . $data->driver_register_id), 'View');
          return $action;
        })
        ->rawColumns(['do_status', 'action']);

      return $datatables->make(true);
    }

    return view('web.outgoing.complete.index');
  }

  public function show($id)
  {
    $data['manifestHeader'] = LogManifestHeader::findOrFail($id);

    return view('web.outgoing.complete.view', $data);
  }

  public function complete($id)
  {
    $manifestHeader                  = LogManifestHeader::findOrFail($id);
    
    $manifestHeader->status_complete = 1;
    $manifestHeader->save();

    return $manifestHeader;
  }
}
