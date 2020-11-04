<?php

namespace App\Http\Controllers\Web;

use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;

class ConceptIssueController extends Controller
{
  public function index(Request $request)
  {
    return view('web.report.concept-issue.index');
  }

  public function export(Request $request)
  {
    $data['graph'] = $this->getGraph($request);

    $view_print = view('web.report.report-concept-coming-vs-actual-loading.print', $data);
    $title      = 'Concept Issue';

    if ($request->input('filetype') == 'html') {

      // request HTML View
      return $view_print;

    } elseif ($request->input('filetype') == 'xls') {

      // Request FILE EXCEL
      $reader      = new \PhpOffice\PhpSpreadsheet\Reader\Html();
      $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

      $spreadsheet = $reader->loadFromString($view_print, $spreadsheet);

      // Set warna background putih
      $spreadsheet->getDefaultStyle()->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('ffffff');
      // Set Font
      $spreadsheet->getDefaultStyle()->getFont()->setName('courier New');

      // Atur lebar kolom
      $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(15);
      $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(15);
      $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(15);
      $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(15);
      $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(15);
      $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(15);
      $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(15);
      $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(15);

      $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment; filename="' . $title . '.xls"');

      $writer->save("php://output");

    } else if ($request->input('filetype') == 'pdf') {

      // REQUEST PDF
      $mpdf = new \Mpdf\Mpdf(['tempDir' => '/tmp']);

      $mpdf->WriteHTML($view_print, \Mpdf\HTMLParserMode::HTML_BODY);

      $mpdf->Output($title . '.pdf', "D");

    } else {
      // Parameter filetype tidak valid / tidak ditemukan return 404
      return redirect(404);
    }
  }

  public function getGraph(Request $request)
  {
    $data = $this->getData($request);

    $datay1  = [];
    $datay2  = [];
    $datay3  = [];
    $datay4  = [];
    $xLegend = [
      '8 AM - 12 PM',
      '1 PM - 4 PM',
      '5 PM - 9 PM',
      '10 PM - 1 AM'
    ];

    $total1 = 0;
    $total2 = 0;
    $total3 = 0;
    $total4 = 0;

    foreach ($data as $key => $value) {
      $total1 += $value->i;
      $total2 += $value->ii;
      $total3 += $value->iii;
      $total4 += $value->iv;

    }

    foreach ($data as $key => $value) {
      $datay1[] = ($total1 == 0) ? 0 : round($value->i / $total1 * 100, 2);
      $datay2[] = ($total2 == 0) ? 0 : round($value->ii / $total2 * 100, 2);
      $datay3[] = ($total3 == 0) ? 0 : round($value->iii / $total3 * 100, 2);
      $datay4[] = ($total4 == 0) ? 0 : round($value->iv / $total4 * 100, 2);

      $xLegend[] = $value->category;
    }

    // return $datay2;

    // new Graph\Graph with a drop shadow
    $__width  = 1200;
    $__height = 800;
    $graph    = new Graph\Graph($__width, $__height);
    $graph->SetShadow();
    $graph->SetMargin(120, 100, 100, 100);

    // Use a "text" X-scale
    $graph->SetScale('textlin');

    // Set title and subtitle
    $graph->title->SetFont(FF_ARIAL, FS_BOLD, 20);
    $graph->title->Set('Concept Issue (%) - ' . $request->input('area'));

    // Create the bar plots
    $b1plot = new Plot\BarPlot($datay1);
    $b1plot->SetFillColor('orange');
    $b1plot->setLegend($xLegend[0]);
    $b1plot->value->Show();
    $b1plot->value->SetFont(FF_ARIAL, FS_NORMAL, 12);
    $b1plot->value->SetFormat('%01.2f%%');
    $b1plot->value->SetColor('darkred');

    $b2plot = new Plot\BarPlot($datay2);
    $b2plot->SetFillColor('blue');
    $b2plot->setLegend($xLegend[1]);
    $b2plot->value->Show();
    $b2plot->value->SetFont(FF_ARIAL, FS_NORMAL, 12);
    $b2plot->value->SetFormat('%01.2f%%');
    $b2plot->value->SetColor('darkred');

    $b3plot = new Plot\BarPlot($datay3);
    $b3plot->SetFillColor('red');
    $b3plot->setLegend($xLegend[2]);
    $b3plot->value->Show();
    $b3plot->value->SetFont(FF_ARIAL, FS_NORMAL, 12);
    $b3plot->value->SetFormat('%01.2f%%');
    $b3plot->value->SetColor('darkred');

    $b4plot = new Plot\BarPlot($datay4);
    $b4plot->SetFillColor('green');
    $b4plot->setLegend($xLegend[3]);
    $b4plot->value->Show();
    $b4plot->value->SetFont(FF_ARIAL, FS_NORMAL, 12);
    $b4plot->value->SetFormat('%01.2f%%');
    $b4plot->value->SetColor('darkred');

    // Create the grouped bar plot
    $gbplot = new Plot\GroupBarPlot([$b1plot, $b2plot, $b3plot, $b4plot]);
    $gbplot->SetWidth(0.9);

    // ...and add it to the graPH
    $graph->Add($gbplot);

    $datax = [
      'Date 1 to 10',
      'Date 11 to 20',
      'Date 21 to 25',
      'Date 26 to 31',
    ];

    $graph->xaxis->SetTickLabels($datax);
    $graph->xaxis->SetFont(FF_ARIAL, FS_NORMAL, 14);
    $graph->xaxis->SetColor('darkblue', 'black');

    $graph->yaxis->SetLabelFormat('%01.2f%%');
    $graph->yaxis->SetFont(FF_ARIAL, FS_NORMAL, 14);

    $graph->legend->SetFrameWeight(2);
    $graph->legend->SetColumns(10);
    $graph->legend->SetColor('#4E4E4E', '#00A78A');

    // The order the plots are added determines who's ontop
    // $graph->Add($b1);

    // Finally output the  image
    return $graph;
  }

