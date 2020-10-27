<?php

namespace App;

use App\Models\UserRoleDetail;
use App\Models\UsersGrantCabang;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Request;

class User extends Authenticatable
{
  use HasApiTokens, Notifiable;

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

  public static function getStringGrantCabang()
  {
    $grantCabangs = UsersGrantCabang::select('kode_cabang_grant')
      ->where('userid', auth()->user()->username)
      ->get();

    $result = [];

    foreach ($grantCabangs as $key => $value) {
      $result[] = $value['kode_cabang_grant'];
    }

    return $result;
  }

  public function allowTo($access = 'view', $modul_link = '')
  {
    if (!in_array($access, ['view', 'edit', 'delete'])) {
      return false;
    }
    if ($modul_link == '') {
      $modul_link = Request::segment(1);
    }
    $roleDetail = UserRoleDetail::leftjoin('tr_modules', 'tr_modules.id', '=', 'tr_user_roles_detail.modul_id')
      ->where('roles_id', $this->roles_id)
      ->where('tr_modules.modul_link', $modul_link)
      ->where($access, 1)
      ->first();

    return !empty($roleDetail);
  }
}
