<?php

namespace App\Models;

use App\BaseModel;

class MasterDestination extends BaseModel
{
    protected $table = "tr_destination";
    protected $primaryKey = 'destination_number';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';

     /**
     * Get the cabang.
     */
    public function MasterCabang()
    {
        return $this->belongsTo('App\Models\MasterCabang', 'kode_cabang', 'kode_cabang');
    }

    /**
     * Get the region.
     */
    public function Region()
    {
        return $this->belongsTo('App\Models\Region', 'region', 'region');
    }
}
