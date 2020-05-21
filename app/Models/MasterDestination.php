<?php

namespace App\Models;

use App\BaseModel;

class MasterDestination extends BaseModel
{
    protected $table = "master_destination";
    protected $primaryKey = 'destination_number';
    public $incrementing = false;
}
