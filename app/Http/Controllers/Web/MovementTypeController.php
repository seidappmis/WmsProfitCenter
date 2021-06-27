<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
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
			$query = MovementTransactionType::leftJoin('wms_movement_transaction_log as lg', 'lg.movement_code', 'wms_master_movement_type.movement_code')
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
			$datatables = DataTables::of($query)
				->addIndexColumn()
				->addColumn('action', function($data){
					return ' ' . get_button_view(url('log-check/' . $data->id));
				});
			return $datatables->make(true);
		}
		return view('web.master.movement-type.index');
	}
}