<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
  protected $table      = "tr_user_roles";
  protected $primaryKey = 'roles_id';
  public $incrementing  = false;

  public function details()
  {
    return $this->hasMany('App\Models\UserRoleDetail', 'roles_id');
  }
}
