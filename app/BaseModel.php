<?php

namespace App;

use Auth;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
  protected static function booted()
  {
    static::updating(function ($model) {
      $model->updated_by = Auth::user()->id;
    });

    static::creating(function ($model) {
      $model->updated_by = Auth::user()->id;
      $model->created_by = Auth::user()->id;
    });
  }
}
