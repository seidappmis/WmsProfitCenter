<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Gate;
use DB;
use Illuminate\Http\Request;

class SelectGateController extends Controller
{
  public function index(Request $request)
  {
    if ($request->ajax()) {
      $gates = Gate::select(DB::raw('tr_gate.*, wms_pickinglist_header.vehicle_number, wms_pickinglist_header.driver_id'))
        ->leftjoin('wms_pickinglist_header', function ($join) use ($request) {
          $join->on('wms_pickinglist_header.gate_number', '=', 'tr_gate.gate_number')
          ;
        })
        ->whereRaw('tr_gate.area = ?', [$request->input('area')])
        ->orderBy('tr_gate.gate_number')
        ->get();

      return $gates;
    }
    return view('web.outgoing.select-gate.index');
  }
}
