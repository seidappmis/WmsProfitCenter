<?php

namespace App\Models;

use App\BaseModel;
use DB;

class Gate extends BaseModel
{
  //Set Table
  protected $table = "tr_gate";

  /**
   * Get the Area that owns the Gate.
   */
  public function Area()
  {
    return $this->belongsTo('App\Models\Area', 'area');
  }

  public static function getLoadingGate($area)
  {
    return Gate::leftjoin(
        DB::raw(
          '(SELECT
           wms_pickinglist_header.`gate_number` AS picking_gate_number,
           wms_pickinglist_header.vehicle_number,
           wms_pickinglist_header.driver_id,
           wms_pickinglist_header.`driver_register_id`,
           log_manifest_header.`do_manifest_no`,
           log_manifest_header.`status_complete`
         FROM wms_pickinglist_header
         LEFT JOIN log_manifest_header ON log_manifest_header.`driver_register_id` = wms_pickinglist_header.`driver_register_id`
         WHERE (log_manifest_header.`status_complete` != 1 OR log_manifest_header.`status_complete` IS NULL)) AS t'
        ),
        't.picking_gate_number', '=', 'tr_gate.gate_number'
      )
      ->where('area', $area)
      ->orderBy('gate_number')
    ;
  }
}
