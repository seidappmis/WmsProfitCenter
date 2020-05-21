<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelMaterialGroup extends Model
{
    //Set Table
    protected $table = "wms_model_material_group";

    // Set Table Primary Key
	// if not set default : id
	protected $primaryKey = 'code';

	/**
	   * The "type" of the auto-incrementing ID.
	   *
	   * @var string
	   */
	   protected $keyType = 'string';
}
