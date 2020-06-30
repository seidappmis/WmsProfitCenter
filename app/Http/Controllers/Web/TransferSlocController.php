<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\InventoryStorage;
use App\Models\MovementTransactionLog;
use App\Models\StorageMaster;
use DB;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class TransferSlocController extends Controller
{
  public function index(Request $request)
  {
    return view('web.inventory.transfer-sloc.index');
  }

  /**
   * Transer Storage Location
   * Kurangi Stock di storage location asal
   * Add Log Movement type 312
   * Tambah Stock Di storage location tujuan
   * Add Log Movement type 311
   *
   * @param  Request $request [description]
   * @return [type]           [description]
   */
  public function store(Request $request)
  {
    return DB::transaction(function () use ($request) {
      $rs_movement_transaction_log = [];
      $quantity                    = $request->input('qty');
      $total_cbm                   = $quantity * $request->input('cbm');
      $date_now                    = date('Y-m-d H:i:s');

      $storage_from = StorageMaster::find($request->input('sloc_from'));
      $storage_to   = StorageMaster::find($request->input('sloc_to'));
      // Update Or Create Inventory Stroage data
      InventoryStorage::updateOrCreate(
        // Condition
        [
          'storage_id' => $request->input('sloc_from'),
          'model_name' => $request->input('model_name'),
        ],
        // Data Update
        [
          'ean_code'       => $request->input('ean_code'),
          'quantity_total' => DB::raw('IF(ISNULL(quantity_total), 0, quantity_total) - ' . $quantity),
          'cbm_total'      => DB::raw('IF(ISNULL(cbm_total), 0, cbm_total) - ' . $total_cbm),
          'last_updated'   => $date_now,
        ]
      );

      // Add Movement Transaction Log
      $movement_transaction_log['log_id']                = Uuid::uuid4()->toString();
      $movement_transaction_log['mvt_master_id']         = 27;
      $movement_transaction_log['inventory_movement']    = 'Stock DECREASE';
      $movement_transaction_log['movement_code']         = 312;
      $movement_transaction_log['transactions_desc']     = 'TRANSFER IN BRANCH';
      $movement_transaction_log['storage_location_from'] = $storage_from->sto_loc_code_long;
      $movement_transaction_log['storage_location_to']   = $storage_to->sto_loc_code_long;
      $movement_transaction_log['storage_location_code'] = '& ' . $movement_transaction_log['storage_location_to'];
      $movement_transaction_log['eancode']               = $request->input('ean_code');
      $movement_transaction_log['model']                 = $request->input('model_name');
      $movement_transaction_log['quantity']              = $quantity;
      $movement_transaction_log['created_at']            = $date_now;
      $movement_transaction_log['flow_id']               = '';

      $rs_movement_transaction_log[] = $movement_transaction_log;

      InventoryStorage::updateOrCreate(
        // Condition
        [
          'storage_id' => $request->input('sloc_to'),
          'model_name' => $request->input('model_name'),
        ],
        // Data Update
        [
          'ean_code'       => $request->input('ean_code'),
          'quantity_total' => DB::raw('IF(ISNULL(quantity_total), 0, quantity_total) + ' . $quantity),
          'cbm_total'      => DB::raw('IF(ISNULL(cbm_total), 0, cbm_total) + ' . $total_cbm),
          'last_updated'   => $date_now,
        ]
      );

      // Add Movement Transaction Log
      $movement_transaction_log['log_id']                = Uuid::uuid4()->toString();
      $movement_transaction_log['mvt_master_id']         = 26;
      $movement_transaction_log['inventory_movement']    = 'Stock INCREASE';
      $movement_transaction_log['movement_code']         = 311;
      $movement_transaction_log['transactions_desc']     = 'TRANSFER IN BRANCH';
      $movement_transaction_log['storage_location_from'] = $storage_from->sto_loc_code_long;
      $movement_transaction_log['storage_location_to']   = $storage_to->sto_loc_code_long;
      $movement_transaction_log['storage_location_code'] = '& ' . $movement_transaction_log['storage_location_to'];
      $movement_transaction_log['eancode']               = $request->input('ean_code');
      $movement_transaction_log['model']                 = $request->input('model_name');
      $movement_transaction_log['quantity']              = $quantity;
      $movement_transaction_log['created_at']            = $date_now;
      $movement_transaction_log['flow_id']               = '';

      $rs_movement_transaction_log[] = $movement_transaction_log;

      MovementTransactionLog::insert($rs_movement_transaction_log);

      return true;
    });
  }

  public function getSelect2StorageLocation(Request $request)
  {
    $query = StorageMaster::select(
      'id',
      DB::raw("CONCAT('[', sto_loc_code_long , '] ', sto_type_desc) AS text")
    );

    $query->where('kode_cabang', auth()->user()->cabang->kode_cabang);
    $query->where('sto_type_id', $request->input('sloc_type'));

    if (!empty($request->input('sloc_from'))) {
      $query->where('id', '!=', $request->input('sloc_from'));
    }

    return get_select2_data($request, $query);
  }
}
