<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\InventoryStorage;
use App\Models\MovementTransactionLog;
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

      if (!auth()->user()->cabang->hq) {
        $query->where('wms_master_storage.kode_cabang', auth()->user()->cabang->kode_cabang);
      }

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
      $query      = MovementTransactionLog::where('eancode', $data['inventoryStorage']->ean_code);
      $datatables = DataTables::of($query)
        ->addIndexColumn() //DT_RowIndex (Penomoran)
      ;

      return $datatables->make(true);
    }

    return view('web.inventory.storage-inventory-monitoring.view', $data);
  }
}
