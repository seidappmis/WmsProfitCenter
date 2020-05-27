<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gate;

class SelectGateController extends Controller
{
  public function index(Request $request)
  {
    if ($request->ajax()) {
      $gates = Gate::where('area', $request->input('area'))->get();

      return $gates;
    }
    return view('web.outgoing.select-gate.index');
  }
}
