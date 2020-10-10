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
                wms_pickinglist_header.vehicle_number,
                IF(wms_pickinglist_header.city_code = "AS", "AS", wms_pickinglist_header.driver_id) AS driver_id,
                wms_pickinglist_header.`driver_register_id`,
                log_manifest_header.`do_manifest_no`,
                wms_pickinglist_header.`city_code`,
                log_manifest_header.`status_complete`
              FROM wms_pickinglist_header
              LEFT JOIN log_manifest_header ON log_manifest_header.`driver_register_id` = wms_pickinglist_header.`driver_register_id`
              WHERE (log_manifest_header.`status_complete` != 1 OR log_manifest_header.`status_complete` IS NULL)
              GROUP BY wms_pickinglist_header.`driver_register_id`
            ) AS t'
              ),
              't.picking_gate_number', '=', 'tr_gate.gate_number'
            )->orderBy('gate_number');
      if(!auth()->user()->cabang->hq){
        $query->where('area', $area);
      }            

    return $query;          
  }
}
