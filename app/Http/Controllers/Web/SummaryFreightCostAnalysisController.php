<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\LogManifestHeader;
use DataTables;
use DB;
use Illuminate\Http\Request;

class SummaryFreightCostAnalysisController extends Controller
{
  public function index(Request $request)
  {

    if ($request->ajax()) {
      $query = $this->getData($request);

      $datatables = DataTables::of($query)
      ;

      return $datatables->make(true);
    }

    return view('web.invoicing.summary-freight-cost-analysis.index');
  }

  public function export(Request $request)
  {
    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet       = $spreadsheet->getActiveSheet();

    $col = 'A';
    $sheet->setCellValue(($col++) . '1', 'ReceiptID');
    $sheet->setCellValue(($col++) . '1', 'ReceiptNum');
    $sheet->setCellValue(($col++) . '1', 'Invoice Number');
    $sheet->setCellValue(($col++) . '1', 'ReceiptDate');
    $sheet->setCellValue(($col++) . '1', 'Amount');
    $sheet->setCellValue(($col++) . '1', 'Status');
    $sheet->setCellValue(($col++) . '1', 'Bulan');
    $sheet->setCellValue(($col++) . '1', 'ACC Code');
    $sheet->setCellValue(($col++) . '1', 'Kode Cabang');
    $sheet->setCellValue(($col++) . '1', 'Code Sales');
    $sheet->setCellValue(($col++) . '1', 'Expedition Code');
    $sheet->setCellValue(($col++) . '1', 'DO Manifest No');
    $sheet->setCellValue(($col++) . '1', 'DO Manifest Date');
    $sheet->setCellValue(($col++) . '1', 'Expedition Name');
    $sheet->setCellValue(($col++) . '1', 'Vehicle Description');
    $sheet->setCellValue(($col++) . '1', 'Destination Manifest');
    $sheet->setCellValue(($col++) . '1', 'Delivery No');
    $sheet->setCellValue(($col++) . '1', 'DO Date');
    $sheet->setCellValue(($col++) . '1', 'MODEL');
    $sheet->setCellValue(($col++) . '1', 'Total CBM DO');
    $sheet->setCellValue(($col++) . '1', 'Qty');
    $sheet->setCellValue(($col++) . '1', 'Base Cost Ritase');
    $sheet->setCellValue(($col++) . '1', 'Base Cost CBM');
    $sheet->setCellValue(($col++) . '1', 'Total CBM Truck');
    $sheet->setCellValue(($col++) . '1', 'Total Freight Cost');
    $sheet->setCellValue(($col++) . '1', 'Ritase2');
    $sheet->setCellValue(($col++) . '1', 'Multidrop');
    $sheet->setCellValue(($col++) . '1', 'Unloading');
    $sheet->setCellValue(($col++) . '1', 'Overstay');
    $sheet->setCellValue(($col++) . '1', 'Ship To Code');
    $sheet->setCellValue(($col++) . '1', 'Ship To');
    $sheet->setCellValue(($col) . '1', 'Region');

    // getPHPSpreadsheetTitleStyle() ada di wms Helper
    $sheet->getStyle('A1:' . ($col) . '1')->applyFromArray(getPHPSpreadsheetTitleStyle());

    $data = $this->getData($request)
    ;

    $row = 2;
    foreach ($data as $key => $value) {
      $col = 'A';
      $sheet->setCellValue(($col++) . $row, $value->invoice_receipt_id);
      $sheet->setCellValue(($col++) . $row, $value->invoice_receipt_no);
      $sheet->setCellValue(($col++) . $row, $value->kwitansi_no);
      $sheet->setCellValue(($col++) . $row, $value->invoice_receipt_date);
      $sheet->setCellValue(($col++) . $row, $value->amount_after_tax);
      $sheet->setCellValue(($col++) . $row, $value->manifest_type);
      $sheet->setCellValue(($col++) . $row, $value->month);
      $sheet->setCellValue(($col++) . $row, $value->acc_code);
      $sheet->setCellValue(($col++) . $row, $value->kode_cabang);
      $sheet->setCellValue(($col++) . $row, $value->code_sales);
      $sheet->setCellValue(($col++) . $row, $value->expedition_code);
      $sheet->setCellValue(($col++) . $row, $value->do_manifest_no);
      $sheet->setCellValue(($col++) . $row, $value->do_manifest_date);
      $sheet->setCellValue(($col++) . $row, $value->expedition_name);
      $sheet->setCellValue(($col++) . $row, $value->vehicle_description);
      $sheet->setCellValue(($col++) . $row, $value->destination_manifest);
      $sheet->setCellValue(($col++) . $row, $value->delivery_no);
      $sheet->setCellValue(($col++) . $row, $value->do_date);
      $sheet->setCellValue(($col++) . $row, $value->model);
      $sheet->setCellValue(($col++) . $row, $value->total_cbm_do);
      $sheet->setCellValue(($col++) . $row, $value->qty);
      $sheet->setCellValue(($col++) . $row, $value->base_cost_ritase);
      $sheet->setCellValue(($col++) . $row, $value->base_cost_cbm);
      $sheet->setCellValue(($col++) . $row, $value->total_cbm_truck);
      $sheet->setCellValue(($col++) . $row, $value->total_freight_cost);
      $sheet->setCellValue(($col++) . $row, $value->ritase2);
      $sheet->setCellValue(($col++) . $row, $value->multidrop);
      $sheet->setCellValue(($col++) . $row, $value->unloading);
      $sheet->setCellValue(($col++) . $row, $value->overstay);
      $sheet->setCellValue(($col++) . $row, $value->ship_to_code);
      $sheet->setCellValue(($col++) . $row, $value->ship_to);
      $sheet->setCellValue(($col++) . $row, $value->region);
      $row++;
    }

    $sheet->getColumnDimension('A')->setAutoSize(true);
    $sheet->getColumnDimension('B')->setAutoSize(true);
    $sheet->getColumnDimension('C')->setAutoSize(true);
    $sheet->getColumnDimension('D')->setAutoSize(true);
    $sheet->getColumnDimension('E')->setAutoSize(true);
    $sheet->getColumnDimension('F')->setAutoSize(true);

    $title = 'Summary Freight Cost Analysis ' . $request->input('area');

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

  public function getData($request)
  {

    $log_manifest_header = LogManifestHeader::select(
      'log_manifest_header.do_manifest_no'
      // DB::raw('GROUP_CONCAT(DISTINCT QUOTE(log_manifest_header.do_manifest_no)) AS in_do_manifest_no')
    )
      ->whereNotNull('log_manifest_header.expedition_code')
      ->whereBetween('log_manifest_header.do_manifest_date', [$request->input('start_date'), $request->input('end_date')])
    ;

    if ($request->input('expedition_code') != 'All') {
      $log_manifest_header->where('log_manifest_header.expedition_code', $request->input('expedition_code'));
    }

    if (!empty($request->input('do_manifest_no'))) {
      $log_manifest_header->where('log_manifest_header.do_manifest_no', $request->input('do_manifest_no'));
    }

    if (!empty($request->input('invoice_receipt_id'))) {
      $log_manifest_header
        ->leftjoin('log_invoice_receipt_detail', 'log_invoice_receipt_detail.do_manifest_no', '=', 'log_manifest_header.do_manifest_no')
        ->leftjoin('log_invoice_receipt_header', 'log_invoice_receipt_detail.id_header', '=', 'log_invoice_receipt_header.id')
        ->where('log_invoice_receipt_header.invoice_receipt_id', $request->input('invoice_receipt_id'));
    }

    if (!empty($request->input('city_code'))) {
      $log_manifest_header
        ->leftjoin('log_manifest_detail', 'log_manifest_detail.do_manifest_no', '=', 'log_manifest_header.do_manifest_no')
        ->where('log_manifest_detail.city_code', $request->input('city_code'));
    }

    $rs_do_manifest_no = [];
    foreach ($log_manifest_header->get() as $key => $value) {
      $rs_do_manifest_no[] = "'" . $value->do_manifest_no . "'";
    }

    $str_do_manifest_no = implode(',', $rs_do_manifest_no);
    // $str_do_manifest_no = $log_manifest_header->first()->in_do_manifest_no;

    // echo $str_do_manifest_no;
    // return $str_do_manifest_no;

    if (empty($str_do_manifest_no)) {
      $str_do_manifest_no = '1';
    }

    // $str_do_manifest_no = "'JKT-201013-003','JKT-201013-004','JKT-201020-006','JKT-201020-007','JKT-201020-009','JKT-201020-010','JKT-201021-001','JKT-201021-003','JKT-201021-004','JKT-201026-001','JKT-201026-002','JKT-201026-008','JKT-201026-009','JKT-201026-010','JKT-201027-006','KRW-201020-003'";

    $sqlSummary = "SELECT
        MAX(lirh.invoice_receipt_id) AS invoice_receipt_id
        , lirh.invoice_receipt_no
        , lirh.kwitansi_no
        , lirh.invoice_receipt_date
        , lirh.amount_after_tax
        , lmh.manifest_type
        , MONTH(lmh.do_manifest_date) AS `month`
        , lmh.expedition_code
        , lmh.do_manifest_no
        , lmh.do_manifest_date
        , lmh.expedition_name
        , lmh.vehicle_description
        , lmh.city_name AS destination_manifest
        , lmd.delivery_no
        , lmd.model
        , lmd.do_date
        , SUM(lmd.cbm) AS total_cbm_do
        , SUM(lmd.quantity) as qty
        , lfc.ritase AS base_cost_ritase
        , lfc.cbm AS base_cost_cbm
        , lmh_sum.cbm_truck AS total_cbm_truck
        , CASE
          WHEN lfc.cbm = 0 THEN (lfc.ritase / lmh_sum.cbm_truck) * SUM(lmd.cbm)
          WHEN lfc.ritase = 0 THEN (lfc.cbm * SUM(lmd.cbm))
          ELSE 0
        END AS total_freight_cost
        , SUM(IF(lird.ritase2_amount IS NULL, 0, lird.ritase2_amount)) AS ritase2
        , SUM(IF(lird.multidro_amount IS NULL, 0, lird.multidro_amount)) AS multidrop
        , SUM(IF(lird.unloading_amount IS NULL, 0, lird.unloading_amount)) AS unloading
        , SUM(IF(lird.overstay_amount IS NULL, 0, lird.overstay_amount)) AS overstay
        , lmd.region
        , lmd.code_sales
        , lmd.kode_cabang
        , MAX(lird.acc_code) AS acc_code
        , lmd.ship_to_code
        , lmd.ship_to
      FROM log_manifest_detail lmd
      LEFT JOIN log_manifest_header lmh ON lmh.do_manifest_no = lmd.do_manifest_no
      LEFT JOIN (
        SELECT
          lmd2.do_manifest_no
          , SUM(lmd2.cbm) AS cbm_truck
        FROM log_manifest_detail lmd2
        WHERE do_manifest_no IN ($str_do_manifest_no)
        GROUP BY do_manifest_no
      ) lmh_sum ON lmh_sum.do_manifest_no = lmh.do_manifest_no
      LEFT JOIN log_freight_cost lfc
        ON lfc.expedition_code = lmh.expedition_code
        AND lfc.vehicle_code_type = lmh.vehicle_code_type
        AND lfc.city_code = lmh.city_code
        AND lfc.area = lmh.area
      LEFT JOIN log_invoice_receipt_detail lird ON lird.do_manifest_no = lmd.do_manifest_no AND lird.delivery_no = lmd.delivery_no
      LEFT JOIN log_invoice_receipt_header lirh ON lirh.id = lird.id_header
      WHERE lmd.do_manifest_no IN ($str_do_manifest_no)
      GROUP BY lmd.do_manifest_no, lmd.delivery_no, lmd.do_date, lmd.region, lmd.code_sales, lmd.kode_cabang, lmd.ship_to_code, lmd.ship_to
    ";

    $query = DB::select(DB::raw($sqlSummary));

    return $query;
  }
}
