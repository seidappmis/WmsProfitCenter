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

    $query = Gate::leftjoin(
      DB::raw(
        '(SELECT
                wms_pickinglist_header.`gate_number` AS picking_gate_number,
                wms_pickinglist_header.area,
                wms_pickinglist_header.vehicle_number,
                IF(wms_pickinglist_header.city_code = "AS", "AS", wms_pickinglist_header.driver_id) AS driver_id,
                wms_pickinglist_header.`driver_register_id`,
                log_manifest_header.`do_manifest_no`,
                wms_pickinglist_header.`city_code`,
                log_manifest_header.`status_complete`
              FROM wms_pickinglist_header
              LEFT JOIN log_manifest_header ON log_manifest_header.`driver_register_id` = wms_pickinglist_header.`driver_register_id`
              WHERE (log_manifest_header.`status_complete` != 1 OR log_manifest_header.`status_complete` IS NULL) 
                AND wms_pickinglist_header.vehicle_number IS NOT NULL
                AND wms_pickinglist_header.deleted_at IS NULL
              GROUP BY wms_pickinglist_header.`gate_number`, wms_pickinglist_header.area
            ) AS t'
      ),
      function ($join) {
        $join->on('t.picking_gate_number', '=', 'tr_gate.gate_number');
        $join->on('t.area', '=', 'tr_gate.area');
      }
    )
      ->orderBy('gate_number')
      // ->groupBy('gate_number')
    ;
    if (strtoupper($area) == 'ALL') {
      // tampilkan all;
    } else {
      $query->where('tr_gate.area', $area);
    }

    return $query;
  }
}
