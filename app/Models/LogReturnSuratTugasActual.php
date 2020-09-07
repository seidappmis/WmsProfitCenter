<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogReturnSuratTugasActual extends Model
{
  protected $table      = 'log_return_surat_tugas_actual';
  protected $primaryKey = 'id_detail_actual';

  public $timestamps = false;
}
