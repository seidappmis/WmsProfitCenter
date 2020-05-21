<?php

namespace App\Models;

use App\BaseModel;

class ModelException extends BaseModel
{
    //Set Table
    protected $table = "log_model_exception";

    // Set Table Primary Key
	// if not set default : id
	protected $primaryKey = 'model';

	/**
	   * The "type" of the auto-incrementing ID.
	   *
	   * @var string
	   */
	   protected $keyType = 'string';
}
