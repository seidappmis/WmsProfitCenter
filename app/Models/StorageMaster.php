<?php

namespace App\Models;

use App\BaseModel;

class StorageMaster extends BaseModel
{
    //Set Table
    protected $table = "master_storages";

    /**
     * Get the branch that owns the storage master.
     */
    public function kode_cabang()
    {
        return $this->belongsTo('App\Models\MasterCabang', 'kode_cabang_id');
    }

    /**
     * Get the branch that owns the storage master.
     */
    public function storage_type()
    {
        return $this->belongsTo('App\Models\StorageType', 'sto_type_id');
    }
}
