<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MovementTransactionLog;
use DataTables;

class CancelMovementController extends Controller
{
  public function index(Request $request)
  {
    if ($request->ajax()) {
      $query = MovementTransactionLog::all();

      $datatables = DataTables::of($query)
        ->addIndexColumn() //DT_RowIndex (Penomoran)
        ->addColumn('picking_no', function ($data) {
          return '';
        })
        ->addColumn('action', function ($data) {
          $action = '';
          $action .= ' ' . get_button_delete('Cancel Movement');
          return $action;
        });

      return $datatables->make(true);
    }

    return view('web.inventory.cancel-movement.index');
  }
}
