<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogReturnSuratTugasHeader extends Model
{
  protected $table      = 'log_return_surat_tugas_header';
  protected $primaryKey = 'id_header';

  public $timestamps = false;

  public function plans()
  {
    return $this->hasMany('App\Models\LogReturnSuratTugasPlan', 'id_header', 'id_header');
  }
}
