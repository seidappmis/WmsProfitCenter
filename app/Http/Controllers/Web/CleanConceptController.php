<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Concept;
use DataTables;
use Illuminate\Http\Request;

class CleanConceptController extends Controller
{
  public function index(Request $request)
  {
    if ($request->ajax()) {
      $query = Concept::selectRaw('
          tr_concept.*,
          tr_destination.destination_description AS destination_name
        ')
        ->leftjoin('tr_destination', 'tr_destination.destination_number', '=', 'tr_concept.destination_number')
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

    return view('web.others.clean-concept.index');
  }

  public function destroy(Request $request)
  {
    return Concept::where('invoice_no', $request->input('invoice_no'))
      ->where('line_no', $request->input('line_no'))
      ->delete();
  }

  public function destroySelectedItem(Request $request)
  {
    $data_concept = json_decode($request->input('data_concept'), true);

    foreach ($data_concept as $key => $value) {
      Concept::where('invoice_no', $value['invoice_no'])
        ->where('line_no', $value['line_no'])
        ->delete();
    }

    return true;

  }
}
