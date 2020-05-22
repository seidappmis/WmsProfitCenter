<?php

namespace App\Models;

use App\BaseModel;

class DestinationCity extends BaseModel
{
  // Set Table Primary Key
  // if not set default : id
  protected $primaryKey = 'city_code';

  /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    // protected $keyType = 'string';

}
