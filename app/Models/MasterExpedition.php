<?php

namespace App\Models;

use App\BaseModel;

// use Illuminate\Database\Eloquent\Model;

class MasterExpedition extends BaseModel
{
    protected $table = "master_expedition";
    protected $primaryKey = 'expedition_name';
    protected $keyType='string';
    
    // protected $casts = [
    //     'active'=>'boolean',
        
    // ];
}
