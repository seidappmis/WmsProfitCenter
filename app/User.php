<?php

namespace App;

use App\Models\UserRoleDetail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
  use Notifiable;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'name', 'email', 'password',
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    'password', 'remember_token',
  ];

  /**
   * The attributes that should be cast to native types.
   *
   * @var array
   */
  protected $casts = [
    'email_verified_at' => 'datetime',
  ];

  public static function modules()
  {
    $modules = UserRoleDetail::where('roles_id', auth()->user()->roles_id)
      ->leftjoin('tr_modules', 'tr_modules.id', '=', 'tr_user_roles_detail.modul_id')
      ->get()
      ->toArray();

    $rs_modules = [];

    foreach ($modules as $key => $value) {
      $rs_modules[$value['modul_link']] = $value;
    }

    return $rs_modules;
  }

  public function role()
  {
    return $this->belongsTo('App\Models\UserRole', 'roles_id', 'roles_id');
  }

  public function cabang()
  {
    return $this->belongsTo('App\Models\MasterCabang', 'kode_customer', 'kode_customer');
  }

  public function area_data()
  {
    return $this->belongsTo('App\Models\Area', 'area', 'area');
  }

  public function grantCabangs()
  {
    return $this->hasMany('App\Models\UsersGrantCabang', 'userid', 'username');
  }
}
