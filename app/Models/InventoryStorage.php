<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryStorage extends Model
{
  protected $table = 'wms_inventory_storage';

  protected $fillable = ['storage_id', 'model_name', 'ean_code', 'quantity_total', 'cbm_total', 'last_updated'];

  public function storage()
  {
    return $this->belongsTo('App\Models\StorageMaster', 'storage_id', 'id');
  }

  public static function getFullData()
  {
    return InventoryStorage::
      selectRaw('
        wms_inventory_storage.*,
        wms_master_storage.sto_type_desc,
        wms_master_storage.sto_loc_code_long
      ')
      ->leftjoin('wms_master_storage', 'wms_master_storage.id', '=', 'wms_inventory_storage.storage_id')
    ;
  }
}
