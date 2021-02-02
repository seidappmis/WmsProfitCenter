<?php

namespace App\Models;

use App\Models\Concept;
use DB;
use Illuminate\Database\Eloquent\Model;

class ConceptFlowHeader extends Model
{
  protected $table = "tr_concept_flow_header";

  public $incrementing = false;

  public $timestamps = false;

  public static function getLoadingSummary($request = null)
  {
    $concept = ConceptFlowHeader::select(
      'tr_concept.*',
      DB::raw('tr_destination.destination_description AS concept_destination_name'),
      DB::raw('tr_driver_registered.driver_id AS reg_driver_id'),
      DB::raw('tr_driver_registered.driver_name AS reg_driver_name'),
      DB::raw('tr_driver_registered.vehicle_number AS reg_vehicle_no'),
      DB::raw('tr_driver_registered.vehicle_description AS reg_vehicle_description'),
      DB::raw('tr_driver_registered.vehicle_code_type AS reg_vehicle_type'),
      DB::raw('tr_concept_flow_header.cbm_truck AS reg_cbm_truck'),
      DB::raw('tr_driver_registered.datetime_in AS reg_date_in'),
      DB::raw('tr_driver_registered.datetime_out AS reg_date_out'),
      DB::raw('tr_driver_registered.destination_name AS reg_destination'),
      // DB::raw('tr_driver_registered.region AS reg_region'),
      DB::raw('tr_destination.region AS reg_region'),
      DB::raw('tr_driver_registered.expedition_code AS reg_expedition_code'),
      DB::raw('tr_driver_registered.expedition_name AS reg_expedition_name'),
      DB::raw('tr_concept_flow_header.created_at AS mapping_concept_date'),
      DB::raw('tr_concept_flow_header.created_at AS select_gate_date'),
      DB::raw('tr_concept_truck_flow.gate_number AS load_gate_number'),
      DB::raw('tr_concept_truck_flow.start_date AS load_loading_start'),
      DB::raw('tr_concept_truck_flow.end_date AS load_loading_end'),
      DB::raw('CASE WHEN
        (tr_concept_flow_header.workflow_id = 5 OR tr_concept_flow_header.workflow_id = 6)
        THEN
        TIMESTAMPDIFF(MINUTE, tr_concept_truck_flow.start_date, tr_concept_truck_flow.end_date)
        ELSE 0 END
        AS load_loading_minutes'),
      DB::raw('tr_concept_truck_flow.complete_date AS load_complete_date'),
      DB::raw('tr_concept_truck_flow.do_manifest_no AS load_do_manifest_no'),
      DB::raw('tr_workflow.step_description AS status')
    )
      ->leftjoin('tr_concept_flow_detail', 'tr_concept_flow_detail.id_header', '=', 'tr_concept_flow_header.id')
      ->leftjoin('tr_driver_registered', 'tr_driver_registered.id', '=', 'tr_concept_flow_header.driver_register_id')
      ->leftjoin('tr_concept', function ($join) {
        $join->on('tr_concept.invoice_no', '=', 'tr_concept_flow_detail.invoice_no');
        $join->on('tr_concept.line_no', '=', 'tr_concept_flow_detail.line_no');
      })
      ->leftjoin('tr_destination', 'tr_destination.destination_number', '=', 'tr_concept.destination_number')
      ->leftjoin('tr_vehicle_type_detail', 'tr_vehicle_type_detail.vehicle_code_type', '=', 'tr_concept.vehicle_code_type')
      ->leftjoin('tr_concept_truck_flow', 'tr_concept_truck_flow.concept_flow_header', '=', 'tr_concept_flow_header.id')
      ->leftjoin('tr_workflow', 'tr_workflow.step_number', '=', 'tr_concept_flow_header.workflow_id')
    ;

    $concept->whereNotNull('tr_concept.invoice_no');

    if ($request != null) {
      $concept->where('tr_concept.area', $request->input('area'));
    }

    return $concept;
  }

  public static function getSummaryConcept($request = null)
  {
    $rs_concept_waiting_truck_temp = Concept::getLoadingDailyStatusWaitingTruck($request);

    return ConceptFlowHeader::getLoadingSummary($request)->union($rs_concept_waiting_truck_temp);
  }
}
