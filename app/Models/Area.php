<?php

namespace App\Models;

use App\BaseModel;

class Area extends BaseModel
{
  // Set Table Primary Key
  // if not set default : id
  protected $primaryKey = 'area';

  /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';
}
