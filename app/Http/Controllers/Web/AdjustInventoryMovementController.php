<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\AdjustmentLog;
use Illuminate\Http\Request;

class AdjustInventoryMovementController extends Controller
{
  public function index(Request $request)
  {
    return view('web.inventory.adjust-inventory-movement.index');
  }

  public function store(Request $request)
  {
    $request->validate([
      'sloc' => 'required',
    ]);

    $adjustmentLog = new AdjustmentLog;

    $adjustmentLog->log_id             = date('Y-m-d H:i:s');
    $adjustmentLog->kode_cabang        = $request->input('kode_cabang');
    $adjustmentLog->sloc               = $request->input('sloc');
    $adjustmentLog->model              = $request->input('model');
    $adjustmentLog->quantity           = $request->input('quantity');
    $adjustmentLog->prev_quantity      = $request->input('prev_quantity');
    $adjustmentLog->movement_code_type = $request->input('movement_code_type');

    $adjustmentLog->save();

    return $adjustmentLog;
  }
}
