<?php

namespace App\Models;

use App\BaseModel;

class UserScanner extends BaseModel
{
    protected $table = "wms_user_scanner";
    protected $primaryKey = 'userid';
    public $incrementing = false;
}
