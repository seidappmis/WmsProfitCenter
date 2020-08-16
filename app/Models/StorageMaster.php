<?php

namespace App\Models;

use App\BaseModel;

class StorageMaster extends BaseModel
{
    //Set Table
    protected $table = "wms_master_storage";

    public function inventoryStorage()
    {
        return $this->hasOne('App\Models\InventoryStorage', 'storage_id');
    }

    /**
     * Get the branch that owns the storage master.
     */
    public function MasterCabang()
    {
        return $this->belongsTo('App\Models\MasterCabang', 'kode_cabang', 'kode_cabang');
    }

    /**
     * Get the branch that owns the storage master.
     */
    public function StorageType()
    {
        return $this->belongsTo('App\Models\StorageType', 'sto_type_id');
    }

    public function isUsed(){
        return !empty($this->inventoryStorage);
    }
}
