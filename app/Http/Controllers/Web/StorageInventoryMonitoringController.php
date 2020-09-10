<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\InventoryStorage;
use App\Models\MovementTransactionLog;
use DB;
use DataTables;
use Illuminate\Http\Request;

class StorageInventoryMonitoringController extends Controller
{
  public function index(Request $request)
  {
    if ($request->ajax()) {
      $query = InventoryStorage::select(
        'wms_inventory_storage.*',
        'wms_master_storage.sto_type_desc',
        'wms_master_storage.sto_loc_code_long'
      )
        ->leftjoin('wms_master_storage', 'wms_master_storage.id', '=', 'wms_inventory_storage.storage_id');

      $query->where('wms_master_storage.kode_cabang', auth()->user()->cabang->kode_cabang);
      // if (!auth()->user()->cabang->hq) {
      //   $query->where('wms_master_storage.kode_cabang', auth()->user()->cabang->kode_cabang);
      // }

      $datatables = DataTables::of($query)
        ->addIndexColumn() //DT_RowIndex (Penomoran)
        ->addColumn('action', function ($data) {
          $action = '';
          $action .= ' ' . get_button_view(url('storage-inventory-monitoring/' . $data->id), 'View Log');
          return $action;
        })
      ;

      return $datatables->make(true);
    }

    return view('web.inventory.storage-inventory-monitoring.index');
  }

  public function show(Request $request, $id)
  {
    $data['inventoryStorage'] = InventoryStorage::findOrFail($id);

    if ($request->ajax()) {
      $query      = MovementTransactionLog::select(
        'wms_movement_transaction_log.*',
        DB::raw('wms_master_movement_type.action AS movement_action')
      )
      ->where('eancode', $data['inventoryStorage']->ean_code)
      ->whereRaw('( wms_movement_transaction_log.storage_location_from = ' . $data['inventoryStorage']->storage->sto_loc_code_long . ' OR wms_movement_transaction_log.storage_location_to = ' . $data['inventoryStorage']->storage->sto_loc_code_long . ' )')
      ->leftjoin('wms_master_movement_type', 'wms_master_movement_type.id', '=', 'wms_movement_transaction_log.mvt_master_id')
      ;
      $datatables = DataTables::of($query)
        ->addIndexColumn() //DT_RowIndex (Penomoran)
        ->addColumn('ref', function ($data) {
          $ref = $data->arrival_no;

          return $ref;
        })
        ->editColumn('quantity', function ($data) {
          return ($data->movementType->action == "DECREASE" ? '- ' : '+ ') . $data->quantity;
        })
        ->editColumn('created_at', function ($data) {
          return $data->created_at;
        })
      ;

      return $datatables->make(true);
    }

    return view('web.inventory.storage-inventory-monitoring.view', $data);
  }
}
