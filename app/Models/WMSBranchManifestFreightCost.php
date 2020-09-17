<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WMSBranchManifestFreightCost extends Model
{
  protected $table      = 'wms_branch_manifest_freight_cost';
  protected $primaryKey = ['delivery_no', 'model', 'do_manifest_no'];
  public $incrementing  = false;
}
