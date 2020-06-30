<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\InventoryStorage;
use App\Models\MasterModel;
use App\Models\StorageMaster;
use Illuminate\Http\Request;

class UploadInventoryStorageController extends Controller
{
  public function index()
  {
    return view('web.inventory.upload-inventory-storage.index');
  }

  /**
   * Upload Inventory Storage
   *
   * @param  Request $request [description]
   * @return [type]           [description]
   */
  public function upload(Request $request)
  {
    $request->validate([
      'file_inventory_storage' => 'required',
    ]);

    $file = fopen($request->file('file_inventory_storage'), "r");

    $title        = true; // Untuk Penada Baris pertama adalah Judul
    $rs_inventory = [];
    $rs_storage   = [];
    $rs_model     = [];

    while (!feof($file)) {
      $row = fgetcsv($file);

      if ($title) {
        $title = false;
        continue; // Skip baris judul
      }

      $sto_loc_code_long = $row[0];
      $model_name        = $row[1];
      $quantity          = $row[2];

      if (!empty($sto_loc_code_long)) {
        if (empty($rs_storage[$sto_loc_code_long])) {
          $storage = StorageMaster::where('sto_loc_code_long', $sto_loc_code_long)->first();
          if (empty($storage)) {
            $result['status']  = false;
            $result['message'] = 'Storage ' . $sto_loc_code_long . ' not found in master storage !';
            return $result;
          }
          $rs_storage[$sto_loc_code_long] = $storage;
        }

        if (empty($rs_model[$model_name])) {
          $model = MasterModel::where('model_name', $model_name)->first();
          if (empty($model)) {
            $result['status']  = false;
            $result['message'] = 'Model ' . $model_name . ' not found in master model !';
            return $result;
          }
          $rs_model[$model_name] = $model;
        }

        $inventory = InventoryStorage::updateOrCreate(
          // Condition
          [
            'storage_id' => $rs_storage[$sto_loc_code_long]->id,
            'model_name' => $model_name,
          ],
          // Data Update
          [
            'ean_code'       => $rs_model[$model_name]->ean_code,
            'quantity_total' => $quantity,
            'cbm_total'      => $rs_model[$model_name]->cbm * $quantity,
            'last_updated'   => date('Y-m-d H:i:s'),
          ]
        );

        $rs_inventory[] = $inventory;
      }
    }

    return $rs_inventory;
  }
}
