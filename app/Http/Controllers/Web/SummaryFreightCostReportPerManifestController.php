<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use DataTables;
use DB;
use Illuminate\Http\Request;

class SummaryFreightCostReportPerManifestController extends Controller
{
  public function index(Request $request)
  {
    if ($request->ajax()) {
      $query = $this->getData($request);

      $datatables = DataTables::of($query)
        ->editColumn('do_manifest_date', function ($data) {
          return format_tanggal_wms($data->do_manifest_date);
        })
        ->editColumn('invoice_receipt_date', function ($data) {
          return format_tanggal_wms($data->invoice_receipt_date);
        })
      ;

      return $datatables->make(true);
    }

    return view('web.report.summary-freight-cost-report-per-manifest.index');
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
    $sheet->setCellValue(($col++) . '1', 'Paid Status');
    $sheet->setCellValue(($col++) . '1', 'Bulan');
    $sheet->setCellValue(($col++) . '1', 'ACC Code');
    $sheet->setCellValue(($col++) . '1', 'Branch Code');
    $sheet->setCellValue(($col++) . '1', 'SLOC');
    $sheet->setCellValue(($col++) . '1', 'Manifest No');
    $sheet->setCellValue(($col++) . '1', 'Tgl Manifest');
    $sheet->setCellValue(($col++) . '1', 'Transporter');
    $sheet->setCellValue(($col++) . '1', 'Destination');
    $sheet->setCellValue(($col++) . '1', 'Vehicle Type');
    $sheet->setCellValue(($col++) . '1', 'Vehicle No');
    $sheet->setCellValue(($col++) . '1', 'DO No');
    $sheet->setCellValue(($col++) . '1', 'Branch Short Description');
    $sheet->setCellValue(($col++) . '1', 'Ship To Code');
    $sheet->setCellValue(($col++) . '1', 'Ship to Description');
    $sheet->setCellValue(($col++) . '1', 'Destination City DO');
    $sheet->setCellValue(($col++) . '1', 'Total CBM DO');
    $sheet->setCellValue(($col++) . '1', 'SumOfTotalCBM');
    $sheet->setCellValue(($col++) . '1', 'BaseCostCBM');
    $sheet->setCellValue(($col++) . '1', 'CostPerDO');
    $sheet->setCellValue(($col++) . '1', 'BaseCostRitase');
    $sheet->setCellValue(($col++) . '1', 'RitaseCost');
    $sheet->setCellValue(($col++) . '1', 'Ritase2Cost');
    $sheet->setCellValue(($col++) . '1', 'MultiDrop');
    $sheet->setCellValue(($col++) . '1', 'Unloading');
    $sheet->setCellValue(($col++) . '1', 'OverStay');
    $sheet->setCellValue(($col++) . '1', 'Total');
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
      $sheet->setCellValue(($col++) . $row, format_tanggal_wms($value->invoice_receipt_date));
      $sheet->setCellValue(($col++) . $row, $value->amount_after_tax);
      $sheet->setCellValue(($col++) . $row, $value->status);
      $sheet->setCellValue(($col++) . $row, $value->paid_status);
      $sheet->setCellValue(($col++) . $row, $value->bulan);
      $sheet->setCellValue(($col++) . $row, $value->acc_code);
      $sheet->setCellValue(($col++) . $row, $value->kode_cabang);
      $sheet->setCellValue(($col++) . $row, $value->code_sales);
      $sheet->setCellValue(($col++) . $row, $value->do_manifest_no);
      $sheet->setCellValue(($col++) . $row, format_tanggal_wms($value->do_manifest_date));
      $sheet->setCellValue(($col++) . $row, $value->expedition_name);
      $sheet->setCellValue(($col++) . $row, $value->city_name);
      $sheet->setCellValue(($col++) . $row, $value->vehicle_description);
      $sheet->setCellValue(($col++) . $row, $value->vehicle_number);
      $sheet->setCellValue(($col++) . $row, $value->delivery_no);
      $sheet->setCellValue(($col++) . $row, $value->branch_short_description);
      $sheet->setCellValue(($col++) . $row, $value->ship_to_code);
      $sheet->setCellValue(($col++) . $row, $value->ship_to);
      $sheet->setCellValue(($col++) . $row, $value->city_name);
      $sheet->setCellValue(($col++) . $row, $value->cbm_do);
      $sheet->setCellValue(($col++) . $row, $value->cbm_vehicle);
      $sheet->setCellValue(($col++) . $row, $value->freight_cost);
      $sheet->setCellValue(($col++) . $row, $value->cbm_amount);
      $sheet->setCellValue(($col++) . $row, $value->ritase_freight_cost);
      $sheet->setCellValue(($col++) . $row, $value->ritase_amount);
      $sheet->setCellValue(($col++) . $row, $value->ritase2_amount);
      $sheet->setCellValue(($col++) . $row, $value->multidro_amount);
      $sheet->setCellValue(($col++) . $row, $value->unloading_amount);
      $sheet->setCellValue(($col++) . $row, $value->overstay_amount);
      $sheet->setCellValue(($col++) . $row, $value->amount_before_tax);
      $sheet->setCellValue(($col++) . $row, $value->region);
      $row++;
    }

