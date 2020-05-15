<?php

namespace App\Models;

use App\BaseModel;

class Vendor extends BaseModel
{
    protected $table = "master_vendor";
    //protected $primaryKey = 'cabang_number';
    protected $primaryKey = 'vendor_code';
}
