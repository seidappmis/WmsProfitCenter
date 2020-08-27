<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LOGConceptOverload;
use DataTables;

class OverloadConceptOrDoController extends Controller
{
  public function index(Request $request)
  {
    if ($request->ajax()) {
      $query = LOGConceptOverload::selectRaw('
          log_concept_overload.*,
          tr_destination.destination_description AS destination_name
        ')
        ->leftjoin('tr_destination', 'tr_destination.destination_number', '=', 'log_concept_overload.destination_number')
        ->where('area', $request->input('area'))
      ;

      $datatables = DataTables::of($query)
        ->addIndexColumn() //DT_RowIndex (Penomoran)
        ->addColumn('action', function ($data) {
          $action = '';
          $action .= ' ' . get_button_delete();
          return $action;
        });

      return $datatables->make(true);
    }
    
    return view('web.outgoing.overload-concept-or-do.index');
  }
}
