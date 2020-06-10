<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UploadInventoryStorageController extends Controller
{
  public function index()
  {
    return view('web.inventory.upload-inventory-storage.index');
  }

  public function upload(Request $request)
  {
    $request->validate([
      'file_inventory_storage' => 'required',
    ]);

    $file = fopen($request->file('file_inventory_storage'), "r");

    $title        = true; // Untuk Penada Baris pertama adalah Judul
    $rs_inventory = [];
    $rs_model     = [];

    while (!feof($file)) {
      $row = fgetcsv($file);

      if ($title) {
        $title = false;
        continue; // Skip baris judul
      }

      $inventory                      = [];
      $inventory['sto_loc_code_long'] = $row[0];
      $inventory['model']             = $row[1];
      $inventory['quantity']          = $row[2];

      if (!empty($inventory['sto_loc_code_long'])) {
        $rs_inventory[] = $inventory;
      }
    }

    return $rs_inventory;
  }
}
