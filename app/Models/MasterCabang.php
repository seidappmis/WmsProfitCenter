<?php

namespace App\Models;

use App\BaseModel;

class MasterCabang extends BaseModel
{
    protected $table = "cabangs";
    
    // Set Table Primary Key
	// if not set default : id
	protected $primaryKey = 'kode_customer';

	/**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';
}
