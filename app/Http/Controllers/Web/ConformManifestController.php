<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\InventoryStorage;
use App\Models\LogManifestDetail;
use App\Models\LogManifestHeader;
use App\Models\MasterModel;
use App\Models\MovementTransactionLog;
use App\Models\MovementTransactionType;
use App\Models\StorageMaster;
use App\Models\WMSBranchManifestDetail;
use App\Models\WMSBranchManifestHeader;
use DataTables;
use DB;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class ConformManifestController extends Controller
{
  public function index()
  {
    return view('web.incoming.conform-manifest.index');
  }

  public function listManifestHQ(Request $request)
  {
    if ($request->ajax()) {
      $query = LogManifestHeader::select(
        'log_manifest_header.*'
      )->leftjoin('log_manifest_detail', 'log_manifest_detail.do_manifest_no', '=', 'log_manifest_header.do_manifest_no')
        ->whereIn('log_manifest_detail.kode_cabang', auth()->user()->getStringGrantCabang())
        ->groupBy('log_manifest_header.do_manifest_no')
        ->where('log_manifest_header.status_complete', 1)
        ->where('log_manifest_detail.status_confirm', 0)
      ;

      $datatables = DataTables::of($query)
        ->addIndexColumn() //DT_RowIndex (Penomoran)
        ->addColumn('picking_no', function ($data) {
          return $data->picking->picking_no;
        })
        ->addColumn('status', function ($data) {
          return $data->status();
        })
        ->addColumn('action', function ($data) {
          $action = '';
          $action .= ' ' . get_button_view(url('conform-manifest/' . $data->do_manifest_no) . '/hq', 'View for Conform');
          return $action;
        })
        ->rawColumns(['status', 'action']);

      return $datatables->make(true);
    }
  }

  public function listManifestBranch(Request $request)
  {
    if ($request->ajax()) {
      $query = WMSBranchManifestHeader::select('wms_branch_manifest_header.*')
        ->leftjoin('wms_branch_manifest_detail', function ($join) {
          $join->on('wms_branch_manifest_detail.do_manifest_no', '=', 'wms_branch_manifest_header.do_manifest_no')->where('wms_branch_manifest_detail.status_confirm', 0);
        })
        ->whereNotNull('wms_branch_manifest_detail.do_manifest_no')
        ->whereIn('wms_branch_manifest_header.kode_cabang', auth()->user()->getStringGrantCabang())
        ->where('wms_branch_manifest_header.status_complete', 1)
        ->groupBy('wms_branch_manifest_detail.do_manifest_no')
      ;

      $datatables = DataTables::of($query)
        ->addIndexColumn() //DT_RowIndex (Penomoran)
        ->addColumn('picking_no', function ($data) {
          return $data->picking->picking_no;
        })
        ->addColumn('status', function ($data) {
          return $data->status();
        })
        ->addColumn('action', function ($data) {
          $action = '';
          $action .= ' ' . get_button_view(url('conform-manifest/' . $data->do_manifest_no) . '/branch', 'View for Conform');
          return $action;
        })
        ->rawColumns(['status', 'action']);

      return $datatables->make(true);
    }
  }

  public function viewForConformHQ($id)
  {
    $data['manifestHeader'] = LogManifestHeader::findOrFail($id);
    $data['type']           = 'HQ';
    return view('web.incoming.conform-manifest.view', $data);
  }

  public function viewForConformBranch($id)
  {
    $data['manifestHeader'] = WMSBranchManifestHeader::findOrFail($id);
    $data['type']           = 'Branch';
    return view('web.incoming.conform-manifest.view', $data);
  }

  public function conform(Request $request, $id)
  {
    if ($request->input('type_conform') == 'HQ') {
      $manifestHeader = LogManifestHeader::where('do_manifest_no', $request->input('do_manifest_no'))->first();
    } else {
      $manifestHeader = WMSBranchManifestHeader::findOrFail($id);
    }
    if (empty($request->input('manifest_detail'))) {
      return sendError('Please, Selected item');
    }
    try {
      DB::beginTransaction();

      if ($request->input('status') == 'hold_transit') {
        foreach ($request->input('manifest_detail') as $key => $value) {
          if ($request->input('type_conform') == 'HQ') {
            $manifesDetail = LogManifestDetail::findOrFail($key);
          } else {
            $manifesDetail = WMSBranchManifestDetail::findOrFail($key);
          }
          $manifesDetail->actual_time_arrival = date('Y-m-d H:i:s', strtotime($request->input('hold_transit')));
          $manifesDetail->save();
        }
      } else {

        if (empty($request->input('arrival_date'))) {
          return sendError('Arival Date Required');
        }

        if (empty($request->input('unloading_date'))) {
          return sendError('Unloading Date Required');
        }

        $date_now = date('Y-m-d H:i:s');

        $firstClassTMP = StorageMaster::where('sto_type_id', 1)->get();
        foreach ($firstClassTMP as $key => $value) {
          $firstClass[$value->kode_cabang] = $value;
        }

        $intransitBR = StorageMaster::where('sto_type_id', 3)->get();
        foreach ($intransitBR as $key => $value) {
          $storageIntransit['BR'][$value->kode_cabang] = $value;
        }

        $intranstDS = StorageMaster::where('sto_type_id', 4)->get();
        foreach ($intranstDS as $key => $value) {
          $storageIntransit['DS'][$value->kode_cabang] = $value;
        }

        $movementIncreaseSLOC      = MovementTransactionType::where('movement_code', '9X5')->where('action', 'INCREASE')->first();
        $movementDecreaseIntransit = MovementTransactionType::where('movement_code', '9X5')->where('action', 'DECREASE')->first();

        $rs_model                    = [];
        $rs_movement_transaction_log = [];

        foreach ($request->input('manifest_detail') as $key => $value) {
          if ($request->input('type_conform') == 'HQ') {
            $manifesDetail = LogManifestDetail::findOrFail($key);
          } else {
            $manifesDetail = WMSBranchManifestDetail::findOrFail($key);
          }

          // Skip bila sudah diconfirm user.
          if ($manifesDetail->status_confirm == 1) {
            continue;
          }

          $manifesDetail->status_confirm      = 1;
          $manifesDetail->confirm_date        = date('Y-m-d H:i:s');
          $manifesDetail->actual_time_arrival = date('Y-m-d H:i:s', strtotime($request->input('arrival_date')));
          // if (auth()->user()->cabang->hq) {
          if ($request->input('type_conform') == 'HQ') {
            $manifesDetail->actual_loading_date = date('Y-m-d H:i:s', strtotime($request->input('unloading_date')));
          } else {
            $manifesDetail->actual_unloading_date = date('Y-m-d H:i:s', strtotime($request->input('unloading_date')));
          }
          $manifesDetail->confirm_by = auth()->user()->username;
          $manifesDetail->do_reject  = !empty($request->input('rejected')) ? 1 : 0;
          $manifesDetail->save();

          if (empty($rs_model[$manifesDetail->model])) {
            $model                           = MasterModel::where('model_name', $manifesDetail->model)->first();
            $rs_model[$manifesDetail->model] = $model;
          }

          // yang bukan return
          if ($manifestDetail->do_return != 1) {
            // Jika CODE SALES BRANCH Stock Branch Bertambah
            if ($manifesDetail->code_sales == 'BR') {
              InventoryStorage::updateOrCreate(
                // Condition
                [
                  'storage_id' => $firstClass[$manifesDetail->kode_cabang]->id,
                  'model_name' => $manifesDetail->model,
                ],
                // Data Update
                [
                  'ean_code'       => (!empty($rs_model[$manifesDetail->model]) ? $rs_model[$manifesDetail->model]->ean_code : ''),
                  'quantity_total' => DB::raw('IF(ISNULL(quantity_total), 0, quantity_total) + ' . $manifesDetail->quantity),
                  'cbm_total'      => DB::raw('IF(ISNULL(cbm_total), 0, cbm_total) + ' . $manifesDetail->cbm),
                  'last_updated'   => $date_now,
                ]
              );

              // ADD MOVEMENT
              // Movement Code
              // id 9 Code 9X5 Increase Menambah Sloc Intransit HQ
              $movement_transaction_log['log_id']                = Uuid::uuid4()->toString();
              $movement_transaction_log['do_manifest_no']        = $manifesDetail->do_manifest_no;
              $movement_transaction_log['mvt_master_id']         = $movementIncreaseSLOC->id;
              $movement_transaction_log['inventory_movement']    = 'Stock ' . $movementIncreaseSLOC->action;
              $movement_transaction_log['movement_code']         = $movementIncreaseSLOC->movement_code;
              $movement_transaction_log['transactions_desc']     = $movementIncreaseSLOC->action_description;
              $movement_transaction_log['storage_location_from'] = $storageIntransit[$manifesDetail->code_sales][$manifesDetail->kode_cabang]->sto_loc_code_long;
              $movement_transaction_log['storage_location_to']   = $firstClass[$manifesDetail->kode_cabang]->sto_loc_code_long;
              $movement_transaction_log['storage_location_code'] = $movement_transaction_log['storage_location_from'] . ' & ' . $movement_transaction_log['storage_location_to'];
              $movement_transaction_log['eancode']               = (!empty($rs_model[$manifesDetail->model]) ? $rs_model[$manifesDetail->model]->ean_code : '');
              $movement_transaction_log['model']                 = $manifesDetail->model;
              $movement_transaction_log['quantity']              = $manifesDetail->quantity;
              $movement_transaction_log['created_at']            = $date_now;
              $movement_transaction_log['flow_id']               = '';
              $movement_transaction_log['kode_cabang']           = $manifesDetail->kode_cabang;
              $movement_transaction_log['created_by']            = auth()->user()->id;

              $rs_movement_transaction_log[] = $movement_transaction_log;

            } // END OF CODE SALES BRANCH

            InventoryStorage::updateOrCreate(
              // Condition
              [
                'storage_id' => $storageIntransit[$manifesDetail->code_sales][$manifesDetail->kode_cabang]->id,
                'model_name' => $manifesDetail->model,
              ],
              // Data Update
              [
                'ean_code'       => (!empty($rs_model[$manifesDetail->model]) ? $rs_model[$manifesDetail->model]->ean_code : ''),
                'quantity_total' => DB::raw('IF(ISNULL(quantity_total), 0, quantity_total) - ' . $manifesDetail->quantity),
                'cbm_total'      => DB::raw('IF(ISNULL(cbm_total), 0, cbm_total) - ' . $manifesDetail->cbm),
                'last_updated'   => $date_now,
              ]
            );

            $movement_transaction_log['log_id']                = Uuid::uuid4()->toString();
            $movement_transaction_log['do_manifest_no']        = $manifesDetail->do_manifest_no;
            $movement_transaction_log['mvt_master_id']         = $movementDecreaseIntransit->id;
            $movement_transaction_log['inventory_movement']    = 'Stock ' . $movementDecreaseIntransit->action;
            $movement_transaction_log['movement_code']         = $movementDecreaseIntransit->movement_code;
            $movement_transaction_log['transactions_desc']     = $movementDecreaseIntransit->action_description;
            $movement_transaction_log['storage_location_from'] = $storageIntransit[$manifesDetail->code_sales][$manifesDetail->kode_cabang]->sto_loc_code_long;
            $movement_transaction_log['storage_location_to']   = $firstClass[$manifesDetail->kode_cabang]->sto_loc_code_long;
            $movement_transaction_log['storage_location_code'] = $movement_transaction_log['storage_location_from'] . ' & ' . $movement_transaction_log['storage_location_to'];
            $movement_transaction_log['eancode']               = (!empty($rs_model[$manifesDetail->model]) ? $rs_model[$manifesDetail->model]->ean_code : '');
            $movement_transaction_log['model']                 = $manifesDetail->model;
            $movement_transaction_log['quantity']              = $manifesDetail->quantity;
            $movement_transaction_log['created_at']            = $date_now;
            $movement_transaction_log['flow_id']               = '';
            $movement_transaction_log['kode_cabang']           = $manifesDetail->kode_cabang;
            $movement_transaction_log['created_by']            = auth()->user()->id;

            $rs_movement_transaction_log[] = $movement_transaction_log;
          }

        }

        if (!empty($rs_movement_transaction_log)) {
          MovementTransactionLog::insert($rs_movement_transaction_log);
        }
      }

      DB::commit();
      return sendSuccess('Success', $manifestHeader);

    } catch (Exception $e) {
      DB::rollBack();
    }
  }

}
