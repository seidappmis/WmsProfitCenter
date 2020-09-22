<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\ConceptFlowHeader;
use DataTables;
use Illuminate\Http\Request;

class LoadingStatusListController extends Controller
{
  public function index(Request $request)
  {
    if ($request->ajax()) {
      $query = ConceptFlowHeader::getLoadingSummary($request);

      $datatables = DataTables::of($query)
      ;

      return $datatables->make(true);
    }

    return view('web.report.loading-status-list.index');
  }
}
