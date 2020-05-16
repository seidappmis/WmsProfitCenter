<?php

namespace App\Models;

use App\BaseModel;

class MasterCabang extends BaseModel
{
    protected $table = "master_cabang";
    //protected $primaryKey = 'cabang_number';
    protected $primaryKey = 'code_cabang';
}