  protected function getData($request)
  {
    $sql = "
    SELECT
      urut,
      category,
      SUM(IF(weeks = 1, total, 0)) AS i,
      SUM(IF(weeks = 2, total, 0)) AS ii,
      SUM(IF(weeks = 3, total, 0)) AS iii,
      SUM(IF(weeks = 4, total, 0)) AS iv
    FROM (
      SELECT
        area,
        YEAR(created_at) AS year,
        MONTH(created_at) AS month,
        EXTRACT(DAY FROM created_at) AS date,
        CASE
          WHEN EXTRACT(HOUR FROM created_at) >= 8 AND EXTRACT(HOUR FROM created_at) <= 12 THEN '8 AM - 12 PM'
          WHEN EXTRACT(HOUR FROM created_at) >= 13 AND EXTRACT(HOUR FROM created_at) <= 16 THEN '1 PM - 4 PM'
          WHEN EXTRACT(HOUR FROM created_at) >= 17 AND EXTRACT(HOUR FROM created_at) <= 21 THEN '5 PM - 9 PM'
          WHEN EXTRACT(HOUR FROM created_at) > 21 THEN '10 PM - 1 AM'
          WHEN EXTRACT(HOUR FROM created_at) <= 21 THEN '10 PM - 1 AM'
          ELSE ''
        END AS category,
        CASE
          WHEN EXTRACT(HOUR FROM created_at) >= 8 AND EXTRACT(HOUR FROM created_at) <= 12 THEN 1
          WHEN EXTRACT(HOUR FROM created_at) >= 13 AND EXTRACT(HOUR FROM created_at) <= 16 THEN 2
          WHEN EXTRACT(HOUR FROM created_at) >= 17 AND EXTRACT(HOUR FROM created_at) <= 21 THEN 3
          WHEN EXTRACT(HOUR FROM created_at) > 21 THEN 4
          WHEN EXTRACT(HOUR FROM created_at) <= 21 THEN 4
          ELSE ''
        END AS urut,
        CASE
          WHEN EXTRACT(DAY FROM created_at) BETWEEN 1 AND 10 THEN 1
          WHEN EXTRACT(DAY FROM created_at) BETWEEN 11 AND 20 THEN 2
          WHEN EXTRACT(DAY FROM created_at) BETWEEN 21 AND 25 THEN 3
          ELSE 4
        END AS weeks,
        SUM(quantity) AS total
      FROM tr_concept tc
      WHERE MONTH(tc.created_at) = ? AND YEAR(tc.created_at) = ? AND tc.area = ?
      GROUP BY WEEKDAY(created_at), YEAR(created_at), MONTH(created_at), EXTRACT(DAY FROM created_at),
      EXTRACT(hour FROM created_at), area,
      CASE
        WHEN EXTRACT(DAY FROM created_at) BETWEEN 1 AND 10 THEN 1
        WHEN EXTRACT(DAY FROM created_at) BETWEEN 11 AND 20 THEN 2
        WHEN EXTRACT(DAY FROM created_at) BETWEEN 21 AND 25 THEN 3
        ELSE 4
      END
    ) t
    GROUP BY category
    ORDER BY urut
    ";

    return DB::select(DB::raw($sql), [
      date('m', strtotime(str_replace('/', '-', '01/' . $request->input('periode')))),
      date('Y', strtotime(str_replace('/', '-', '01/' . $request->input('periode')))),
      $request->input('area'),
    ]);
  }
}
