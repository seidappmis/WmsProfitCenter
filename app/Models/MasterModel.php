<?php

namespace App\Models;

use App\BaseModel;

class MasterModel extends BaseModel
{
    //Set Table
    protected $table = "wms_master_model";

    /**
     * Get the model material group.
     */
    public function ModelMaterialGroup()
    {
        return $this->belongsTo('App\Models\ModelMaterialGroup', 'material_group');
    }

    /**
     * Get the model category.
     */
    public function ModelCategory()
    {
        return $this->belongsTo('App\Models\ModelCategory', 'category');
    }

    /**
     * Get the model type.
     */
    public function ModelType()
    {
        return $this->belongsTo('App\Models\ModelType', 'model_type');
    }
}
