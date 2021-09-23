<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Concept;
use App\Models\ConceptFlowHeader;
use App\Models\ConceptTruckFlow;
use App\Models\InventoryStorage;
use App\Models\LMBDetail;
use App\Models\LMBHeader;
use App\Models\LOGConceptOverload;
use App\Models\ManualConcept;
use App\Models\MasterCabang;
use App\Models\MasterModel;
use App\Models\MovementTransactionLog;
use App\Models\PickinglistDetail;
use App\Models\PickinglistHeader;
use App\Models\StorageMaster;
use DataTables;
use DB;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class PickingToLMBController extends Controller
{
	public function index(Request $request)
	{
		if ($request->ajax()) {
			$query = LMBHeader::select('wms_lmb_header.*')
				->leftjoin('wms_pickinglist_header', 'wms_pickinglist_header.driver_register_id', '=', 'wms_lmb_header.driver_register_id');

			if (auth()->user()->cabang->hq) {
				// Tampilkan data yang belum ada manifest bila tidak di search
				$query->leftjoin('log_manifest_header', 'log_manifest_header.driver_register_id', '=', 'wms_lmb_header.driver_register_id');
				if (empty($request->input('search')['value'])) {
					$query->whereRaw('((log_manifest_header.status_complete IS NULL) OR (log_manifest_header.status_complete != 1))');
				}
				if (auth()->user()->area == 'All') {
					$query->where('wms_pickinglist_header.hq', 1);
				} else {
					$query->where('wms_lmb_header.kode_cabang', auth()->user()->cabang->kode_cabang);
				}
			} else {
				// Tampilkan data yang belum ada manifest bila tidak di search
				$query->leftjoin('wms_branch_manifest_header', 'wms_branch_manifest_header.driver_register_id', '=', 'wms_lmb_header.driver_register_id');
				if (empty($request->input('search')['value'])) {
					$query->whereNull('wms_branch_manifest_header.driver_register_id');
				}
				$query->where('wms_lmb_header.kode_cabang', auth()->user()->cabang->kode_cabang);
			}

			$query->whereNotNull('wms_pickinglist_header.picking_no');
			$query->groupBy('wms_lmb_header.driver_register_id');

			$datatables = DataTables::of($query)
				->addIndexColumn() //DT_RowIndex (Penomoran)
				// ->editColumn('destination_name', function ($data) {
				//   return $data->getDestinationName($data);
				// })
				->addColumn('picking_no', function ($data) {
					return $data->getPickingNo($data);
				})
				->addColumn('action', function ($data) {
					$action = '';
					$action .= ' ' . get_button_view(url('picking-to-lmb/' . $data->driver_register_id), 'View Detail');
					if (!$data->send_manifest) {
						$action .= ' ' . get_button_delete('Cancel');
					}
					return $action;
				})
				->rawColumns(['do_status', 'action']);

			return $datatables->make(true);
		}
		return view('web.picking.picking-to-lmb.index');
	}

	public function updateVehicleNumber(Request $request, $id)
	{
		$lmbHeader                 = LMBHeader::findOrFail($id);
		$lmbHeader->vehicle_number = $request->input('vehicle_number');
		$lmbHeader->save();
		return sendSuccess('Succes Save Vehicle No ' . $lmbHeader->vehicle_number, $lmbHeader);
	}

	public function show(Request $request, $id)
	{
		$data['lmbHeader'] = LMBHeader::findOrFail($id);

		if ($request->ajax()) {
			$details = $data['lmbHeader']->details;
			return sendSuccess('Seat Loading Quantity', $details);
		}

		$tempDetailLMB = LMBDetail::selectRaw('
        wms_lmb_detail.invoice_no,
        wms_lmb_detail.delivery_no,
        wms_lmb_detail.model,
        wms_lmb_detail.code_sales,
        wms_lmb_detail.delivery_items,
        COUNT(serial_number) AS qty_loading
      ')
			->where('driver_register_id', $id)
			->groupBy('invoice_no', 'delivery_no', 'model', 'delivery_items')
			->get();

		$rsLoadingQuantity = [];
		foreach ($tempDetailLMB as $key => $value) {
			$rsLoadingQuantity[$value->invoice_no . $value->delivery_no . $value->model . $value->delivery_items] = $value->qty_loading;
		}
		$data['rsLoadingQuantity'] = $rsLoadingQuantity;

		// $data['pickingListDetail'] = PickinglistHeader::where('driver_register_id', $id)->first()->details;
		/*
		$data['pickingListDetail'] = PickinglistDetail::select('wms_pickinglist_detail.*')
			->leftjoin('wms_pickinglist_header', 'wms_pickinglist_header.id', '=', 'wms_pickinglist_detail.header_id')
			->where('wms_pickinglist_header.driver_register_id', $id)
			->get();
		*/
		$dataPickingListDetail = PickinglistDetail::leftJoin('wms_pickinglist_header', 'wms_pickinglist_header.id', '=', 'wms_pickinglist_detail.header_id')
			->where('wms_pickinglist_header.driver_register_id', $id);

		if ($data['lmbHeader']->send_manifest) {
			$pickingListFields = [
				'wms_pickinglist_detail.id',
				'wms_pickinglist_detail.header_id',
				'wms_pickinglist_detail.invoice_no',
				'wms_pickinglist_detail.line_no',
				'wms_pickinglist_detail.delivery_no',
				'wms_pickinglist_detail.delivery_items',
				'wms_pickinglist_detail.model',
				'wms_pickinglist_detail.quantity',
				'wms_pickinglist_detail.cbm',
				'wms_pickinglist_detail.ean_code',
				'wms_pickinglist_detail.code_sales',
				'wms_pickinglist_detail.remarks',
				'wms_pickinglist_detail.kode_customer',
				'wms_pickinglist_detail.created_at',
				'wms_pickinglist_detail.updated_at',
				'wms_pickinglist_detail.created_by',
				'wms_pickinglist_detail.updated_by'
			];
			$dataPickingListDetail = $dataPickingListDetail->leftJoin('wms_lmb_detail', 'wms_lmb_detail.picking_detail_id', '=', 'wms_pickinglist_detail.id')
				->where('wms_lmb_detail.no_manifest', 1)
				->select($pickingListFields)
				->groupBy($pickingListFields);
		}

		$data['pickingListDetail'] = $dataPickingListDetail->get();

		// echo "<pre>";
		// print_r($data['rsLoadingQuantity']);
		// exit;
		// $data['rs_loading_quantity'] = $data['lmbHeader']
		//   ->details
		//   ->selectRaw('
		//     wms_lmb_detail.invoice_no,
		//     wms_lmb_detail.delivery_no,
		//     wms_lmb_detail.model,
		//     COUNT(serial_number) AS qty_loading,
		//     wms_lmb_detail.code_sales,
		//     wms_pickinglist_detail.quantity
		//   ')
		//   ->leftjoin('wms_pickinglist_header', 'wms_pickinglist_header.id', '=', 'wms_lmb_detail.picking_id')
		//   ->leftjoin('wms_pickinglist_detail', function ($join) {
		//     $join->on('wms_pickinglist_detail.invoice_no', '=', 'wms_lmb_detail.invoice_no');
		//     $join->on('wms_pickinglist_detail.delivery_no', '=', 'wms_lmb_detail.delivery_no');
		//     $join->on('wms_pickinglist_detail.model', '=', 'wms_lmb_detail.model');
		//   })
		//   ->groupBy('delivery_no', 'model')
		//   ->get();

		return view('web.picking.picking-to-lmb.view', $data);
	}

	public function getDetailsLMB(Request $request, $driver_register_id)
	{
		if ($request->ajax()) {
			$query = LMBDetail::where('driver_register_id', $driver_register_id)
				->get();

			$datatables = DataTables::of($query)
				->addIndexColumn() //DT_RowIndex (Penomoran)
			;

			return $datatables->make(true);
		}
	}

	public function updateSerialNumber(Request $request)
	{
		$lmbDetail = LMBdetail::findOrFail($request->input('serial_number'));
		$check_serial_number = LMBdetail::find($request->input('new_serial_number'));

		if (!empty($check_serial_number) && $request->input('serial_number') !== $request->input('new_serial_number')) {
			return sendError('Serial Number Already Exist', $lmbDetail);
		}

		$lmbDetail->serial_number = $request->input('new_serial_number');

		if ($request->input('delivery_no') !== $request->input('new_delivery_no')) {
			$lmbDetail->delivery_no = $request->input('new_delivery_no');
			$lmbDetail->delivery_items = $request->input('delivery_items');
			$lmbDetail->invoice_no = $request->input('invoice_no');
			$lmbDetail->kode_customer = $request->input('kode_customer');
			$lmbDetail->code_sales = $request->input('code_sales');
		}

		$lmbDetail->updated_at = date('Y-m-d H:i:s');
		$lmbDetail->updated_by = auth()->user()->id;

		$lmbDetail->save();

		return sendSuccess('Success update serial number.', $lmbDetail);
	}

	public function store(Request $request)
	{
		$request->validate([
			'picking_no' => 'required',
			// 'seal_no'      => 'required',
			// 'container_no' => 'required',
		]);

		$picking = PickinglistHeader::where('picking_no', $request->input('picking_no'))->first();

		if ($picking->city_code != 'AS' and auth()->user()->cabang->hq) {
			if (empty($picking->driver_register)) {
				return sendError('Driver have not assigned.');
			}
		}

		$lmbHeader                     = new LMBHeader;
		$lmbHeader->driver_register_id = $request->input('driver_register_id');
		$lmbHeader->lmb_date           = date('Y-m-d');
		// $lmbHeader->do_reservation_no        = '';
		// $lmbHeader->pdo                      = '';
		$lmbHeader->expedition_code    = $picking->expedition_code;
		$lmbHeader->expedition_name    = $picking->expedition_name;
		$lmbHeader->driver_id          = $picking->driver_id;
		$lmbHeader->driver_name        = $picking->driver_name;
		$lmbHeader->vehicle_number     = $picking->vehicle_number;
		$lmbHeader->destination_number = $picking->getDestinationNumber($picking);
		$lmbHeader->destination_name   = $picking->getDestinationName($picking);
		$lmbHeader->kode_cabang        = $picking->kode_cabang;

		$cabang = MasterCabang::where('kode_cabang', $lmbHeader->kode_cabang)->first();

		$lmbHeader->short_description_cabang = auth()->user()->cabang->hq ? auth()->user()->area_data->code : $cabang->short_description;
		$lmbHeader->seal_no                  = $request->input('seal_no');
		$lmbHeader->container_no             = $request->input('container_no');
		$lmbHeader->send_manifest            = 0;

		$lmbHeader->start_date  = $lmbHeader->getStartDate();
		$lmbHeader->finish_date = date('Y-m-d H:i:s');
		$lmbHeader->finish_by   = auth()->user()->id;
		$lmbHeader->created_by  = auth()->user()->id;

		if ($picking->expedition_code == 'AS') {
			$lmbHeader->destination_number = $picking->expedition_code;
			$lmbHeader->destination_name   = $picking->expedition_name;
		}
		// $lmbHeader->start_date               = '';
		// $lmbHeader->finish_date              = '';
		// $lmbHeader->finish_by                = '';

		$lmbHeader->save();

		return sendSuccess('Data Created.', $lmbHeader);
	}

	/**
	 * Stock di 1 class berkurang dan stock di intransit bertambah
	 */
	public function sendManifest(Request $request, $id)
	{
		$lmbHeader = LMBHeader::findOrFail($id);

		if (($lmbHeader->send_manifest == 1) && ($lmbHeader->details()->where('no_manifest', 1)->count() <= 0)) {
			return sendError('Manifest already sent!');
		}

		try {
			DB::beginTransaction();

			if (auth()->user()->cabang->hq && $lmbHeader->destination_number != 'AS') {
				$conceptFlowHeader              = ConceptFlowHeader::findOrFail($lmbHeader->driver_register_id);
				$conceptFlowHeader->workflow_id = 5;
				$conceptFlowHeader->save();

				$conceptTruckFlow = ConceptTruckFlow::where('concept_flow_header', $conceptFlowHeader->id)->first();
				if (!empty($conceptTruckFlow)) {
					$conceptTruckFlow->start_date         = $lmbHeader->start_date;
					$conceptTruckFlow->end_date           = $lmbHeader->finish_date;
					$lmbCreatedDetail                     = $lmbHeader->detail_created_date();
					$conceptTruckFlow->created_start_date = $lmbCreatedDetail->created_start_date;
					$conceptTruckFlow->created_end_date   = $lmbCreatedDetail->created_end_date;
					$conceptTruckFlow->save();
				}
			}

			$lmbHeader->send_manifest = 1;

			$rs_picking_detail_id        = $request->input('picking_detail_id');
			$rs_picking_quantity         = $request->input('picking_quantity');
			$rs_picking_quantity_loading = $request->input('picking_quantity_loading');

			foreach ($rs_picking_detail_id as $key => $value) {
				if ($rs_picking_quantity_loading[$key] <= 0) {
					// DELETE Picking List Detail
					PickinglistDetail::destroy($value);
				} elseif ($rs_picking_quantity_loading[$key] < $rs_picking_quantity[$key]) {
					// update quantity Pickinglist
					$picking_detail           = PickinglistDetail::find($rs_picking_detail_id[$key]);
					$picking_detail->quantity = $rs_picking_quantity_loading[$key];
					$cbm_before               = $picking_detail->cbm;
					$cbm_unit                 = $picking_detail->cbm / $rs_picking_quantity[$key];
					$picking_detail->cbm      = $cbm_unit * $rs_picking_quantity_loading[$key];
					$picking_detail->save();

					if (auth()->user()->cabang->hq) {
						$concept = Concept::where('invoice_no', $picking_detail->invoice_no)
							->where('line_no', $picking_detail->line_no)->first();
					} else {
						$concept = ManualConcept::where('invoice_no', $picking_detail->invoice_no)
							->where('delivery_no', $picking_detail->delivery_no)
							->where('delivery_items', $picking_detail->delivery_items)
							->first();
					}

					// Overload picking
					$logConceptOverload                     = new LOGConceptOverload;
					$logConceptOverload->invoice_no         = $picking_detail->invoice_no;
					$logConceptOverload->line_no            = $picking_detail->line_no;
					$logConceptOverload->output_date        = $concept->output_date;
					$logConceptOverload->output_time        = $concept->output_time;
					$logConceptOverload->destination_number = $picking_detail->header->destination_number;
					$logConceptOverload->vehicle_code_type  = $picking_detail->header->vehicle_code_type;
					$logConceptOverload->car_no             = $concept->car_no;
					$logConceptOverload->cont_no            = $concept->cont_no;
					$logConceptOverload->checkin_date       = $concept->checkin_date;
					$logConceptOverload->checkin_time       = $concept->checkin_time;
					$logConceptOverload->expedition_id      = $picking_detail->header->expedition_id;
					$logConceptOverload->delivery_no        = $picking_detail->delivery_no;
					$logConceptOverload->delivery_items     = $picking_detail->delivery_items;
					$logConceptOverload->model              = $picking_detail->model;
					$logConceptOverload->quantity           = $rs_picking_quantity[$key] - $rs_picking_quantity_loading[$key];
					$logConceptOverload->cbm                = $cbm_unit * $logConceptOverload->quantity;
					$logConceptOverload->ship_to            = $concept->ship_to;
					$logConceptOverload->sold_to            = $concept->sold_to;
					$logConceptOverload->ship_to_city       = $picking_detail->header->city_name;
					$logConceptOverload->ship_to_district   = $concept->ship_to_district;
					$logConceptOverload->ship_to_street     = $concept->ship_to_street;
					$logConceptOverload->sold_to_city       = $concept->sold_to_city;
					$logConceptOverload->sold_to_district   = $concept->sold_to_district;
					$logConceptOverload->sold_to_street     = $concept->sold_to_street;
					$logConceptOverload->created_at         = date('Y-m-d H:i:s');
					$logConceptOverload->created_by         = auth()->user()->id;
					$logConceptOverload->split_date         = date('Y-m-d H:i:s');
					$logConceptOverload->area               = $picking_detail->header->area;
					$logConceptOverload->expedition_name    = $picking_detail->header->expedition_name;
					$logConceptOverload->ship_to_code       = $concept->ship_to_code;
					$logConceptOverload->sold_to_code       = $concept->sold_to_code;
					$logConceptOverload->expedition_code    = $concept->expedition_code;
					$logConceptOverload->code_sales         = $picking_detail->code_sales;
					$logConceptOverload->status_confirm     = 0;
					$logConceptOverload->overload_reason    = 'AUTO OVERLOAD BY SYSTEM FROM LMB';
					$logConceptOverload->quantity_before    = $rs_picking_quantity[$key];
					$logConceptOverload->cbm_before         = $cbm_before;

					$logConceptOverload->save();
				}
			}

			$details = $lmbHeader
				->details()
				->select(
					'wms_lmb_detail.*',
					'wms_pickinglist_header.storage_id',
					'wms_pickinglist_header.picking_no',
					'wms_master_storage.sto_loc_code_long'
				)
				->leftjoin('wms_pickinglist_header', 'wms_pickinglist_header.picking_no', '=', 'wms_lmb_detail.picking_id')
				->leftjoin('wms_master_storage', 'wms_master_storage.id', '=', 'wms_pickinglist_header.storage_id');
			
			if ($lmbHeader->send_manifest == 1) {
				$details = $details->where('no_manifest' , 1);
			}
			
			$details = $details->get();

			$rs_models = [];

			foreach ($details as $key => $value) {
				if (empty($rs_models[$value->model . $value->code_sales])) {
					$model                      = [];
					$model['model']             = $value->model;
					$model['storage_id']        = $value->storage_id;
					$model['sto_loc_code_long'] = $value->sto_loc_code_long;
					$model['ean_code']          = $value->ean_code;
					$model['code_sales']        = $value->code_sales;
					$model['picking_no']        = $value->picking_no;
					$model['qty']               = 0;
					$model['cbm_total']         = 0;

					$model['kode_cabang'] = substr($value->kode_customer, 0, 2);

					$rs_models[$value->model . $value->code_sales] = $model;
				}

				$rs_models[$value->model . $value->code_sales]['qty'] += 1;
				$rs_models[$value->model . $value->code_sales]['cbm_total'] += $value->cbm_unit;

				$value->no_manifest = 0;
				$value->save();
			}

			// print_r($rs_models);
			// exit;
			$date_now = date('Y-m-d H:i:s');

			// Storage Intransit
			// 3 Intransit BR
			// $storageIntransit['BR'] = StorageMaster::where('sto_type_id', 3)
			//   ->where('kode_cabang', $lmbHeader->kode_cabang)
			//   ->first();
			$intransitBR = StorageMaster::where('sto_type_id', 3)
				->get();

			foreach ($intransitBR as $key => $value) {
				$storageIntransit['BR'][$value->kode_cabang] = $value;
			}

			// 4 Intransit DS
			// $storageIntransit['DS'] = StorageMaster::where('sto_type_id', 4)
			//   ->where('kode_cabang', $lmbHeader->kode_cabang)
			//   ->first();
			$intranstDS = StorageMaster::where('sto_type_id', 4)
				->get();

			foreach ($intranstDS as $key => $value) {
				$storageIntransit['DS'][$value->kode_cabang] = $value;
			}

			$rs_movement_transaction_log = [];

			// Update Movement 1 class berkurang intransit bertambah
			foreach ($rs_models as $key => $value) {
				// Update Or Create Inventory Stroage data
				InventoryStorage::updateOrCreate(
					// Condition
					[
						'storage_id' => $value['storage_id'],
						'model_name' => $value['model'],
					],
					// Data Update
					[
						'ean_code'       => $value['ean_code'],
						'quantity_total' => DB::raw('IF(ISNULL(quantity_total), 0, quantity_total) - ' . $value['qty']),
						'cbm_total'      => DB::raw('IF(ISNULL(cbm_total), 0, cbm_total) - ' . $value['cbm_total']),
						'last_updated'   => $date_now,
					]
				);

				InventoryStorage::updateOrCreate(
					// Condition
					[
						'storage_id' => $storageIntransit[$value['code_sales']][$value['kode_cabang']]->id,
						'model_name' => $value['model'],
					],
					// Data Update
					[
						'ean_code'       => $value['ean_code'],
						'quantity_total' => DB::raw('IF(ISNULL(quantity_total), 0, quantity_total) + ' . $value['qty']),
						'cbm_total'      => DB::raw('IF(ISNULL(cbm_total), 0, cbm_total) + ' . $value['cbm_total']),
						'last_updated'   => $date_now,
					]
				);

				// ADD MOVEMENT
				// Movement Code
				// id 7 Code 101 Increase Menambah Sloc Intransit HQ
				// id 16 Code 9Z3 Increase Menambah Sloc Intransit BRANCH
				$movement_transaction_log['log_id']                = Uuid::uuid4()->toString();
				$movement_transaction_log['arrival_no']            = $value['picking_no'];
				$movement_transaction_log['mvt_master_id']         = auth()->user()->cabang->hq ? 7 : 16;
				$movement_transaction_log['inventory_movement']    = 'Stock INCREASE';
				$movement_transaction_log['movement_code']         = auth()->user()->cabang->hq ? 101 : '9Z3';
				$movement_transaction_log['transactions_desc']     = 'Add LMB Outgoing';
				$movement_transaction_log['storage_location_from'] = $value['sto_loc_code_long'];
				$movement_transaction_log['storage_location_to']   = $storageIntransit[$value['code_sales']][$value['kode_cabang']]->sto_loc_code_long;
				$movement_transaction_log['storage_location_code'] = $movement_transaction_log['storage_location_from'] . ' & ' . $movement_transaction_log['storage_location_to'];
				$movement_transaction_log['eancode']               = $value['ean_code'];
				$movement_transaction_log['model']                 = $value['model'];
				$movement_transaction_log['quantity']              = $value['qty'];
				$movement_transaction_log['created_at']            = $date_now;
				$movement_transaction_log['flow_id']               = '';
				$movement_transaction_log['kode_cabang']           = $lmbHeader->kode_cabang;
				$movement_transaction_log['created_by']            = auth()->user()->id;

				$rs_movement_transaction_log[] = $movement_transaction_log;

				// id 8 Code 647 Decrease Mengurangi SLOC HQ
				// id 17 Code 9Z3 Decrease Mengurangi SLOC BRANCH
				$movement_transaction_log['log_id']                = Uuid::uuid4()->toString();
				$movement_transaction_log['arrival_no']            = $value['picking_no'];
				$movement_transaction_log['mvt_master_id']         = auth()->user()->cabang->hq ? 8 : 17;
				$movement_transaction_log['inventory_movement']    = 'Stock DECREASE';
				$movement_transaction_log['movement_code']         = auth()->user()->cabang->hq ? 647 : '9Z3';
				$movement_transaction_log['transactions_desc']     = 'Add LMB Outgoing';
				$movement_transaction_log['storage_location_from'] = $value['sto_loc_code_long'];
				$movement_transaction_log['storage_location_to']   = $storageIntransit[$value['code_sales']][$value['kode_cabang']]->sto_loc_code_long;
				$movement_transaction_log['storage_location_code'] = $movement_transaction_log['storage_location_from'] . ' & ' . $movement_transaction_log['storage_location_to'];
				$movement_transaction_log['eancode']               = $value['ean_code'];
				$movement_transaction_log['model']                 = $value['model'];
				$movement_transaction_log['quantity']              = $value['qty'];
				$movement_transaction_log['created_at']            = $date_now;
				$movement_transaction_log['flow_id']               = '';
				$movement_transaction_log['kode_cabang']           = $lmbHeader->kode_cabang;
				$movement_transaction_log['created_by']            = auth()->user()->id;

				$rs_movement_transaction_log[] = $movement_transaction_log;
			}

			MovementTransactionLog::insert($rs_movement_transaction_log);

			$lmbHeader->save();

			DB::commit();

			return sendSuccess('LMB Send Manifest', $lmbHeader);
		} catch (Exception $e) {
			DB::rollBack();
		}
	}

	public function upload(Request $request)
	{
		$request->validate([
			'file_scan' => 'required',
		]);

		$file = fopen($request->file('file_scan'), "r");

		$serial_numbers                 = [];
		$scan_summaries                 = [];
		$model_not_exist_in_pickinglist = [];

		$rs_models               = [];
		$rs_picking_list_details = [];
		$delivery_exceptions     = [];

		DB::statement('SET SESSION group_concat_max_len = 1000000');

		while (!feof($file)) {
			$row = fgetcsv($file);

			// Validasi Data Per Baris
			if (!empty($row[0]) && !empty($row[2])) {
				// kalau data ada isinya
				$serial_number = [
					'picking_id'    => $row[0],
					'ean_code'      => $row[1],
					'serial_number' => $row[2],
					'created_at'    => $row[3],
					'created_by'    => auth()->user()->id,
				];

				//CEK: Ada SN yang sama dalam satu file
				if (array_key_exists($serial_number['serial_number'], $serial_numbers)){
					return sendError("Duplicate SN `" . $serial_number['serial_number'] . "` in same file");
				}

				//CEK: Ada symbol di SN
				if (!empty(strpos($serial_number['serial_number'], '%'))) {
					return sendError("Serial number can't use symbol. Ean " .  $serial_number['ean_code'] . " Serial Number " . $serial_number['serial_number']);
				}

				//Ambil model name dari ean_code
				if (empty($rs_models[$serial_number['ean_code']])) {
					$model = MasterModel::where('ean_code', $serial_number['ean_code'])->first();
					if (empty($model)) {
						$result['status']  = false;
						$result['message'] = 'Model ' . $serial_number['ean_code'] . ' not found in master model !';
						return $result;
					}
					$rs_models[$serial_number['ean_code']] = $model;
				}

				if (empty($rs_picking_list_details[$serial_number['ean_code']])) {
					$picking_detail = PickinglistDetail::select(
						'wms_pickinglist_detail.id',
						// 'wms_pickinglist_detail.delivery_no',
						// 'wms_pickinglist_detail.invoice_no',
						// 'wms_pickinglist_detail.kode_customer',
						// 'wms_pickinglist_detail.code_sales',
						'wms_pickinglist_header.city_code',
						'wms_pickinglist_header.city_name',
						'wms_pickinglist_header.driver_register_id',
						'wms_pickinglist_header.kode_cabang',
						'wms_pickinglist_detail.ean_code',
						// 'wms_pickinglist_detail.quantity',
						// 'wms_pickinglist_detail.cbm',
						// DB::raw('GROUP_CONCAT(wms_pickinglist_detail.delivery_items SEPARATOR ",") as rs_delivery_items'),
						// DB::raw('GROUP_CONCAT(wms_pickinglist_detail.quantity SEPARATOR ",") as rs_quantity'),
						// DB::raw('(wms_pickinglist_detail.cbm / wms_pickinglist_detail.quantity) AS cbm_unit'),
						DB::raw('GROUP_CONCAT(DISTINCT CONCAT(wms_pickinglist_detail.invoice_no, ":", wms_pickinglist_detail.delivery_no, ":" , wms_pickinglist_detail.delivery_items, ":", wms_pickinglist_detail.quantity, ":", wms_pickinglist_detail.kode_customer, ":", wms_pickinglist_detail.code_sales, ":", (wms_pickinglist_detail.cbm / wms_pickinglist_detail.quantity)) ORDER BY wms_pickinglist_detail.invoice_no, wms_pickinglist_detail.delivery_no, wms_pickinglist_detail.delivery_items SEPARATOR ",") as rs_in_dn_di_qty_cc_cs_cbmu'),
						// DB::raw('0 AS quantity_lmb')
						DB::raw('COUNT(DISTINCT wms_lmb_detail.serial_number) AS quantity_lmb')
						// DB::raw('(SUM(wms_pickinglist_detail.quantity) - COUNT(wms_lmb_detail.serial_number)) AS quantity ')
					)
						->leftjoin('wms_pickinglist_header', 'wms_pickinglist_header.id', '=', 'wms_pickinglist_detail.header_id')
						->leftjoin('wms_lmb_detail', function ($join) {
							$join->on('wms_lmb_detail.picking_id', '=', 'wms_pickinglist_detail.header_id');
							// $join->on('wms_lmb_detail.delivery_no', '=', 'wms_pickinglist_detail.delivery_no');
							// $join->on('wms_lmb_detail.invoice_no', '=', 'wms_pickinglist_detail.invoice_no');
							$join->on('wms_lmb_detail.ean_code', '=', 'wms_pickinglist_detail.ean_code');
						})
						->groupBy(
							'wms_pickinglist_detail.header_id',
							// 'wms_pickinglist_detail.invoice_no',
							// 'wms_pickinglist_detail.delivery_no',
							// 'wms_pickinglist_detail.delivery_items',
							'wms_pickinglist_detail.ean_code'
						)
						->where(DB::raw('CAST(wms_pickinglist_detail.ean_code AS UNSIGNED)'), $serial_number['ean_code'])
						->where('wms_pickinglist_header.picking_no', $serial_number['picking_id'])
						->whereNull('wms_pickinglist_header.deleted_at')
						->orderBy('quantity', 'desc');

					$picking_detail = $picking_detail->first();

					// return $picking_detail;
					$rs_invoice_no     = [];
					$rs_delivery_no    = [];
					$rs_delivery_items = [];
					$rs_quantity       = [];
					$rs_kode_customer  = [];
					$rs_code_sales     = [];
					$rs_cbm_unit       = [];
					$quantity          = 0;

					if (empty($picking_detail->rs_in_dn_di_qty_cc_cs_cbmu)) {
						$model_not_exist_in_pickinglist[$serial_number['ean_code']]['picking_no'] = $serial_number['picking_id'];
						$model_not_exist_in_pickinglist[$serial_number['ean_code']]['model']      = $rs_models[$serial_number['ean_code']]->model_name;
						if (empty($model_not_exist_in_pickinglist[$serial_number['ean_code']]['total_sn'])) {
							$model_not_exist_in_pickinglist[$serial_number['ean_code']]['total_sn'] = 0;
						}
						$model_not_exist_in_pickinglist[$serial_number['ean_code']]['total_sn'] += 1;
						$model_not_exist_in_pickinglist[$serial_number['ean_code']]['keterangan'] = 'Model not exists in picking list';
						continue;
					}

					if (!empty($picking_detail->kode_cabang)) {
						$cek_double = LMBDetail::join('wms_lmb_header', 'wms_lmb_header.driver_register_id', 'wms_lmb_detail.driver_register_id')
							->where('wms_lmb_detail.serial_number', $serial_number['serial_number'])
							->while('wms_lmb_header.kode_cabang', $picking_detail->kode_cabang);
						if ($cek_double->count() > 0){
							return sendError('Duplicate SN `'. $serial_number['serial_number'] .'` in same Branch.');
						}
					}

					foreach (explode(',', $picking_detail->rs_in_dn_di_qty_cc_cs_cbmu) as $key => $value) {
						$tempDQ = explode(':', $value);
						if ($picking_detail->quantity_lmb <= $tempDQ[3]) {
							$tempDQ[3] -= $picking_detail->quantity_lmb;
							$picking_detail->quantity_lmb = 0;

							if ($tempDQ[3] > 0) {
								$rs_invoice_no[]     = $tempDQ[0];
								$rs_delivery_no[]    = $tempDQ[1];
								$rs_delivery_items[] = $tempDQ[2];
								$rs_quantity[]       = $tempDQ[3];
								$rs_kode_customer[]  = $tempDQ[4];
								$rs_code_sales[]     = $tempDQ[5];
								$rs_cbm_unit[]       = $tempDQ[6];
								$quantity += $tempDQ[3];
							}
						} else {
							$picking_detail->quantity_lmb -= $tempDQ[3];
						}
					}


					$picking_detail->quantity = $quantity - $picking_detail->quantity_lmb;

					if (empty($picking_detail)) {
						return sendError('EAN ' . $serial_number['ean_code'] . ' not found in picking_list !');
					}

					// Cek apa EAN CODE ada karakter enter nya
					if ($serial_number['ean_code'] != $picking_detail->ean_code) {
						PickinglistDetail::where('id', $picking_detail->id)
							->update(['ean_code' => $serial_number['ean_code']]);
						ManualConcept::where('ean_code', $picking_detail->ean_code)
							->update(['ean_code' => $serial_number['ean_code']]);
					}

					if (!empty($delivery_exceptions[$serial_number['ean_code']])) {
						$scan_summaries[$serial_number['ean_code']]['quantity_picking'] += $picking_detail->quantity;
						$scan_summaries[$serial_number['ean_code']]['quantity_existing'] += $picking_detail->quantity;
					}

					$picking_detail->rs_invoice_no     = $rs_invoice_no;
					$picking_detail->rs_delivery_no    = $rs_delivery_no;
					$picking_detail->rs_delivery_items = $rs_delivery_items;
					$picking_detail->rs_quantity       = $rs_quantity;
					$picking_detail->rs_kode_customer  = $rs_kode_customer;
					$picking_detail->rs_code_sales     = $rs_code_sales;
					$picking_detail->rs_cbm_unit       = $rs_cbm_unit;

					$rs_picking_list_details[$serial_number['ean_code']] = $picking_detail;
				}

				$serial_number['model'] = $rs_models[$serial_number['ean_code']]->model_name;
				// $serial_number['delivery_no']        = $rs_picking_list_details[$serial_number['ean_code']]->delivery_no;
				// $serial_number['invoice_no']         = $rs_picking_list_details[$serial_number['ean_code']]->invoice_no;
				// $serial_number['kode_customer']      = $rs_picking_list_details[$serial_number['ean_code']]->kode_customer;
				// $serial_number['code_sales']         = $rs_picking_list_details[$serial_number['ean_code']]->code_sales;
				$serial_number['city_code']          = $rs_picking_list_details[$serial_number['ean_code']]->city_code;
				$serial_number['city_name']          = $rs_picking_list_details[$serial_number['ean_code']]->city_name;
				$serial_number['driver_register_id'] = $rs_picking_list_details[$serial_number['ean_code']]->driver_register_id;
				$serial_number['created_by']         = auth()->user()->id;

				// $serial_number['cbm_unit'] = $rs_picking_list_details[$serial_number['ean_code']]->cbm / $rs_picking_list_details[$serial_number['ean_code']]->quantity;
				// $serial_number['cbm_unit'] = $rs_picking_list_details[$serial_number['ean_code']]->cbm_unit;

				if (empty($scan_summaries[$serial_number['ean_code']])) {
					$scan_summaries[$serial_number['ean_code']] = [
						'model'             => $rs_models[$serial_number['ean_code']]->model_name,
						'quantity_scan'     => 0,
						'quantity_picking'  => $rs_picking_list_details[$serial_number['ean_code']]->quantity,
						'quantity_existing' => $rs_picking_list_details[$serial_number['ean_code']]->quantity,
					];
				}

				// return $scan_summaries;

				if (
					$scan_summaries[$serial_number['ean_code']]['quantity_picking'] >= $scan_summaries[$serial_number['ean_code']]['quantity_scan']
					&& !empty($rs_picking_list_details[$serial_number['ean_code']]->rs_delivery_items[0])
				) {
					$serial_number['delivery_items'] = $rs_picking_list_details[$serial_number['ean_code']]->rs_delivery_items[0];
					$serial_number['delivery_no']    = $rs_picking_list_details[$serial_number['ean_code']]->rs_delivery_no[0];
					$serial_number['invoice_no']     = $rs_picking_list_details[$serial_number['ean_code']]->rs_invoice_no[0];
					$serial_number['kode_customer']  = $rs_picking_list_details[$serial_number['ean_code']]->rs_kode_customer[0];
					$serial_number['code_sales']     = $rs_picking_list_details[$serial_number['ean_code']]->rs_code_sales[0];
					$serial_number['cbm_unit']       = $rs_picking_list_details[$serial_number['ean_code']]->rs_cbm_unit[0];

					$scan_summaries[$serial_number['ean_code']]['quantity_scan'] += 1;
					$scan_summaries[$serial_number['ean_code']]['quantity_existing'] -= 1;

					$quantity = $rs_picking_list_details[$serial_number['ean_code']]->rs_quantity;
					$quantity[0] -= 1;
					$rs_picking_list_details[$serial_number['ean_code']]->rs_quantity = $quantity;

					if ($rs_picking_list_details[$serial_number['ean_code']]->rs_quantity[0] <= 0) {
						$rs_quantity = $rs_picking_list_details[$serial_number['ean_code']]->rs_quantity;
						unset($rs_quantity[0]);
						$rs_picking_list_details[$serial_number['ean_code']]->rs_quantity = array_values($rs_quantity);

						$rs_delivery_items = $rs_picking_list_details[$serial_number['ean_code']]->rs_delivery_items;
						unset($rs_delivery_items[0]);
						$rs_picking_list_details[$serial_number['ean_code']]->rs_delivery_items = array_values($rs_delivery_items);

						$rs_delivery_no = $rs_picking_list_details[$serial_number['ean_code']]->rs_delivery_no;
						unset($rs_delivery_no[0]);
						$rs_picking_list_details[$serial_number['ean_code']]->rs_delivery_no = array_values($rs_delivery_no);

						$rs_invoice_no = $rs_picking_list_details[$serial_number['ean_code']]->rs_invoice_no;
						unset($rs_invoice_no[0]);
						$rs_picking_list_details[$serial_number['ean_code']]->rs_invoice_no = array_values($rs_invoice_no);

						$rs_kode_customer = $rs_picking_list_details[$serial_number['ean_code']]->rs_kode_customer;
						unset($rs_kode_customer[0]);
						$rs_picking_list_details[$serial_number['ean_code']]->rs_kode_customer = array_values($rs_kode_customer);

						$rs_code_sales = $rs_picking_list_details[$serial_number['ean_code']]->rs_code_sales;
						unset($rs_code_sales[0]);
						$rs_picking_list_details[$serial_number['ean_code']]->rs_code_sales = array_values($rs_code_sales);

						$rs_cbm_unit = $rs_picking_list_details[$serial_number['ean_code']]->rs_cbm_unit;
						unset($rs_cbm_unit[0]);
						$rs_picking_list_details[$serial_number['ean_code']]->rs_cbm_unit = array_values($rs_cbm_unit);
					}
				} else {
					$model_not_exist_in_pickinglist[$serial_number['ean_code']]['picking_no'] = $serial_number['picking_id'];
					$model_not_exist_in_pickinglist[$serial_number['ean_code']]['model']      = $rs_models[$serial_number['ean_code']]->model_name;
					if (empty($model_not_exist_in_pickinglist[$serial_number['ean_code']]['total_sn'])) {
						$model_not_exist_in_pickinglist[$serial_number['ean_code']]['total_sn'] = 0;
					}
					$model_not_exist_in_pickinglist[$serial_number['ean_code']]['total_sn'] += 1;
					$model_not_exist_in_pickinglist[$serial_number['ean_code']]['keterangan'] = 'Quantity Picking : ' . $scan_summaries[$serial_number['ean_code']]['quantity_picking'];
				}

				$serial_numbers[$serial_number['serial_number']] = $serial_number;
			}
			// Akhir validasi data per baris
		}

		$result['serial_numbers']                 = $serial_numbers;
		$result['scan_summaries']                 = $scan_summaries;
		$result['model_not_exist_in_pickinglist'] = $model_not_exist_in_pickinglist;

		return $result;
	}

	public function selectDeliveryNo(Request $request)
	{
		$query = PickinglistDetail::select(
			DB::raw('wms_pickinglist_detail.delivery_no AS id'),
			DB::raw('wms_pickinglist_detail.delivery_no AS text'),
			'wms_pickinglist_detail.delivery_items',
			'wms_pickinglist_detail.invoice_no',
			'wms_pickinglist_detail.kode_customer',
			'wms_pickinglist_detail.code_sales',
			DB::raw('(wms_pickinglist_detail.quantity - COUNT(wms_lmb_detail.serial_number)) AS free_qty')
		)
			->leftjoin('wms_lmb_detail', function ($join) {
				$join->on('wms_lmb_detail.picking_id', '=', 'wms_pickinglist_detail.header_id');
				$join->on('wms_lmb_detail.delivery_no', '=', 'wms_pickinglist_detail.delivery_no');
				$join->on('wms_lmb_detail.invoice_no', '=', 'wms_pickinglist_detail.invoice_no');
				$join->on('wms_lmb_detail.ean_code', '=', 'wms_pickinglist_detail.ean_code');
				$join->on('wms_lmb_detail.delivery_items', '=', 'wms_pickinglist_detail.delivery_items');
			})
			->groupBy(
				'wms_pickinglist_detail.header_id',
				'wms_pickinglist_detail.invoice_no',
				'wms_pickinglist_detail.delivery_no',
				'wms_pickinglist_detail.delivery_items',
				'wms_pickinglist_detail.ean_code'
			)
			->where('wms_pickinglist_detail.header_id', $request->input('picking_id'))
			->where('wms_pickinglist_detail.ean_code', $request->input('ean_code'))
			->havingRaw('(free_qty > 0 OR wms_pickinglist_detail.delivery_no = ?)', [$request->input('delivery_no')])
			// ->whereRaw('(wms_pickinglist_detail.quantity - COUNT(wms_lmb_detail.serial_number)) > 0')
			->toBase();

		return get_select2_data($request, $query);
	}

	public function storeScan(Request $request)
	{
		$data_serial_numbers = json_decode($request->input('data_serial_numbers'), true);

		foreach ($data_serial_numbers as $key => $value) {
			$data_serial_numbers[$key] = $value;
		}

		try {
			DB::beginTransaction();
			LMBDetail::insert($data_serial_numbers);
			DB::commit();
			return sendSuccess('Data submited.', '1');
		} catch (\Exception $exception) {
			DB::rollBack();
			return sendError('Duplicate Serial Number Entry', $exception);
		}
	}

	public function destroy($id)
	{
		return LMBHeader::destroy($id);
	}

	public function destroyLmbDetail(Request $request)
	{
		return LMBDetail::where('ean_code', $request->input('ean_code'))
			->where('serial_number', $request->input('serial_number'))
			->where('picking_id', $request->input('picking_id'))
			->delete();
	}

	public function destroySelectedLmbDetail(Request $request)
	{
		$data_serial_number = json_decode($request->input('data_serial_number'), true);

		foreach ($data_serial_number as $key => $value) {
			LMBDetail::where('ean_code', $value['ean_code'])
				->where('serial_number', $value['serial_number'])
				->where('picking_id', $value['picking_id'])
				->delete();
		}

		return true;
	}

	public function pickingListIndex(Request $request)
	{
		$query = PickinglistHeader::noLMBPickingList()->get();

		$datatables = DataTables::of($query)
			->addIndexColumn() //DT_RowIndex (Penomoran)
			->editColumn('destination_name', function ($data) {
				return $data->getDestinationName($data);
			})
			->editColumn('created_at', function ($data) {
				return date('Y-m-d H:i:s', strtotime($data->created_at));
			})
			// ->addColumn('do_status', function ($data) {
			//   return $data->details()->count() > 0 ? 'DO Already' : '<span class="red-text">DO not yet assign</span>';
			// })
			// ->addColumn('lmb', function ($data) {
			//   return '-';
			// })
			->addColumn('action', function ($data) {
				$action = '';
				$action .= ' ' . get_button_edit(url('picking-to-lmb/picking-list/' . $data->id), 'Create');
				return $action;
			})
			->rawColumns(['do_status', 'action']);

		return $datatables->make(true);
	}

	public function pickingListCreate(Request $request, $id)
	{
		$data['picking'] = PickinglistHeader::findOrFail($id);

		if ($request->ajax()) {
			$query = LMBDetail::where('picking_id', $id)
				->get();

			$datatables = DataTables::of($query)
				->addIndexColumn() //DT_RowIndex (Penomoran)
				->addColumn('action', function ($data) {
					$action = '';
					$action .= ' ' . get_button_delete();
					return $action;
				});

			return $datatables->make(true);
		}

		return view('web.picking.picking-to-lmb.create', $data);
	}

	public function export(Request $request, $id)
	{
		$data['lmbHeader']  = LMBHeader::findOrFail($id);
		$data['picking_no'] = (new LMBHeader)->getPickingNo($data['lmbHeader']);
		$rs_details         = [];

		foreach ($data['lmbHeader']->details()->orderBy('model')->get() as $key => $value) {
			if (empty($rs_details[$value->model])) {
				$rs_details[$value->model]['qty'] = 1;
			} else {
				$rs_details[$value->model]['qty'] += 1;
			}

			$rs_details[$value->model]['serial_numbers'][] = $value->serial_number;
		}

		$data['rs_details'] = $rs_details;

		// echo "<pre>";
		// print_r($rs_details);
		// exit;
		$view_print = view('web.picking.picking-to-lmb._print', $data);

		$title = 'Picking List LMB';

		if ($request->input('filetype') == 'html') {
			if (auth()->user()->cabang->hq) {

				$mpdf = new \Mpdf\Mpdf([
					'tempDir' => '/tmp',
					'margin_left'                     => 25,
					'margin_right'                    => 0,
					'margin_top'                      => 88,
					'margin_bottom'                   => 80,
					'format'                          => [241.3, 279.4],
				]);
				$view_print = view('web.picking.picking-to-lmb._print_hq', $data);
				$mpdf->WriteHTML($view_print);
				$mpdf->Output();
				return;
			}
			$mpdf = new \Mpdf\Mpdf([
				'tempDir' => '/tmp',
				'margin_left'                     => 7,
				'margin_right'                    => 12,
				'margin_top'                      => 65,
				'margin_bottom'                   => 40,
				'format'                          => 'Letter',
			]);
			$mpdf->WriteHTML($view_print);
			$mpdf->Output();

			return;
		} elseif ($request->input('filetype') == 'xls') {
			$view_print = view('web.picking.picking-to-lmb._excel', $data);
			// echo $view_print;
			// return;
			if (auth()->user()->cabang->hq) {

				// $view_print = view('web.picking.picking-to-lmb._excel_hq', $data);
			}
			// Request FILE EXCEL
			$reader      = new \PhpOffice\PhpSpreadsheet\Reader\Html();
			$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

			$spreadsheet = $reader->loadFromString($view_print, $spreadsheet);
			$spreadsheet->getActiveSheet()->getPageMargins()->setTop(0.2);
			$spreadsheet->getActiveSheet()->getPageMargins()->setRight(0.2);
			$spreadsheet->getActiveSheet()->getPageMargins()->setLeft(0.2);
			$spreadsheet->getActiveSheet()->getPageMargins()->setBottom(0.2);
			$spreadsheet->getActiveSheet()->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_LETTER);

			// Set warna background putih
			$spreadsheet->getDefaultStyle()->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('ffffff');
			// Set Font
			$spreadsheet->getDefaultStyle()->getFont()->setName('courier New');

			// Atur lebar kolom
			$spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
			$spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(12);
			$spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
			$spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(20);
			$spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(4);
			$spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(4);
			$spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(4);
			$spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(4);
			$spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(4);
			$spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(4);
			$spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(4);
			$spreadsheet->getActiveSheet()->getColumnDimension('L')->setWidth(4);
			$spreadsheet->getActiveSheet()->getColumnDimension('M')->setWidth(8);
			$spreadsheet->getActiveSheet()->getColumnDimension('N')->setWidth(4);
			$spreadsheet->getActiveSheet()->getColumnDimension('O')->setWidth(4);

			$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment; filename="' . $title . '.xls"');

			$writer->save("php://output");
		} else if ($request->input('filetype') == 'pdf') {
			if (auth()->user()->cabang->hq) {

				$mpdf = new \Mpdf\Mpdf([
					'tempDir' => '/tmp',
					'margin_left'                     => 0,
					'margin_right'                    => 25,
					'margin_top'                      => 88,
					'margin_bottom'                   => 80,
					'format'                          => [216, 275],
				]);
				$view_print = view('web.picking.picking-to-lmb._print_hq', $data);
			} else {
				$mpdf = new \Mpdf\Mpdf([
					'tempDir' => '/tmp',
					'margin_left'                     => 7,
					'margin_right'                    => 12,
					'margin_top'                      => 65,
					'margin_bottom'                   => 40,
					'format'                          => 'Letter',
				]);
			}
			// REQUEST PDF

			// echo $view_print;
			$mpdf->WriteHTML($view_print);
			$mpdf->Output($title . '.pdf', "D");
			// $mpdf->Output();

		} else {
			// Parameter filetype tidak valid / tidak ditemukan return 404
			return redirect(404);
		}
	}
}
