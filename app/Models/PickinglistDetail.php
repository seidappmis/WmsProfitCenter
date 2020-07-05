<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PickinglistDetail extends Model
{
  protected $table     = 'wms_pickinglist_detail';
  public $incrementing = false;

  public function header(){
    return $this->belongsTo('App\Models\PickinglistHeader', 'header_id', 'id');
  }
}
