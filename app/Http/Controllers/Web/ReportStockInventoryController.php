<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\InventoryStorage;
use DataTables;
use Illuminate\Http\Request;

class ReportStockInventoryController extends Controller
{
  public function index(Request $request)
  {
    if ($request->ajax()) {
      $query = InventoryStorage::selectRaw('wms_inventory_storage.*, log_cabang.kode_customer, log_cabang.long_description, wms_master_storage.sto_loc_code_long')
        ->leftjoin('wms_master_storage', 'wms_master_storage.id', '=', 'wms_inventory_storage.storage_id')
        ->leftjoin('log_cabang', 'log_cabang.kode_cabang', '=', 'wms_master_storage.kode_cabang')
        ->where('log_cabang.kode_cabang', $request->input('cabang'))
        ;

      if (!empty($request->input('model'))) {
        $query->where('model_name', $request->input('model'));
      }

      if (!empty($request->input('location'))) {
        $query->where('storage_id', $request->input('location'));
      }

      $datatables = DataTables::of($query)
        ->addIndexColumn() //DT_RowIndex (Penomoran)
      ;

      return $datatables->make(true);
    }

    return view('web.report.report-stock-inventory.index');
  }
}
