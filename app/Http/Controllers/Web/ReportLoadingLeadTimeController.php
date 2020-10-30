<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;

class ReportLoadingLeadTimeController extends Controller
{
  public function index(Request $request)
  {
    if ($request->ajax()) {
      return sendSuccess('Data Retrive', $this->getLoadingLeadTime($request));
    }

    return view('web.report.report-loading-lead-time.index');
  }

  protected function getLoadingLeadTime($request)
  {
    $sql = "
    SELECT
      t.vehicle_code AS reg_vehicle_type,
      MAX(IF(weeks = 1, total, TIME('00:00:00'))) AS i,
      MAX(IF(weeks = 2, total, TIME('00:00:00'))) AS ii,
      MAX(IF(weeks = 3, total, TIME('00:00:00'))) AS iii,
      MAX(IF(weeks = 4, total, TIME('00:00:00'))) AS iv
    FROM (
      SELECT
        tvtd.urut,
        tvtg.group_name,
        tvtd.vehicle_description AS vehicle_code,
        CAST(DATE_ADD('1900-01-01 00:00:00.000', INTERVAL SUM(
          TIME_TO_SEC(CAST(DATE_ADD('1900-01-01 00:00:00.000', INTERVAL (UNIX_TIMESTAMP(tctf.created_end_date) - UNIX_TIMESTAMP(tctf.created_start_date)) second) AS TIME))
        ) SECOND) AS TIME) as `total`,
      --  CAST(DATE_ADD('1900-01-01 00:00:00.000', INTERVAL (UNIX_TIMESTAMP(tctf.created_end_date) - UNIX_TIMESTAMP(tctf.created_start_date)) second) AS TIME) as `time`,
        CASE
          WHEN EXTRACT(DAY FROM tctf.created_start_date) BETWEEN 1 AND 10 THEN 1
          WHEN EXTRACT(DAY FROM tctf.created_start_date) BETWEEN 11 AND 20 THEN 2
          WHEN EXTRACT(DAY FROM tctf.created_start_date) BETWEEN 21 AND 30 THEN 3
          ELSE 4
        END AS 'weeks'
      FROM
        tr_concept_flow_header tcfh
      LEFT JOIN tr_concept_truck_flow tctf ON
        tcfh.id = tctf.concept_flow_header
      LEFT JOIN tr_vehicle_type_detail tvtd ON
        tvtd.vehicle_code_type = tcfh.vehicle_code_type
      LEFT JOIN tr_vehicle_type_group tvtg ON
        tvtg .id = tvtd.vehicle_group_id
      WHERE tcfh.workflow_id IN (6)
      AND tctf.area = ?
      AND tctf.created_start_date IS NOT NULL
      AND MONTH(tctf.created_start_date) = ?
      AND YEAR(tctf.created_start_date) = ?
      GROUP BY weeks, urut, vehicle_code
    ) t
    GROUP BY reg_vehicle_type
    ";

    return DB::select(DB::raw($sql), [
      $request->input('area'),
      date('m', strtotime(str_replace('/', '-', '01/' . $request->input('periode')))),
      date('Y', strtotime(str_replace('/', '-', '01/' . $request->input('periode')))),
    ]);
  }
}
