<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Gate;
use Illuminate\Http\Request;

class SelectGateController extends Controller
{
  public function index(Request $request)
  {
    if ($request->ajax()) {
      $gates = Gate::getLoadingGate($request->input('area'))->select(
        'tr_gate.id',
        'tr_gate.gate_number',
        'tr_gate.description',
        't.*',
      )
        ->get();

      return $gates;
    }
    return view('web.outgoing.select-gate.index');
  }
}
