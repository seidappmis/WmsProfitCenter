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
        ->leftjoin('wms_master_storage', 'wms_master_storage.sto_loc_code_long', '=' ,'wms_inventori_strorage.ean_code')
        ->where('kode_cabang', $request->input('cabang'))
        ->where('model_name',$request->input('model'))
        ->where('stoc_loc_long', $request->input('location'))
        // ->where('kode_cabang', $request->input('status'))
        ->get();

      return $datatables->make(true);
    }

      return view('web.report.report-stock-inventory.index');
    }
}
