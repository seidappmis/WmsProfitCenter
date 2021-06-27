<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\InventoryStorage;
use App\Models\MovementTransactionLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

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

			// $query->where('wms_master_storage.kode_cabang', auth()->user()->cabang->kode_cabang);
			$query->whereIn('wms_master_storage.kode_cabang', auth()->user()->getStringGrantCabang());
			// if (!auth()->user()->cabang->hq) {
			//   $query->where('wms_master_storage.kode_cabang', auth()->user()->cabang->kode_cabang);
			// }

			$datatables = DataTables::of($query)
				->addIndexColumn() //DT_RowIndex (Penomoran)
				->addColumn('action', function ($data) {
					$action = '';
					$action .= ' ' . get_button_view(url('storage-inventory-monitoring/' . $data->id), 'View Log');
					return $action;
				});

			return $datatables->make(true);
		}

		return view('web.inventory.storage-inventory-monitoring.index');
	}

	public function check(Request $request){
		if($request->ajax()){
			$masuk = MovementTransactionLog::whereNotNull('storage_location_to')
					->groupBy([
						'model', 
						'storage_id'
					])
					->select([
						'model',
						'storage_location_to as storage_id',
						DB::raw('SUM(IF(quantity IS NOT NULL, quantity, 0)) as quantity')
					]);
			$keluar = MovementTransactionLog::whereNotNull('storage_location_from')
					->groupBy([
						'model',
						'storage_id'
					])
					->select([
						'model',
						'storage_location_from as storage_id',
						DB::raw('SUM(IF(quantity IS NOT NULL, quantity, 0)) as quantity')
					]);
			$query = InventoryStorage::join('wms_master_storage as mst', 'mst.id', 'wms_inventory_storage.storage_id')
						->leftJoinSub($masuk, 'masuk', function($join){
							$join->on('masuk.model', '=', 'wms_inventory_storage.model_name');
							$join->on('masuk.storage_id', '=', 'mst.sto_loc_code_long');
						})
						->leftJoinSub($keluar, 'keluar', function($join){
							$join->on('keluar.model', '=', 'wms_inventory_storage.model_name');
							$join->on('keluar.storage_id', '=', 'mst.sto_loc_code_long');
						})
						->select([
							'wms_inventory_storage.id',
							'model_name',
							'mst.sto_loc_code_long as storage_id',
							'quantity_total',
							DB::raw('(masuk.quantity - keluar.quantity) as quantity_log'),
						]);
			$datatables = DataTables::of($query)
				->addIndexColumn()
				->addColumn('selisih_log', function($data){
					return $data->quantity_total - $data->quantity_log;
				})
				->addColumn('action', function($data){
					$action = ' ' . get_button_view(url('stock-check/' . $data->id), 'View Log') ;
					return $action;
				});
			
			return $datatables->make(true);
		}
		return view('web.inventory.storage-inventory-monitoring.check');
	}

	public function show(Request $request, $id)
	{
		$data['inventoryStorage'] = InventoryStorage::findOrFail($id);

		if ($request->ajax()) {
			$query = MovementTransactionLog::select(
				'wms_movement_transaction_log.*',
				DB::raw('wms_master_movement_type.action AS movement_action')
			)
				->where('eancode', $data['inventoryStorage']->ean_code)
				->whereRaw('( wms_movement_transaction_log.storage_location_from = ' . $data['inventoryStorage']->storage->sto_loc_code_long . ' OR wms_movement_transaction_log.storage_location_to = ' . $data['inventoryStorage']->storage->sto_loc_code_long . ' )')
				->leftjoin('wms_master_movement_type', 'wms_master_movement_type.id', '=', 'wms_movement_transaction_log.mvt_master_id');
			$datatables = DataTables::of($query)
				->addIndexColumn() //DT_RowIndex (Penomoran)
				->addColumn('ref', function ($data) {
					$ref = $data->arrival_no;
					$ref .= $data->do_manifest_no;

					return $ref;
				})
				->editColumn('quantity', function ($data) {
					return ($data->movementType->action == "DECREASE" ? '- ' : '+ ') . $data->quantity;
				})
				->editColumn('created_at', function ($data) {
					return $data->created_at;
				});

			return $datatables->make(true);
		}

		return view('web.inventory.storage-inventory-monitoring.view', $data);
	}
}
