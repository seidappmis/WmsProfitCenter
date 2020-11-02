<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use DataTables;
use DB;
use Illuminate\Http\Request;

class SummaryFreightCostReportPerRegionController extends Controller
{
  public function index(Request $request)
  {
    if ($request->ajax()) {
      $query = $this->getData($request);

      $datatables = DataTables::of($query)
      ;

      return $datatables->make(true);
    }

    return view('web.report.summary-freight-cost-report-per-region.index');
  }

  public function export(Request $request)
  {
    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet       = $spreadsheet->getActiveSheet();

    $col = 'A';
    $sheet->setCellValue(($col++) . '1', 'REGION');
    $sheet->setCellValue(($col++) . '1', 'BRANCH DESC');
    $sheet->setCellValue(($col++) . '1', 'SALES CODE');
    $sheet->setCellValue(($col++) . '1', 'MONT');
    $sheet->setCellValue(($col++) . '1', 'YEAR');
    $sheet->setCellValue(($col++) . '1', 'DESTINATION');
    $sheet->setCellValue(($col++) . '1', 'FREIGHT COST');
    $sheet->setCellValue(($col++) . '1', 'MULTI DROP');
    $sheet->setCellValue(($col++) . '1', 'UNLOADING');
    $sheet->setCellValue(($col) . '1', 'OVERSTAY');

    // getPHPSpreadsheetTitleStyle() ada di wms Helper
    $sheet->getStyle('A1:' . ($col) . '1')->applyFromArray(getPHPSpreadsheetTitleStyle());

    $data = $this->getData($request)
    ;

    $row = 2;
    foreach ($data as $key => $value) {
      $col = 'A';
      $sheet->setCellValue(($col++) . $row, $value->region);
      $sheet->setCellValue(($col++) . $row, $value->branch_short_description);
      $sheet->setCellValue(($col++) . $row, $value->code_sales);
      $sheet->setCellValue(($col++) . $row, $value->bulan);
      $sheet->setCellValue(($col++) . $row, $value->tahun);
      $sheet->setCellValue(($col++) . $row, $value->destination);
      $sheet->setCellValue(($col++) . $row, $value->freight_cost);
      $sheet->setCellValue(($col++) . $row, $value->multi_drop);
      $sheet->setCellValue(($col++) . $row, $value->unloading);
      $sheet->setCellValue(($col++) . $row, $value->overstay);
      $row++;
    }

    $sheet->getColumnDimension('A')->setAutoSize(true);
    $sheet->getColumnDimension('B')->setAutoSize(true);
    $sheet->getColumnDimension('C')->setAutoSize(true);
    $sheet->getColumnDimension('D')->setAutoSize(true);
    $sheet->getColumnDimension('E')->setAutoSize(true);
    $sheet->getColumnDimension('F')->setAutoSize(true);

    $title = 'Summary Freight Cost Report Per Region' . $request->input('area');

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
      lc.region,
      lc.short_description AS branch_short_description,
      lc.kode_cabang,
      lird.code_sales,
      DATE_FORMAT(lird.do_manifest_date, '%m') AS bulan,
      DATE_FORMAT(lird.do_manifest_date, '%Y') AS tahun,
      lird.city_name AS destination,
      SUM(lird.cbm_amount) + SUM(lird.ritase_amount) + SUM(lird.ritase2_amount) AS freight_cost,
      SUM(lird.multidro_amount) as multi_drop,
      SUM(lird.unloading_amount) AS unloading,
      SUM(lird.overstay_amount) AS overstay
    FROM log_invoice_receipt_header lirh
    LEFT JOIN log_invoice_receipt_detail lird ON lird.id_header = lirh.id
    LEFT JOIN log_manifest_header lmh ON lmh.do_manifest_no = lird.do_manifest_no
    LEFT JOIN log_cabang lc ON lird.kode_cabang = lc.kode_cabang
    WHERE lird.do_manifest_date >= ? AND lird.do_manifest_date <= ?
    ";

    $condition_params = [
      $request->input('start_date'),
      $request->input('end_date'),
    ];

    if (!empty($request->input('city_code'))) {
      $sql .= ' AND lmh.city_code = ?';
      $condition_params[] = $request->input('city_code');
    }

    if (!empty($request->input('code_sales'))) {
      $sql .= ' AND lird.code_sales = ?';
      $condition_params[] = $request->input('code_sales');
    }

    if (!empty($request->input('region'))) {
      $sql .= ' AND lc.region = ?';
      $condition_params[] = $request->input('region');
    }

    if (!empty($request->input('branch'))) {
      $sql .= ' AND lird.kode_cabang = ?';
      $condition_params[] = $request->input('branch');
    }

    $sql .= " GROUP BY lc.region, lc.short_description, lird.code_sales, DATE_FORMAT(lird.do_manifest_date, '%m%Y'), lird.city_name";

    $query = DB::select(DB::raw($sql), $condition_params);

    return $query;
  }

}
