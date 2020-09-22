<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SummaryWHTransporterReportController extends Controller
{
  public function index(Request $request)
  {
    return view('web.report.summary-wh-transporter-report.index');
  }

  public function export(Request $request)
  {
    // return view('web.report.summary-wh-transporter-report.print');

    // $data['request'] = $request->all();
    // $data['header']  = LogReturnSuratTugasHeader::findOrFail($id);

    // $view_print = view('web.report.summary-wh-transporter-report.print', $data);
    $view_print = view('web.report.summary-wh-transporter-report.print');
    $title      = 'Summary WH Transporter Report';

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
  // }
  }
}
