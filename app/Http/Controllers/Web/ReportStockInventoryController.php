<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\InventoryStorage;
use Illuminate\Http\Request;

class ReportStockInventoryController extends Controller
{
    public function index(Request $request)
    {
    	if ($request->ajax()) {
      $query = InventoryStorage::selectRaw('wms_inventori_strorage.*, log_cabang.kode_customer, log_cabang.long_description')
 	     ->leftjoin('wms_master_storage', 'wms_master_storage.id', '=', 'wms_inventory_storage.storage_id')
        ->leftjoin('log_cabang', 'log_cabang.kode_cabang', '=', 'wms_master_storage.kode_cabang')
        ->where('#', $request->input('#'))
        ->get();

      return $datatables->make(true);
    }

      return view('web.report.report-stock-inventory.index');
    }
}