    $colResize = 'A';
    while ($colResize != $col) {
      $sheet->getColumnDimension($colResize++)->setAutoSize(true);
    }

    $title = 'Summary Freight Cost Report Per Manifest ' . $request->input('area');

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

  protected function getData($request)
  {
    $sql = "
    SELECT
      lirh.invoice_receipt_id,
      lirh.invoice_receipt_no,
      lirh.kwitansi_no,
      lirh.invoice_receipt_date,
      lirh.amount_after_tax,
      lmh.manifest_type AS status,
      CASE
        WHEN (lirh.invoice_receipt_no IS NOT NULL && lirh.invoice_receipt_id IS NOT NULL) THEN 'Already Receipt'
        WHEN (lirh.invoice_receipt_no IS NULL && lirh.invoice_receipt_id IS NULL) THEN 'Unreceipt'
        ELSE 'Draft Receipt'
      END AS paid_status,
      DATE_FORMAT(lird.do_manifest_date, '%m.%y') AS bulan,
      lird.acc_code,
      lird.kode_cabang,
      lird.code_sales,
      lird.do_manifest_no,
      lmh.do_manifest_date,
      lirh.expedition_name,
      lmh.city_name,
      lmh.vehicle_description,
      lmh.vehicle_number,
      lird.delivery_no,
      lc.short_description AS branch_short_description,
      lird.ship_to_code,
      lird.ship_to,
      lird.city_name,
      lird.cbm_do,
      lird.cbm_vehicle,
      lird.freight_cost,
      lird.cbm_amount,
      lird.ritase_freight_cost,
      lird.ritase_amount,
      lird.ritase2_amount,
      lird.multidro_amount,
      lird.unloading_amount,
      lird.overstay_amount,
      lirh.amount_before_tax,
      lc.region
    FROM log_invoice_receipt_header lirh
    LEFT JOIN log_invoice_receipt_detail lird ON lird.id_header = lirh.id
    LEFT JOIN log_manifest_header lmh ON lmh.do_manifest_no = lird.do_manifest_no
    LEFT JOIN log_cabang lc ON lird.kode_cabang = lc.kode_cabang
    WHERE lmh.do_manifest_date >= ? AND lmh.do_manifest_date <= ?
    ";

    $condition_params = [
      $request->input('start_date'),
      $request->input('end_date'),
    ];

    if (!empty($request->input('do_manifest_no'))) {
      $sql .= ' AND lird.do_manifest_no = ?';
      $condition_params[] = $request->input('do_manifest_no');
    }

    if (!empty($request->input('city_code'))) {
      $sql .= ' AND lmh.city_code = ?';
      $condition_params[] = $request->input('city_code');
    }

    if (!empty($request->input('invoice_receipt_id'))) {
      $sql .= ' AND lirh.invoice_receipt_id = ?';
      $condition_params[] = $request->input('invoice_receipt_id');
    }

    if (!empty($request->input('region'))) {
      $sql .= ' AND lc.region = ?';
      $condition_params[] = $request->input('region');
    }

    if (!empty($request->input('expedition_code'))) {
      $sql .= ' AND lirh.expedition_code = ?';
      $condition_params[] = $request->input('expedition_code');
    }

    if (!empty($request->input('paid_status'))) {
      $sql .= ' HAVING paid_status = ?';
      $condition_params[] = $request->input('paid_status');
    }

    $query = DB::select(DB::raw($sql), $condition_params);

    return $query;
  }
}
