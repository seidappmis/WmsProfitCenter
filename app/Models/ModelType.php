<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelType extends Model
{
    //Set Table
    protected $table = "wms_model_type";

    // Set Table Primary Key
	// if not set default : id
	protected $primaryKey = 'model_type';

	/**
	   * The "type" of the auto-incrementing ID.
	   *
	   * @var string
	   */
	   protected $keyType = 'string';
}
