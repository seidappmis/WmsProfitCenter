<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\InventoryStorage;
use DataTables;
use Illuminate\Http\Request;

class StorageInventoryMonitoringController extends Controller
{
  public function index(Request $request)
  {
    if ($request->ajax()) {
      $query = InventoryStorage::getFullData()->get();

      $datatables = DataTables::of($query)
        ->addIndexColumn() //DT_RowIndex (Penomoran)
        ->addColumn('action', function ($data) {
          $action = '';
          $action .= ' ' . get_button_view(url('storage-inventory-monitoring/' . $data->id), 'View Log');
          return $action;
        })
        ->rawColumns(['do_status', 'action']);

      return $datatables->make(true);
    }

    return view('web.inventory.storage-inventory-monitoring.index');
  }

  public function show($id)
  {
    $data['inventoryStorage'] = InventoryStorage::findOrFail($id);

    return view('web.inventory.storage-inventory-monitoring.view');
  }
}
