<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogReturnSuratTugasPlan extends Model
{
  protected $table      = 'log_return_surat_tugas_plan';
  protected $primaryKey = 'id_detail_plan';

  public $timestamps = false;

  public function actual()
  {
    return $this->hasMany('App\Models\LogReturnSuratTugasActual', 'id_detail_plan', 'id_detail_plan');
  }
}
