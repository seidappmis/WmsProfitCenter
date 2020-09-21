<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\MasterCabang;
use Illuminate\Http\Request;

class ReportOccupancyController extends Controller
{
  public function index(Request $request)
  {
    $data['rs_branch'] = MasterCabang::select('kode_cabang', 'long_description')->get();

    return view('web.report.report-occupancy.index', $data);
  }

  public function export(Request $request)
  {
    // return view('web.report.report-occupancy.print');

    // $data['request'] = $request->all();
    // $data['header']  = LogReturnSuratTugasHeader::findOrFail($id);

    // $view_print = view('web.report.summary-wh-transporter-report.print', $data);
    $view_print = view('web.report.report-occupancy.print');
    $title      = 'Report Occupancy';

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
      $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(30);
      $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(15);
      $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(15);
      $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(10);
      $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(10);
      $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(10);
      $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(10);
      $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(10);
      $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(10);
      $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(10);
      $spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(10);
      $spreadsheet->getActiveSheet()->getColumnDimension('L')->setWidth(10);
      $spreadsheet->getActiveSheet()->getColumnDimension('M')->setWidth(10);
      $spreadsheet->getActiveSheet()->getColumnDimension('N')->setWidth(10);
      $spreadsheet->getActiveSheet()->getColumnDimension('O')->setWidth(10);
      $spreadsheet->getActiveSheet()->getColumnDimension('P')->setWidth(10);
      $spreadsheet->getActiveSheet()->getColumnDimension('Q')->setWidth(10);
      $spreadsheet->getActiveSheet()->getColumnDimension('R')->setWidth(10);
      $spreadsheet->getActiveSheet()->getColumnDimension('S')->setWidth(10);
      $spreadsheet->getActiveSheet()->getColumnDimension('T')->setWidth(10);
      $spreadsheet->getActiveSheet()->getColumnDimension('U')->setWidth(10);
    
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
