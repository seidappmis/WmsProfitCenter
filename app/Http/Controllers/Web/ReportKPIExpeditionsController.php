<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Amenadiel\JpGraph\Graph;
use Amenadiel\JpGraph\Plot;

class ReportKPIExpeditionsController extends Controller
{
  public function index(Request $request)
  {

    if ($request->ajax()) {
      $tabeldata = $this->getTableData($request);

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
    return view('web.report.report-kpi-expeditions.index');
  }

  public function export(Request $request)
  {
    $view_print = $this->getTableData($request);
    $title      = 'Report KPI Expedition';

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

      // // Atur lebar kolom
      $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);

      $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment; filename="' . $title . '.xls"');

      $writer->save("php://output");
    } else if ($request->input('filetype') == 'pdf') {

      // REQUEST PDF
      $mpdf = New \Mpdf\Mpdf(['tempDir'=>storage_path('tempdir')]);
      //$mpdf = new \Mpdf\Mpdf(['tempDir' => '/tmp']);

      $mpdf->WriteHTML($view_print, \Mpdf\HTMLParserMode::HTML_BODY);

      $mpdf->Output($title . '.pdf', "D");
    } else {
      // Parameter filetype tidak valid / tidak ditemukan return 404
      return redirect(404);
    }
  }

  protected function getTableData($request)
  {
    $year  = '';
    $month = '';

    if (!empty($request->input('periode'))) {
      $periode = Carbon::createFromFormat('d/m/Y', '01/' . $request->input('periode'));

      $year  = $periode->format('Y');
      $month = $periode->format('m');
    }

    $query = DB::select("
        SELECT
        c.expedition_name,
        COUNT(delivery_no) AS sum_of_concept,
        IF(ISNULL(achieve), 0, achieve) AS achieve,
        (COUNT(delivery_no) - IF(ISNULL(achieve), 0, achieve)) AS non_achive
        FROM tr_concept c
        LEFT JOIN(
          SELECT
          tc.expedition_name,
          COUNT(tc.delivery_no) AS achieve,
           tc.`created_at`, t.`complete_date`
          FROM tr_concept tc
          LEFT JOIN (
            SELECT
            fd.`invoice_no`, fd.`delivery_no`, fd.`delivery_items`, tf.complete_date
            FROM tr_concept_flow_detail fd
            LEFT JOIN tr_concept_truck_flow tf ON fd.`id_header` = tf.`concept_flow_header`
            WHERE YEAR(tf.complete_date) = ? AND MONTH(tf.complete_date) = ? AND tf.`area` = ?
          ) t ON t.invoice_no = tc.`invoice_no` AND t.delivery_no = tc.`delivery_no` AND tc.`delivery_items` = t.delivery_items AND (TIMESTAMPDIFF(DAY, tc.`created_at`, t.`complete_date`) > 2)
          WHERE tc.expedition_id IS NOT NULL AND YEAR(tc.created_at) = ? AND MONTH(tc.created_at) = ? AND tc.`area` = ? AND t.invoice_no IS NOT NULL
          GROUP BY tc.`expedition_name`
        ) ct ON ct.expedition_name = c.`expedition_name`
        WHERE YEAR(c.created_at) = ? AND MONTH(c.created_at) = ? AND c.`area` = ?
        GROUP BY c.`expedition_name`
        ORDER BY c.`expedition_name`
        ", [
      $year,
      $month,
      $request->input('area'),
      $year,
      $month,
      $request->input('area'),
      $year,
      $month,
      $request->input('area'),
    ]);


    $tabeldata = '';
    $tabeldata .= '<div style="text-align: center; font-size: 14pt;"><strong>Fleet Capablility - Area : ' . $request->input('area') . ' (' . date('Y-m-d H:i:s') . ')</strong></div>';

    if (count($query) !== 0) {
      $graph = $this->getGraph($query);
	  //$graph->Stroke();
	  //die;
      ob_start();
      imagepng($graph->Stroke(_IMG_HANDLER));
      $imageData = ob_get_contents();
      ob_end_clean();
	  if($request->input('filetype') == 'xls'){
		  /*
		  $file = tmpfile();
		  $path = stream_get_meta_data($file)['uri'];
		  fwrite($file, $imageData);
		  */
		  $deletetime = time() - (86400/2);

		  $dir = '/tmp';
		  $prefix = 'wms-report-kpi';

		  if($handle = opendir($dir)){
			  while (false != ($file = readdir($handle))){
				  if((filetype("$dir/$file") == 'file')
				  && (str_starts_with($file, $prefix))
				  && (filemtime("$dir/$file") < $deletetime)){
					  unlink("$dir/$file");
				  }
			  }
			  closedir($handle);
		  }

		  $path = tempnam($dir, $prefix);
		  file_put_contents($path, $imageData);
		  $tabeldata .= '<img src="' . $path . '" style="width: 100%;" />';
	  }else{
		$tabeldata .= '<img src="data:image/png;base64,' . base64_encode($imageData) . '" style="width: 100%;" />';
	  }
	  //$tabeldata .= '<img src="/home/kurnia/afedigi_project/wms-sharp/storage/app/public/do-manifest/files/6041097abf5a7.png" style="width: 100%;" />';
    }

    $tabeldata .= '<table>';
    $tabeldata .= '<tr>';
    $tabeldata .= '<th style="text-align: center;">EXPEDITION NAME</th>';
    $tabeldata .= '<th style="text-align: center;">Acheive</th>';
    $tabeldata .= '<th style="text-align: center;">Non Achieve</th>';
    $tabeldata .= '<th style="text-align: center;">Sum Of Concept</th>';
    $tabeldata .= '<th style="text-align: center;" colspan="2">(%)</th>';
    $tabeldata .= '<th style="text-align: center;">Total</th>';
    $tabeldata .= '</tr>';

    foreach ($query as $key => $value) {
      $tabeldata .= '<tr>';
      $tabeldata .= '<td>' . $value->expedition_name . '</td>';
      $tabeldata .= '<td>' . $value->achieve . '</td>';
      $tabeldata .= '<td>' . $value->non_achive . '</td>';
      $tabeldata .= '<td>' . $value->sum_of_concept . '</td>';
      $tabeldata .= '<td>' . round($value->non_achive / $value->sum_of_concept * 100, 2) . ' %</td>';
      $tabeldata .= '<td>' . round($value->achieve / $value->sum_of_concept * 100, 2) . ' %</td>';
      $tabeldata .= '<td>' . round($value->sum_of_concept / $value->sum_of_concept * 100, 2) . ' %</td>';
      $tabeldata .= '</tr>';
    }

    $tabeldata .= '</table>';

    return $tabeldata;
  }

  protected function getGraph($data)
  {
    // print_r($data);
    $datayAchive = [];
    $datayNonAchive = [];
    $dataySumOFConcept = [];
    $lbl = [];
    foreach ($data as $key => $value) {
      $lbl[] = $value->expedition_name;
      $datayAchive[] = $value->achieve;
      $datayNonAchive[] = $value->non_achive;
      $dataySumOFConcept[] = $value->sum_of_concept;
    }

    // Size of graph
    $__width  = 1200;
    $__height = 800;

    // Set the basic parameters of the graph
    $graph = new Graph\Graph($__width, $__height, 'auto');
    $graph->SetScale('textlin');

    $top    = 50;
    $bottom = 110;
    $left   = 150;
    $right  = 20;
    $graph->SetMarginColor('white');
    $graph->SetScale('textlin');
    $graph->SetMargin(70, 50, 30, 5);
    // $graph->Set90AndMargin($left, $right, $top, $bottom);

    // Nice shadow
    $graph->SetShadow();

    $graph->xaxis->SetTickLabels($lbl);

    // Label align for X-axis
    // $graph->xaxis->SetLabelAlign('right', 'center', 'right');

    // // Label align for Y-axis
    // $graph->yaxis->SetLabelAlign('center', 'bottom');

    // Titles
    // $graph->title->Set('Number of incidents');

    // Create a bar pot
    $bplot = new Plot\BarPlot($datayAchive);
    $bplot->SetFillColor('blue');
    $bplot->SetLegend('Achive');
    $bplot->SetWidth(0.1);
    $b2plot = new Plot\BarPlot($datayNonAchive);
    $b2plot->SetFillColor('orange');
    $b2plot->SetLegend('Non Achive');
    $b2plot->SetWidth(0.1);
    $b3plot = new Plot\BarPlot($dataySumOFConcept);
    $b3plot->SetFillColor('gray');
    $b3plot->SetLegend('SumOfConcept');
    $b3plot->SetWidth(0.1);
    // $bplot->SetWidth(0.5);
    // $bplot->SetYMin(1990);
    $gbplot = new Plot\GroupBarPlot([$bplot, $b2plot, $b3plot]);

    $graph->Add($gbplot);
    $graph->xaxis->SetLabelAngle(90);
    $graph->legend->SetPos(0.5, 0.01, 'center', 'top');

    // $graph->Stroke();

    return $graph;
  }
  
}
