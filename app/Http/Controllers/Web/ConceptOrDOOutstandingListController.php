<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Concept;
use App\Models\ManualConcept;
use DataTables;
use DB;
use Illuminate\Http\Request;

class ConceptOrDOOutstandingListController extends Controller
{
  public function index(Request $request)
  {
    if ($request->ajax()) {
      if ($request->input('type') == 'area') {
        $query = Concept::select(
          'tr_concept.*',
          DB::raw('tr_destination.destination_description AS destination_name'),
          DB::raw('users.username AS upload_by')
        )
          ->leftjoin('tr_destination', 'tr_destination.destination_number', '=', 'tr_concept.destination_number')
          ->leftjoin('users', 'users.id', '=', 'tr_concept.created_by')
          ->leftjoin('tr_concept_flow_detail', function ($join) {
            $join->on('tr_concept_flow_detail.invoice_no', '=', 'tr_concept.invoice_no');
            $join->on('tr_concept_flow_detail.line_no', '=', 'tr_concept.line_no');
          })
          ->whereNull('tr_concept_flow_detail.id_header')
          ->where('tr_concept.area', $request->input('area'))
        ;
      } else {
        $query = ManualConcept::select(
          'wms_manual_concept.*'
        )
          ->leftjoin('wms_pickinglist_detail', function ($join) {
            $join->on('wms_pickinglist_detail.invoice_no', '=', 'wms_manual_concept.invoice_no');
            $join->on('wms_pickinglist_detail.delivery_no', '=', 'wms_manual_concept.delivery_no');
            $join->on('wms_pickinglist_detail.delivery_items', '=', 'wms_manual_concept.delivery_items');
          })
          ->whereNull('wms_pickinglist_detail.id')
          ->where('wms_manual_concept.kode_cabang', $request->input('branch'))
        ;
      }

      $datatables = DataTables::of($query)
        ->editColumn('created_at', function ($data) {
          return $data->created_at;
        })
      ;

      return $datatables->make(true);
    }

    return view('web.report.concept-or-do-outstanding-list.index');
  }
}
