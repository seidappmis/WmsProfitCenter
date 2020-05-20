<?php

namespace App\Models;

use App\BaseModel;

class StorageMaster extends BaseModel
{
    //Set Table
    protected $table = "wms_master_storage";

    /**
     * Get the branch that owns the storage master.
     */
    public function MasterCabang()
    {
        return $this->belongsTo('App\Models\MasterCabang', 'kode_cabang_id');
    }

    /**
     * Get the branch that owns the storage master.
     */
    public function StorageType()
    {
        return $this->belongsTo('App\Models\StorageType', 'sto_type_id');
    }
}
