<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\MovementTransactionLog;
use DataTables;
use DB;
use Illuminate\Http\Request;

class ReportInventoryMovementController extends Controller
{
  public function index(Request $request)
  {
    if ($request->ajax()) {
      $query = MovementTransactionLog::select(
        'wms_movement_transaction_log.*',
        'log_cabang.kode_customer',
        'log_cabang.long_description',
        'log_manifest_detail.ship_to_code',
        'users.username',
        'wms_master_movement_type.action',
        DB::raw('CASE WHEN wms_master_movement_type.action = "INCREASE" THEN wms_movement_transaction_log.storage_location_to ELSE wms_movement_transaction_log.storage_location_from END AS storage_location')
      )
        ->leftjoin('wms_master_movement_type', 'wms_master_movement_type.id', '=', 'wms_movement_transaction_log.mvt_master_id')
        ->leftjoin('log_manifest_detail', function ($join) {
          $join->on('log_manifest_detail.do_manifest_no', '=', 'wms_movement_transaction_log.do_manifest_no');
          $join->on('log_manifest_detail.model', '=', 'wms_movement_transaction_log.model');
        })
        ->leftjoin('log_cabang', 'log_cabang.kode_cabang', '=', 'wms_movement_transaction_log.kode_cabang')
        ->leftjoin('users', 'users.id', '=', 'wms_movement_transaction_log.created_by')
      ;

      $query->where('wms_movement_transaction_log.kode_cabang', $request->input('kode_cabang'));
      $query->where('wms_movement_transaction_log.created_at', '>=', date('Y-m-d', strtotime($request->input('start_date'))));
      $query->where('wms_movement_transaction_log.created_at', '<=', date('Y-m-d', strtotime($request->input('end_date'))));

      if (!empty($request->input('model'))) {
        $query->where('model', $request->input('model'));
      }

      $datatables = DataTables::of($query)
        ->addIndexColumn() //DT_RowIndex (Penomoran)
        ->editColumn('created_at', function ($data) {
          return date('d/m/Y', strtotime($data->created_at));
        })
        ->editColumn('quantity', function ($data) {
          return $data->action == 'INCREASE' ? $data->quantity : ($data->quantity * (-1));
        })
        ->addColumn('debit_credit', function ($data) {
          return $data->action == 'INCREASE' ? 'S' : 'H';
        })
      ;

      return $datatables->make(true);
    }

    return view('web.report.report-inventory-movement.index');
  }
}
