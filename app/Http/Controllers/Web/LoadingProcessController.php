<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\PickinglistHeader;
use DataTables;
use Illuminate\Http\Request;

class LoadingProcessController extends Controller
{
  public function index(Request $request)
  {
    if ($request->ajax()) {
      $query = PickinglistHeader::noLMBPickingList()->get();

      $datatables = DataTables::of($query)
        ->addIndexColumn() //DT_RowIndex (Penomoran)
        ->addColumn('do_status', function ($data) {
          return $data->details()->count() > 0 ? 'DO Already' : '<span class="red-text">DO not yet assign</span>';
        })
        ->addColumn('lmb', function ($data) {
          return '-';
        })
        ->addColumn('action', function ($data) {
          $action = '';
          $action .= ' ' . get_button_save('Start', '.btn-start');
          $action .= ' ' . get_button_save('Finish', '.btn-start');
          $action .= ' ' . get_button_save('Cancel', '.btn-start');
          // $action .= ' ' . get_button_save('Back to Gate', '.btn-start');
          return $action;
        })
        ->rawColumns(['do_status', 'action']);

      return $datatables->make(true);
    }
    return view('web.outgoing.loading-process.index');
  }
}
