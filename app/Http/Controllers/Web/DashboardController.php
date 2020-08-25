<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\Concept;
use App\Models\DriverRegistered;
use App\Models\TRWorkflow;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
  public function getLoadingDailyStatus(Request $request)
  {

    $rs_concept_waiting_truck_temp = Concept::getLoadingDailyStatusWaitingTruck($request);
    $rs_temp_vehicle_detail        = Vehicle::select(
      'tr_vehicle_type_group.group_name',
      'tr_vehicle_type_detail.*'
    )->leftjoin('tr_vehicle_type_detail', 'tr_vehicle_type_group.id', '=', 'tr_vehicle_type_detail.vehicle_group_id')
      ->orderBy('tr_vehicle_type_group.group_name')
      ->get()
    ;
    $rs_workflow = TRWorkflow::select('step_number', 'step_description', 'finished')
    // ->where('finished', 0)
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

    $rs_cbm                             = [];
    $rs_status_cbm_of_concept_list_temp = [];

    foreach ($rs_concept_waiting_truck_temp as $key => $value) {
      if (empty($rs_cbm[$value->status][$rs_vehicle_detail[$value->vehicle_code_type]->group_name])) {
        $rs_cbm[$value->status][$rs_vehicle_detail[$value->vehicle_code_type]->group_name] = 0;
      }
      if (empty($rs_status_cbm_of_concept_list_temp[$value->status])) {
        $rs_status_cbm_of_concept_list_temp[$value->status] = 0;
      }
      $rs_cbm[$value->status][$rs_vehicle_detail[$value->vehicle_code_type]->group_name] += $value->cbm;
      $rs_status_cbm_of_concept_list_temp[$value->status] += $value->cbm;
    }

    $rs_waiting_concept_temp = DriverRegistered::transporterWaitingConcept($request)->get();
    $rs_cbm_truck_temp       = [];

    foreach ($rs_waiting_concept_temp as $key => $value) {
      if (empty($rs_cbm_truck_temp['Waiting Concept'][$rs_vehicle_detail[$value->vehicle_code_type]->group_name])) {
        $rs_cbm_truck_temp['Waiting Concept'][$rs_vehicle_detail[$value->vehicle_code_type]->group_name] = 0;
      }
      $rs_cbm_truck_temp['Waiting Concept'][$rs_vehicle_detail[$value->vehicle_code_type]->group_name] += $value->cbm_max;
    }

    // return $rs_cbm_truck_temp;

    $rs_chart_categories           = [];
    $rs_cbm_of_concept             = [];
    $rs_cbm_of_truck               = [];
    $rs_status_cbm_of_concept_list = [];

    foreach ($rs_workflow as $kw => $vw) {
      $rs_status_cbm_of_concept_list[$vw->step_number]['step_description'] = $vw->step_description;
      $rs_status_cbm_of_concept_list[$vw->step_number]['value']            = !empty($rs_status_cbm_of_concept_list_temp[$vw->step_description]) ? $rs_status_cbm_of_concept_list_temp[$vw->step_description] : 0;

      if (!$vw->finished) {
        foreach ($rs_vehicle_category as $kc => $vc) {
          $rs_chart_categories[$vw->step_number]['name']         = $vw->step_description;
          $rs_chart_categories[$vw->step_number]['categories'][] = $kc;

          $rs_cbm_of_concept[$vw->step_description . $kc]['y'] = !empty($rs_cbm[$vw->step_description][$kc]) ? $rs_cbm[$vw->step_description][$kc] : 0;
          $rs_cbm_of_truck[$vw->step_description . $kc]['y']   = !empty($rs_cbm_truck_temp[$vw->step_description][$kc]) ? $rs_cbm_truck_temp[$vw->step_description][$kc] : 0;
        }
      }
    }

    $result = [
      'subtitle_text'                 => $request->input('area') . ' ' . date("Y-m-d"),
      // 'rs_cbm'                             => $rs_cbm,
      // 'rs_vehicle_detail'                  => $rs_vehicle_detail,
      // 'rs_vehicle_category'                => $rs_vehicle_category,
      // 'rs_workflow'                        => $rs_workflow,
      'rs_chart_categories'           => array_values($rs_chart_categories),
      'rs_cbm_of_concept'             => array_values($rs_cbm_of_concept),
      'rs_cbm_of_truck'               => array_values($rs_cbm_of_truck),
      'rs_status_cbm_of_concept_list' => array_values($rs_status_cbm_of_concept_list),
    ];

    return sendSuccess('Loading Daily Status Retrive.', $result);
  }

  public function getWaitingTruckAllArea()
  {
    $rs_area                       = Area::whereNotNull('code')->orderBy('area')->get();
    $rs_concept_waiting_truck_temp = Concept::getLoadingDailyStatusWaitingTruck();

    $rs_cbm             = [];
    $rs_unit_truck_temp = [];
    foreach ($rs_concept_waiting_truck_temp as $key => $value) {
      $area = strtolower(str_replace(' ', '-', $value->area));
      if (empty($rs_cbm[$area])) {
        $rs_cbm[$area] = 0;
      }
      $rs_cbm[$area] += $value->cbm;
      $rs_unit_truck_temp[$area][$value->invoice_no . $value->expedition_id . $value->vehicle_code_type] = $value;
    }

    $rs_unit_truck = [];
    foreach ($rs_unit_truck_temp as $key => $value) {
      $rs_unit_truck[$key] = count($value);
    }

    // return $rs_area;

    $result = [
      'rs_concept_waiting_truck_temp' => $rs_concept_waiting_truck_temp,
      'rs_unit_truck'                 => $rs_unit_truck,
      'rs_cbm'                        => $rs_cbm,
    ];

    // $result['waiting_truck'] = $waiting_truck;
    return sendSuccess("Waiting truck All Area Retrive.", $result);
  }
}
