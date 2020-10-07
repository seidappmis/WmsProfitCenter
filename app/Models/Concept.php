<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Concept extends Model
{
  protected $table      = "tr_concept";
  protected $primaryKey = ['invoice_no', 'line_no'];
  public $incrementing  = false;

  public function destination()
  {
    return $this->belongsTo('App\Models\MasterDestination', 'destination_number', 'destination_number');
  }

  public static function getLoadingDailyStatusWaitingTruck($request = null)
  {
    $concept = Concept::select(
      'tr_concept.*',
      DB::raw('tr_destination.destination_description AS concept_destination_name'),
      DB::raw('"" AS reg_driver_id'),
      DB::raw('"" AS reg_driver_name'),
      DB::raw('"" AS reg_vehicle_no'),
      DB::raw('"" AS reg_vehicle_description'),
      DB::raw('"" AS reg_vehicle_type'),
      DB::raw('NULL AS reg_cbm_truck'),
      DB::raw('NULL AS reg_date_in'),
      DB::raw('NULL AS reg_date_out'),
      DB::raw('"" AS reg_destination'),
      DB::raw('tr_destination.region AS reg_region'),
      DB::raw('"" AS reg_expedition_code'),
      DB::raw('"" AS reg_expedition_name'),
      DB::raw('NULL AS mapping_concept_date'),
      DB::raw('NULL AS select_gate_date'),
      DB::raw('NULL AS load_gate_number'),
      DB::raw('NULL AS load_loading_start'),
      DB::raw('NULL AS load_loading_end'),
      DB::raw('0 AS load_loading_minutes'),
      DB::raw('NULL AS load_complete_date'),
      DB::raw('"" AS load_do_manifest_no'),
      DB::raw('"Waiting Truck" AS status')
    )
    ->leftjoin('tr_destination', 'tr_destination.destination_number', '=', 'tr_concept.destination_number')
    ->leftjoin('tr_vehicle_type_detail', 'tr_vehicle_type_detail.vehicle_code_type', '=', 'tr_concept.vehicle_code_type')
    ->leftjoin('tr_concept_flow_detail', function($join) {
      $join->on('tr_concept_flow_detail.invoice_no', '=', 'tr_concept.invoice_no');
      $join->on('tr_concept_flow_detail.line_no', '=', 'tr_concept.line_no');
    })
    // ->where('tr_concept.area', $request->input('area'))
    ->whereNull('tr_concept_flow_detail.invoice_no')
    ;

    if ($request != null) {
      $concept->where('tr_concept.area', $request->input('area'));
    }

    return $concept;
  }

}
