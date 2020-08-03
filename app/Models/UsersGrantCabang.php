<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsersGrantCabang extends Model
{
  protected $table      = "wms_users_grant_cabang";
  protected $primaryKey = 'userid';
  public $incrementing  = false;

  public function cabang()
  {
    return $this->belongsTo('App\Models\MasterCabang', 'kode_cabang_grant', 'kode_cabang');
  }
}
