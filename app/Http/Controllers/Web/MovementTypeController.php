<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\MovementTransactionLog;
use Illuminate\Http\Request;
use App\Models\MovementTransactionType;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class MovementTypeController extends Controller
{
	public function getSelect2(Request $request)
	{
		$query = MovementTransactionType::select(
			DB::raw('movement_code AS id'),
			DB::raw("CONCAT('[', movement_code, '] - ', transactions) AS text")
		)->toBase()
			->groupBy('movement_code');

		$query->orderBy('text');

		return get_select2_data($request, $query);
	}

	public function index(Request $request){
		if($request->ajax()){
			$query1 = MovementTransactionType::leftJoin('wms_movement_transaction_log as lg', function($join){
				$join->on('lg.movement_code', '=','wms_master_movement_type.movement_code');
				$join->on(DB::raw("REPLACE(lg.inventory_movement, 'Stock ', '')"), 'wms_master_movement_type.action');
			})
			->groupBy([
				'id',
				'transactions',
				'jenis',
				'action_description',
				'from_desc',
				'to_desc',
				'modul_name'
			])
			->select([
				'wms_master_movement_type.id',
				'wms_master_movement_type.transactions',
				'wms_master_movement_type.action as jenis',
				'wms_master_movement_type.action_description',
				'wms_master_movement_type.from_desc',
				'wms_master_movement_type.to_desc',
				'wms_master_movement_type.modul_name',
				DB::raw('COUNT(lg.log_id) as log_count')
			]);
		
			$query2 = MovementTransactionLog::select([
				'inventory_movement',
				'movement_code',
				'transactions_desc',
				DB::raw('COUNT(log_id) as jumlah')
			])->groupBy([
				'inventory_movement',
				'movement_code',
				'transactions_desc'
			])->orderBy('movement_code');

			$datatables = DataTables::of($query2)
				->addIndexColumn()
				->addColumn('action', function($data){
					//return ' ' . get_button_view(url('log-check/' . $data->id));
					return '';
				});
			return $datatables->make(true);
		}
		return view('web.master.movement-type.index');
	}

	public function edit($id){
		switch ($id) {
			case 3:
				$code = '101';
				$table = 'log_incoming_manual_header';
				$key = 'arrival_no';
				break;
			case 4:
				//cancel 3
				$code = '102';
				break;
			case 5:
				$code = '101';

			default:
				# code...
				break;
		}
	}
}