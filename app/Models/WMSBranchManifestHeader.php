<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WMSBranchManifestHeader extends Model
{
  protected $table      = 'wms_branch_manifest_header';
  protected $primaryKey = 'do_manifest_no';
  public $incrementing  = false;
}
