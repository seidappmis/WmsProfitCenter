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
          tr_destination.destination_description AS destination_name,
          COUNT(tr_concept.line_no) AS total_do_items
        ')
        ->leftjoin('tr_destination', 'tr_destination.destination_number', '=', 'tr_concept.destination_number')
        ->leftjoin('wms_pickinglist_detail', function ($join) {
          $join->on('wms_pickinglist_detail.invoice_no', '=', 'tr_concept.invoice_no');
          $join->on('wms_pickinglist_detail.delivery_no', '=', 'tr_concept.delivery_no');
        })
        ->whereNull('wms_pickinglist_detail.id') // Ambil yang belum masuk picking list
        ->where('area', $request->input('area'))
        ->groupBy('invoice_no', 'delivery_no')
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
      ->where('delivery_no', $request->input('delivery_no'))
      ->delete();
  }

  public function destroySelectedItem(Request $request)
  {
    $data_concept = json_decode($request->input('data_concept'), true);

    foreach ($data_concept as $key => $value) {
      Concept::where('invoice_no', $value['invoice_no'])
        ->where('delivery_no', $value['delivery_no'])
        ->delete();
    }

    return true;

  }
}
