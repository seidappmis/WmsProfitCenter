<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogManifestDetail extends Model
{
  protected $table = 'log_manifest_detail';

  public function getDesc()
  {
    if ($this->tcs) {
      return 'TCS';
    } elseif ($this->do_return) {
      return "Return";
    } else {
      return 'Manual';
    }
  }
}
