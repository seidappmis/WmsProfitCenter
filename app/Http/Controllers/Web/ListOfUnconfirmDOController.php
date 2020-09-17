<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\LogManifestDetail;
use DB;
use Illuminate\Http\Request;

class ListOfUnconfirmDOController extends Controller
{
  public function index(Request $request)
  {
    $data = $this->getListOfUnconfirmDOData();

    return view('web.invoicing.list-of-unconfirm-do.index', $data);
  }

  public function exportToExcel()
  {
    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet       = $spreadsheet->getActiveSheet();

    $sheet->setCellValue('A1', 'SHIPMENT NO');
    $sheet->setCellValue('B1', 'DELIVERY NO');
    $sheet->setCellValue('C1', 'DO INTERNAL');
    $sheet->setCellValue('D1', 'MODEL');
    $sheet->setCellValue('E1', 'QUANTITY');
    $sheet->setCellValue('F1', 'CBM TOTAL');
    $sheet->setCellValue('G1', 'CUSTOMER');
    $sheet->setCellValue('H1', 'CITY SHIP TO');
    $sheet->setCellValue('I1', 'DO TYPE');
    $sheet->setCellValue('J1', 'ETD');
    $sheet->setCellValue('K1', 'ETA');
    $sheet->setCellValue('L1', 'LEAD TIME');
    $sheet->getStyle('A1:L1')->applyFromArray(getPHPSpreadsheetTitleStyle());

    $data = $this->getListOfUnconfirmDOData();

    $row = 2;

    foreach ($data['rs_unconfirmManifesDetail'] as $key => $unconfirmManifest) {
      $manifestTitle = $unconfirmManifest['manifest']->do_manifest_no . ' - ' . $unconfirmManifest['manifest']->expedition_name . ' - ' . $unconfirmManifest['manifest']->city_name;
      $sheet->setCellValue('A' . $row, $manifestTitle);
      $sheet->mergeCells('A' . $row . ':L' . $row);
      $spreadsheet->getActiveSheet()->getStyle('A' . $row)->applyFromArray(getPHPSpreadsheetGroupTitleStyle());
      $row++;

      foreach ($unconfirmManifest['detail'] as $key => $detail) {
        $sheet->setCellValue('A' . $row, $detail->invoice_no);
        $sheet->setCellValue('B' . $row, $detail->delivery_no);
        $sheet->setCellValue('C' . $row, $detail->do_internal);
        $sheet->setCellValue('D' . $row, $detail->model);
        $sheet->setCellValue('E' . $row, $detail->quantity);
        $sheet->setCellValue('F' . $row, $detail->cbm);
        $sheet->setCellValue('G' . $row, $detail->ship_to);
        $sheet->setCellValue('H' . $row, $detail->city_name);
        $sheet->setCellValue('I' . $row, $detail->do_type);
        $sheet->setCellValue('J' . $row, $detail->do_manifest_date);
        $sheet->setCellValue('K' . $row, $detail->do_manifest_date);
        $sheet->setCellValue('L' . $row, $detail->lead_time);
        $row++;
      }
    }

    $sheet->getColumnDimension('A')->setAutoSize(true);
    $sheet->getColumnDimension('B')->setAutoSize(true);
    $sheet->getColumnDimension('C')->setAutoSize(true);
    $sheet->getColumnDimension('D')->setAutoSize(true);
    $sheet->getColumnDimension('E')->setAutoSize(true);
    $sheet->getColumnDimension('F')->setAutoSize(true);
    $sheet->getColumnDimension('G')->setAutoSize(true);
    $sheet->getColumnDimension('H')->setAutoSize(true);
    $sheet->getColumnDimension('I')->setAutoSize(true);
    $sheet->getColumnDimension('J')->setAutoSize(true);
    $sheet->getColumnDimension('K')->setAutoSize(true);
    $sheet->getColumnDimension('L')->setAutoSize(true);

    $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

    $title = 'UnconfirmDO_All_' . date('d_m_Y H_i_s');

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $title . '.xls"');

    $writer->save("php://output");

  }

  protected function getListOfUnconfirmDOData()
  {
    $unconfirmManifesDetail = LogManifestDetail::select(
      'log_manifest_detail.*',
      'log_manifest_header.do_manifest_date',
      'log_manifest_header.city_name',
      DB::raw('CASE WHEN log_manifest_detail.do_return = 1 THEN "RETURN" ELSE "NORMAL" END AS do_type')
    )
      ->leftjoin('log_manifest_header', 'log_manifest_header.do_manifest_no', '=', 'log_manifest_detail.do_manifest_no')
      ->where('log_manifest_header.status_complete', 1)
      ->where('log_manifest_detail.status_confirm', 0)
      ->where('log_manifest_header.area', auth()->user()->area)
      ->orderBy('log_manifest_header.do_manifest_no')
      ->get()
    ;

    $rs_unconfirmManifesDetail = [];
    foreach ($unconfirmManifesDetail as $key => $value) {
      $rs_unconfirmManifesDetail[$value->do_manifest_no]['manifest'] = $value;
      $rs_unconfirmManifesDetail[$value->do_manifest_no]['detail'][] = $value;
    }

    $data['unconfirmManifesDetail']    = $unconfirmManifesDetail;
    $data['rs_unconfirmManifesDetail'] = $rs_unconfirmManifesDetail;

    return $data;
  }
}
