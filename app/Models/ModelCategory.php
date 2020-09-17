<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelCategory extends Model
{
    //Set Table
    protected $table = "wms_model_category";

    // Set Table Primary Key
	// if not set default : id
	protected $primaryKey = 'category_name';

	/**
	   * The "type" of the auto-incrementing ID.
	   *
	   * @var string
	   */
	   protected $keyType = 'string';
}
