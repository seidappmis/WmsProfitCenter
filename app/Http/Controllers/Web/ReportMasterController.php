<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportMasterController extends Controller
{
  public function index(Request $request)
  {
    $reportView = $this->getReportView($request);

    $data['report_master_value'] = $request->input('report-master');
    $data['report_view_name']    = $reportView['name'];
    // $data['report_view_data'] = $reportView['data'];

    return view('web.report.report-master.index', $data);
  }

  public function getReportView($request)
  {
    $view['name'] = '';
    $view['data'] = '';

    switch ($request->input('report-master')) {
      case 'Master Cabang':
        $view['name'] = 'web.report.report-master._master_cabang';
        // $view['data'] = \App\Models\MasterCabang::all();
        break;

      default:
        # code...
        break;
    }
    return $view;
  }

  public function export(Request $request)
  {
    switch ($request->get('report-master')) {
      case 'Master Cabang':
        return $this->exportMasterCabang($request);
        break;

      default:
        # code...
        break;
    }
  }

  protected function exportMasterCabang($request)
  {
    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet       = $spreadsheet->getActiveSheet();

    $sheet->setCellValue('A1', 'KODE CUSTOMER');
    $sheet->setCellValue('B1', 'KODE CABANG');
    $sheet->setCellValue('C1', 'SHORT DESCRIPTION');
    $sheet->setCellValue('D1', 'LONG DESCRIPTION');
    $sheet->setCellValue('E1', 'TYPE');
    $sheet->setCellValue('F1', 'REGION');
    $sheet->getStyle('A1:F1')->applyFromArray(getPHPSpreadsheetTitleStyle());

    $data = \App\Models\MasterCabang::all();

    $row = 2;
    foreach ($data as $key => $cabang) {
      $sheet->setCellValue('A' . $row, $cabang->kode_customer);
      $sheet->setCellValue('B' . $row, $cabang->kode_cabang);
      $sheet->setCellValue('C' . $row, $cabang->short_description);
      $sheet->setCellValue('D' . $row, $cabang->long_description);
      $sheet->setCellValue('E' . $row, $cabang->type);
      $sheet->setCellValue('F' . $row, $cabang->region);
      $row++;
    }

    $sheet->getColumnDimension('A')->setAutoSize(true);
    $sheet->getColumnDimension('B')->setAutoSize(true);
    $sheet->getColumnDimension('C')->setAutoSize(true);
    $sheet->getColumnDimension('D')->setAutoSize(true);
    $sheet->getColumnDimension('E')->setAutoSize(true);
    $sheet->getColumnDimension('F')->setAutoSize(true);

    $title = $request->get('report-master');

    if ($request->input('file_type') == 'pdf') {
      $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Mpdf');
      header('Content-Type: application/pdf');
      header('Content-Disposition: attachment;filename="' . $title . '.pdf"');
      header('Cache-Control: max-age=0');
    } else {
      $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment; filename="' . $title . '.xls"');
    }

    $writer->save("php://output");
  }
}
