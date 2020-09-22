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

      if (!empty($request->input('invoice_no'))) {
        $query->where('tr_concept.invoice_no', $request->input('invoice_no'));
      }

      if (!empty($request->input('delivery_no'))) {
        $query->where('tr_concept.delivery_no', $request->input('delivery_no'));
      }

      if (!empty($request->input('vehicle_number'))) {
        $query->where('tr_driver_registered.vehicle_number', $request->input('vehicle_number'));
      }

      $datatables = DataTables::of($query)
      ;

      return $datatables->make(true);
    }

    return view('web.report.loading-status-list.index');
  }
}
