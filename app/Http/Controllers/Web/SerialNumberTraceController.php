<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\LMBDetail;
use DataTables;
use Illuminate\Http\Request;

class SerialNumberTraceController extends Controller
{
  public function index(Request $request)
  {
    if ($request->ajax()) {
      $query = LMBDetail::getSerialNumberTrace($request)
      ;

      $datatables = DataTables::of($query);

      return $datatables->make(true);
    }

    return view('web.report.serial-number-trace.index');
  }

  public function export(Request $request)
  {
    $query = LMBDetail::getSerialNumberTrace($request)
      ->get()
    ;

    $reader      = new \PhpOffice\PhpSpreadsheet\Reader\Html();
    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

    foreach ($query as $key => $value) {
      $reader->setSheetIndex($key);

      // echo $value->username . '<br>';
      $spreadsheet = $reader->loadFromString($this->getSerialNumberTraceTable($value), $spreadsheet);

      $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
    }

    $title = 'SerialNumberTrace';

    if ($request->input('file_type') == 'pdf') {
      $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Mpdf');
      header('Content-Type: application/pdf');
      header('Content-Disposition: attachment;filename="' . $title . '.pdf"');
      header('Cache-Control: max-age=0');
    } else {
      $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment; filename="' . $title . '.xls"');
    }

    $writer->save("php://output");
  }

  protected function getSerialNumberTraceTable($data)
  {

    $table = '';
    $table .= '<table  style="border-collapse: collapse; border: 1px solid black; width: 210mm;">';

    $table .= '<tr style="border: 1px solid black;">';
    $table .= '<th style="text-align: center; border: 1px solid black;">Serial Number</th>';
    $table .= '<th style="text-align: center; border: 1px solid black;">Model</th>';
    $table .= '<th style="text-align: center; border: 1px solid black;">EAN</th>';
    $table .= '<th style="text-align: center; border: 1px solid black;">Date of LMB</th>';
    $table .= '<th style="text-align: center; border: 1px solid black;">Manifest No</th>';
    $table .= '<th style="text-align: center; border: 1px solid black;">Delivery Date</th>';
    $table .= '<th style="text-align: center; border: 1px solid black;">Arrival Date</th>';
    $table .= '<th style="text-align: center; border: 1px solid black;">From</th>';
    $table .= '<th style="text-align: center; border: 1px solid black;">Ship to</th>';
    $table .= '</tr>';

    $table .= '<tr style="border: 1px solid black;">';
    $table .= '<td style="border: 1px solid black;">' . $data->serial_number . '</td>';
    $table .= '<td style="border: 1px solid black;">' . $data->model . '</td>';
    $table .= '<td style="border: 1px solid black;">' . $data->ean_code . '</td>';
    $table .= '<td style="border: 1px solid black;">' . $data->lmb_date . '</td>';
    $table .= '<td style="border: 1px solid black;">' . $data->do_manifest_no . '</td>';
    $table .= '<td style="border: 1px solid black;">' . $data->created_at . '</td>';
    $table .= '<td style="border: 1px solid black;">' . $data->actual_time_arrival . '</td>';
    $table .= '<td style="border: 1px solid black;">' . $data->from . '</td>';
    $table .= '<td style="border: 1px solid black;">' . $data->kode_customer . '</td>';
    $table .= '</tr>';

    $table .= '</table>';

    return $table;
  }
}
