<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TaskNoticeController extends Controller
{
    //Export ST
  public function exportSt(Request $request, $id)
  {
    // $data['pickinglistHeader'] = PickinglistHeader::findOrFail($id);

    $view_print = view('web.return.task-notice._print_st');
    $title      = 'Task Notice ST';

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
      $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(5);
      $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(5);
      $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(5);
      $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(20);
      $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(5);
      $spreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(5);
      $spreadsheet->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('L')->setWidth(5);
      $spreadsheet->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('N')->setWidth(5);
      $spreadsheet->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('P')->setWidth(5);
      $spreadsheet->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);

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

  // ExportDoReturn
  public function exportDoReturn(Request $request, $id)
  {
    // $data['pickinglistHeader'] = PickinglistHeader::findOrFail($id);

    $view_print = view('web.return.task-notice._print_do_return');
    $title      = 'Task Notice DO Return';

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
      $spreadsheet->getDefaultStyle()->getFont()->setName('Arial');

      // Atur lebar kolom
      $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(10);
      $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(15);
      $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(5);
      $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(5);
      $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(5);
      $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(20);
      $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(5);
      $spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(15);
      $spreadsheet->getActiveSheet()->getColumnDimension('L')->setWidth(20);

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

}
