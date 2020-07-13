<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\AdjustmentLog;
use App\Models\InventoryStorage;
use DB;
use Illuminate\Http\Request;

class AdjustInventoryMovementController extends Controller
{
  public function index(Request $request)
  {
    return view('web.inventory.adjust-inventory-movement.index');
  }

  /**
   * Insert Data Log Adjustment
   * Update Inventory
   * @param  Request $request [description]
   * @return [type]           [description]
   */
  public function store(Request $request)
  {
    $request->validate([
      'sloc' => 'required',
    ]);

    return DB::transaction(function () use ($request) {
      $adjustmentLog = new AdjustmentLog;

      $adjustmentLog->log_id             = date('Y-m-d H:i:s');
      $adjustmentLog->kode_cabang        = $request->input('kode_cabang');
      $adjustmentLog->sloc               = $request->input('sloc');
      $adjustmentLog->model              = $request->input('model_name');
      $adjustmentLog->quantity           = $request->input('quantity');
      $adjustmentLog->prev_quantity      = $request->input('prev_quantity');
      $adjustmentLog->movement_code_type = $request->input('movement_code_type');

      $adjustmentLog->save();

      $total_cbm = $adjustmentLog->quantity * $request->input('cbm');

      // Update Or Create Inventory Stroage data
      InventoryStorage::updateOrCreate(
        // Condition
        [
          'storage_id' => $adjustmentLog->sloc,
          'model_name' => $adjustmentLog->model,
        ],
        // Data Update
        [
          'ean_code'       => $request->input('ean_code'),
          'quantity_total' => DB::raw('IF(ISNULL(quantity_total), 0, quantity_total) ' . ($request->input('movement_code_type_action') == "INCREASE" ? '+' : '-') . $adjustmentLog->quantity),
          'cbm_total'      => DB::raw('IF(ISNULL(cbm_total), 0, cbm_total) ' . ($request->input('movement_code_type_action') == "INCREASE" ? '+' : '-') . $total_cbm),
          'last_updated'   => date('Y-m-d H:i:s'),
        ]
      );
      return $adjustmentLog;
    });

  }
}
