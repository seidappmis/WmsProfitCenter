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
      $query = InventoryStorage::all();

      $datatables = DataTables::of($query)
        ->addIndexColumn() //DT_RowIndex (Penomoran)
        ->addColumn('sto_type_desc', function ($data) {
          return $data->storage->sto_type_desc;
        })
        ->addColumn('sto_loc_code_long', function ($data) {
          return $data->storage->sto_loc_code_long;
        })
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
      $query      = MovementTransactionLog::all();
      $datatables = DataTables::of($query)
        ->addIndexColumn() //DT_RowIndex (Penomoran)
      ;

      return $datatables->make(true);
    }

    return view('web.inventory.storage-inventory-monitoring.view', $data);
  }
}
