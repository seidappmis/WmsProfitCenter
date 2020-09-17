<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    //Set Table
    protected $table = "log_region";

    // Set Table Primary Key
	// if not set default : id
	protected $primaryKey = 'region';

	/**
	   * The "type" of the auto-incrementing ID.
	   *
	   * @var string
	   */
	   protected $keyType = 'string';
}
