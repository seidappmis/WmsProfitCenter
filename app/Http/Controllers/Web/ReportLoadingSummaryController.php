<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class ReportLoadingSummaryController extends Controller
{
  public function index(Request $request)
  {
    if ($request->ajax()) {
      $year  = '';
      $month = '';

      if (!empty($request->input('periode'))) {
        $periode = Carbon::createFromFormat('d/m/Y', '01/' . $request->input('periode'));

        $year  = $periode->format('Y');
        $month = $periode->format('m');
      }

      $queryWC = DB::select("
        SELECT 
          td.region,
          tvtg.group_name,
          tvtd.vehicle_description AS vehicle_type,
          COUNT(tdr.id) AS total 
        FROM tr_driver_registered tdr 
        LEFT JOIN tr_destination td ON td.destination_number = tdr.destination_number
        LEFT JOIN tr_vehicle_type_detail tvtd ON tvtd.vehicle_code_type = tdr.vehicle_code_type 
        LEFT JOIN tr_vehicle_type_group tvtg ON tvtd.vehicle_group_id = tvtg.id 
        LEFT JOIN tr_concept_flow_header tcfh ON tcfh.driver_register_id = tdr.id 
        WHERE tdr.area = ? AND tcfh.id IS NULL AND tdr.wk_step_number IS NULL
         AND MONTH(tdr.datetime_in) = ? AND YEAR(tdr.datetime_in) = ?
        GROUP BY tvtg.group_name, tvtd.vehicle_description 
        ", [
        $request->input('area'),
        $month,
        $year,
      ]);

      $queryWT = DB::select("
        SELECT 
        td.region,
        tvtg.group_name,
        SUM(tc.cbm) AS cbm_concept
        FROM tr_concept tc 
        LEFT JOIN tr_concept_flow_detail tcfd ON tcfd.invoice_no = tc.invoice_no AND tcfd.line_no = tc.line_no AND tc.sold_to <> ''
        LEFT JOIN tr_destination td ON td.destination_number = tc.destination_number
        LEFT JOIN tr_vehicle_type_detail tvtd ON tvtd.vehicle_code_type = tc.vehicle_code_type 
        LEFT JOIN tr_vehicle_type_group tvtg ON tvtg.id = tvtd.vehicle_group_id 
        WHERE tcfd.id_header IS NULL AND tc.area = ? 
          AND MONTH(tc.created_at) = ? AND YEAR(tc.created_at) = ?
        GROUP BY tvtg.group_name, td.region
        ", [
        $request->input('area'),
        $month,
        $year,
      ]);

      $queryWL = DB::select("
        SELECT 
        IF(tw.step_description IS NULL, 'WAITING LOADING', tw.step_description) AS status,
        tdr.vehicle_number,
        tdr.destination_name,
        IF(tcfh.cbm_concept IS NULL, 0, tcfh.cbm_concept) AS total_cbm,
        tdr.expedition_name,
        tdr.vehicle_code_type AS vehicle_type,
        tvtg.group_name AS vehicle_group,
        tcfh.cbm_truck as capacity,
        tcfh.workflow_id
        FROM tr_concept_flow_header tcfh 
        LEFT JOIN tr_vehicle_type_detail tvtd ON tvtd.vehicle_code_type = tcfh.vehicle_code_type 
        LEFT JOIN tr_vehicle_type_group tvtg ON tvtg.id = tvtd.vehicle_group_id 
        LEFT JOIN tr_driver_registered tdr ON tdr.id = tcfh.driver_register_id 
        LEFT JOIN tr_concept_flow_detail tcfd ON tcfd.id_header = tcfh.id 
        LEFT JOIN tr_workflow tw ON tw.id = tcfh.workflow_id 
        WHERE tdr.area = ? 
        AND MONTH(tcfh.created_at) = ? AND YEAR(tcfh.created_at) = ?
        AND tcfh.workflow_id is null
        ", [
        $request->input('area'),
        $month,
        $year,
      ]);

      $tabeldata = '';
      $tabeldata .= '<div style="text-align: center; font-size: 14pt;"><strong>Report Loading Summary - Area : ' . $request->input('area') . ')</strong></div>';

      $tabeldata .= '<table>';
      $tabeldata .= '<tr>';
      $tabeldata .= '<td style="vertical-align: top;">';
      $tabeldata .= '<p style="text-align: center; font-weight: 800;">WAITING TRUCK</p>';
      $tabeldata .= 'Sum of Concept CBM';
      $tabeldata .= '<table>';
      $tabeldata .= '<tr>';
      $tabeldata .= '<th>REG REGION</th>';
      $tabeldata .= '<th>VEHICLE GROUP</th>';
      $tabeldata .= '<th>TOTAL</th>';
      $tabeldata .= '</tr>';
      foreach ($queryWT as $key => $value) {
        $tabeldata .= '<tr>';
        $tabeldata .= '<td>' . $value->region . '</td>';
        $tabeldata .= '<td>' . $value->group_name . '</td>';
        $tabeldata .= '<td style="text-align: right;">' . $value->cbm_concept . '</td>';
        $tabeldata .= '</tr>';
      }
      $tabeldata .= '</table>';
      $tabeldata .= '</td>';
      $tabeldata .= '<td style="vertical-align: top;">';
      $tabeldata .= '<p style="text-align: center; font-weight: 800;">WAITING CONCEPT</p>';
      $tabeldata .= 'Count of Vehicle Number';
      $tabeldata .= '<table>';
      $tabeldata .= '<tr>';
      $tabeldata .= '<th>REGION</th>';
      $tabeldata .= '<th>VEHICLE TYPE</th>';
      $tabeldata .= '<th>TOTAL</th>';
      $tabeldata .= '</tr>';
      foreach ($queryWC as $key => $value) {
        $tabeldata .= '<tr>';
        $tabeldata .= '<td>' . $value->region . '</td>';
        $tabeldata .= '<td>' . $value->vehicle_type . '</td>';
        $tabeldata .= '<td style="text-align: right;">' . $value->total . '</td>';
        $tabeldata .= '</tr>';
      }
      $tabeldata .= '</table>';
      $tabeldata .= '</td>';
      $tabeldata .= '</tr>';
      $tabeldata .= '</table>';
      $tabeldata .= '<br>';

      $tabeldata .= '<table>';
      $tabeldata .= '<tr>';
      $tabeldata .= '<th style="text-align: center;">STATUS</th>';
      $tabeldata .= '<th style="text-align: center;">VEHICLE NO.</th>';
      $tabeldata .= '<th style="text-align: center;">DESTINATION</th>';
      $tabeldata .= '<th style="text-align: center;">TOTAL CBM</th>';
      $tabeldata .= '<th style="text-align: center;">EXPEDITION NAME</th>';
      $tabeldata .= '<th style="text-align: center;">VEHICLE TYPE</th>';
      $tabeldata .= '<th style="text-align: center;">VEHICLE GROUP</th>';
      $tabeldata .= '<th style="text-align: center;">CAPACITY</th>';
      $tabeldata .= '<th style="text-align: center;">GATE</th>';
      $tabeldata .= '</tr>';

      foreach ($queryWL as $key => $value) {
        $tabeldata .= '<tr>';
        $tabeldata .= '<td>' . $value->status . '</td>';
        $tabeldata .= '<td>' . $value->vehicle_number . '</td>';
        $tabeldata .= '<td>' . $value->destination_name . '</td>';
        $tabeldata .= '<td>' . $value->total_cbm . '</td>';
        $tabeldata .= '<td>' . $value->expedition_name . ' %</td>';
        $tabeldata .= '<td>' . $value->vehicle_type . ' %</td>';
        $tabeldata .= '<td>' . $value->vehicle_group . ' %</td>';
        $tabeldata .= '<td>' . $value->capacity . ' %</td>';
        $tabeldata .= '</tr>';
      }

      $tabeldata .= '</table>';

      $result = [
        'data'            => [
          ['tabeldata' => $tabeldata],
        ],
        'draw'            => 0,
        'recordsFiltered' => 0,
        'recordsTotal'    => 0,
      ];

      return $result;
    }
    return view('web.report.report-loading-summary.index');
  }
}
