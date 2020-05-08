<?php

namespace App\Models;

use App\BaseModel;

class MasterArea extends BaseModel
{
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
