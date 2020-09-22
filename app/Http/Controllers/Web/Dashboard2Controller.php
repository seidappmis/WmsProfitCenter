<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Concept;
use App\Models\ConceptFlowHeader;
use App\Models\TRWorkflow;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class Dashboard2Controller extends Controller
{
  public function getDailyByCategory(Request $request)
  {
    // $rs_concept_waiting_truck_temp = Concept::getLoadingDailyStatusWaitingTruck($request);
    $rs_concept = ConceptFlowHeader::getSummaryConcept($request)->get();
    $rs_temp_vehicle_detail        = Vehicle::select(
      'tr_vehicle_type_group.group_name',
      'tr_vehicle_type_detail.*'
    )->leftjoin('tr_vehicle_type_detail', 'tr_vehicle_type_group.id', '=', 'tr_vehicle_type_detail.vehicle_group_id')
      ->whereNotNull('tr_vehicle_type_detail.id')
      ->orderBy('tr_vehicle_type_group.group_name')
      ->get()
    ;
    $rs_workflow = TRWorkflow::select('step_number', 'step_description', 'finished')
      ->where('finished', 0)
      ->orderBy('step_number')
      ->get();

    $rs_vehicle_category = []; // Vehicle Category
    $rs_vehicle_detail   = []; // Vehicle Detail
    foreach ($rs_temp_vehicle_detail as $key => $value) {
      $rs_vehicle_category[$value->group_name] = $value->group_name;
      if ($value->vehicle_code_type != '') {
        $rs_vehicle_detail[$value->vehicle_code_type] = $value;
      }
    }

    $rs_unit_truck_temp             = [];
    $rs_daily_status_by_destination = [];
    foreach ($rs_concept as $key => $value) {
      $rs_unit_truck_temp[$value->status][$rs_vehicle_detail[$value->vehicle_code_type]->group_name][$value->invoice_no . $value->expedition_id . $value->vehicle_code_type] = $value;
      $rs_daily_status_by_destination[$value->reg_region][$value->invoice_no . $value->expedition_id . $value->vehicle_code_type]                                            = $value;
    }

    $rs_unit_truck = [];
    foreach ($rs_unit_truck_temp as $kut => $vut) {
      // $rs_unit_truck[$key] = count($value);
      foreach ($vut as $kutg => $vutg) {
        $rs_unit_truck[$kut][$kutg] = count($vutg);
      }
    }

    $rs_daily_by_category_series     = [];
    $rs_daily_by_category_categories = [];
    foreach ($rs_workflow as $kw => $vw) {
      if (!$vw->finished) {
        $rs_daily_by_category_categories[] = $vw->step_description;
        foreach ($rs_vehicle_category as $kc => $vc) {
          if (empty($rs_unit_truck[$vw->step_description][$kc])) {
            $rs_unit_truck[$vw->step_description][$kc] = 0;
          }
          $rs_daily_by_category_series[$kc]['name']   = $kc;
          $rs_daily_by_category_series[$kc]['data'][] = $rs_unit_truck[$vw->step_description][$kc];
        }
      }
    }

    $rs_by_destination_series_data = [];
    foreach ($rs_daily_status_by_destination as $key => $value) {
      $rs_by_destination_series_data[] = [$key, count($value)];
    }

    $result = [
      'subtitle_text'                   => $request->input('area') . ' ' . date("Y-m-d"),
      'rs_concept_waiting_truck_temp'   => $rs_concept,
      // 'rs_unit_truck'                 => $rs_unit_truck,
      // 'rs_temp_vehicle_detail'        => $rs_temp_vehicle_detail,
      'rs_by_destination_series_data'   => $rs_by_destination_series_data,
      'rs_daily_by_category_categories' => ($rs_daily_by_category_categories),
      // 'rs_vehicle_category'             => array_values($rs_vehicle_category),
      'rs_daily_by_category_series'     => array_values($rs_daily_by_category_series),
    ];

    // $result['waiting_truck'] = $waiting_truck;
    return sendSuccess("Waiting truck All Area Retrive.", $result);
  }
}
