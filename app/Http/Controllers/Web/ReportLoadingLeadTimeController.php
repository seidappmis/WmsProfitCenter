<?php

namespace App\Http\Controllers\Web;

use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;
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

  public function cbFmtPercentage($aVal)
  {
    return sprintf('%.1f%%', 100 * $aVal); // Convert to string
  }

  public function getGraph(Request $request)
  {
    $loadingLeadTime = $this->getLoadingLeadTime($request);

    $datay1  = [];
    $datay2  = [];
    $datay3  = [];
    $datay4  = [];
    $datay5  = [];
    $xLegend = [];

    foreach ($loadingLeadTime as $key => $value) {
      $datay1[] = getSecondFromTime($value->i);
      $datay2[] = getSecondFromTime($value->ii);
      $datay3[] = getSecondFromTime($value->iii);
      $datay4[] = getSecondFromTime($value->iv);
      $datay5[] = 100;

      $xLegend[] = $value->reg_vehicle_type;
    }

    // return $datay3;

    // Setup the graph
    $__width  = 1200;
    $__height = 800;
    $graph    = new Graph\Graph($__width, $__height);

    $graph->SetMarginColor('white');
    $graph->SetScale('textlin');
    $graph->SetFrame(false);
    $graph->SetMargin(100, 100, 100, 100);

    $graph->title->Set('Loading Lead Time - ' . $request->input('area'));
    $graph->subtitle->Set('Month/Year - ' . $request->input('periode'));

    $graph->yaxis->HideZeroLabel();
    $graph->ygrid->SetFill(true, '#EFEFEF@0.5', '#BBCCFF@0.5');
    // $graph->yaxis->SetLabelFormatCallback('cbFmtPercentage');

    $graph->xgrid->Show();
    $graph->xaxis->SetLabelAngle(90);

    $graph->xaxis->SetTickLabels($xLegend);

    // Create the first line
    $p1 = new Plot\LinePlot($datay1);
    $p1->SetColor('blue');
    $p1->SetLegend('I (1-10)');
    $graph->Add($p1);

    // Create the second line
    $p2 = new Plot\LinePlot($datay2);
    $p2->SetColor('orange');
    $p2->SetLegend('II (11-20)');
    $graph->Add($p2);

    // Create the third line
    $p3 = new Plot\LinePlot($datay3);
    $p3->SetColor('red');
    $p3->SetLegend('III (21-25)');
    $graph->Add($p3);

    $p4 = new Plot\LinePlot($datay4);
    $p4->SetColor('green');
    $p4->SetLegend('IV (26-31)');
    $graph->Add($p4);

    $p5 = new Plot\LinePlot($datay5);
    $p5->SetColor('gray');
    $p5->SetLegend('NORMAL TIME');
    $graph->Add($p5);

    $graph->legend->SetShadow('gray@0.4', 5);
    $graph->legend->SetPos(0.1, 0.1, 'center', 'bottom');
    // Output line
    $graph->Stroke();

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
          WHEN EXTRACT(DAY FROM tctf.created_start_date) BETWEEN 21 AND 25 THEN 3
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
