<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\LOGConceptOverload;
use DataTables;
use Illuminate\Http\Request;

class ReportOverloadConceptOrDOController extends Controller
{
  public function index(Request $request)
  {
    if ($request->ajax()) {
      $query = LOGConceptOverload::select(
        'log_concept_overload.*'
      )
      ;

      $query->where('log_concept_overload.area', $request->input('area'));
      $query->where('log_concept_overload.created_at', '>=', date('Y-m-d', strtotime($request->input('start_date'))));
      $query->where('log_concept_overload.created_at', '<=', date('Y-m-d', strtotime($request->input('end_date'))));

      $datatables = DataTables::of($query)
        ->editColumn('created_at', function ($data) {
          return $data->created_at;
        })
      ;

      return $datatables->make(true);
    }

    return view('web.report.report-overload-concept-or-do.index');
  }
}
