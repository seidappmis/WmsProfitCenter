<?php

namespace App\Models;

use App\BaseModel;

class BeritaAcaraDetail extends BaseModel
{
    //Set Table
    protected $table = "clm_berita_acara_detail";

    public function beritaacara()
    {
        return $this->belongsTo('App\Models\BeritaAcara');
    }

    public function Model()
    {
        return $this->belongsTo('App\Models\MasterModel', 'model_name', 'model_name');
    }
}
