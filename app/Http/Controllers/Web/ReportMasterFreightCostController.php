<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\FreightCost;
use DataTables;
use Illuminate\Http\Request;

class ReportMasterFreightCostController extends Controller
{
  public function index(Request $request)
  {
    if ($request->ajax()) {
      $query = $this->getDataMasterFreightCost($request);

      $query->where('log_freight_cost.area', $request->input('area'));

      $datatables = DataTables::of($query)
        ->editColumn('created_at', function ($data) {
          return $data->created_at;
        })
      ;

      return $datatables->make(true);
    }

    return view('web.report.report-master-freight-cost.index');
  }

  public function export(Request $request)
  {
    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet       = $spreadsheet->getActiveSheet();

    $col = 'A';
    $sheet->setCellValue(($col++) . '1', 'AREA');
    $sheet->setCellValue(($col++) . '1', 'CITY CODE');
    $sheet->setCellValue(($col++) . '1', 'CITY NAME');
    $sheet->setCellValue(($col++) . '1', 'EXPEDITION CODE');
    $sheet->setCellValue(($col++) . '1', 'EXPEDITION NAME');
    $sheet->setCellValue(($col++) . '1', 'VEHICLE CODE TYPE');
    $sheet->setCellValue(($col++) . '1', 'VEHICLE DESCRIPTION');
    $sheet->setCellValue(($col++) . '1', 'RITASE');
    $sheet->setCellValue(($col++) . '1', 'CBM');
    $sheet->setCellValue(($col) . '1', 'LEADTIME');

    // getPHPSpreadsheetTitleStyle() ada di wms Helper
    $sheet->getStyle('A1:' . ($col) . '1')->applyFromArray(getPHPSpreadsheetTitleStyle());

    $data = $this->getDataMasterFreightCost($request)->get();

    $row = 2;
    foreach ($data as $key => $value) {
      $col = 'A';
      $sheet->setCellValue(($col++) . $row, $value->area);
      $sheet->setCellValue(($col++) . $row, $value->city_code);
      $sheet->setCellValue(($col++) . $row, $value->city_name);
      $sheet->setCellValue(($col++) . $row, $value->expedition_code);
      $sheet->setCellValue(($col++) . $row, $value->expedition_name);
      $sheet->setCellValue(($col++) . $row, $value->vehicle_code_type);
      $sheet->setCellValue(($col++) . $row, $value->vehicle_description);
      $sheet->setCellValue(($col++) . $row, $value->ritase);
      $sheet->setCellValue(($col++) . $row, $value->cbm);
      $sheet->setCellValue(($col++) . $row, $value->leadtime);
      $row++;
    }

    $sheet->getColumnDimension('A')->setAutoSize(true);
    $sheet->getColumnDimension('B')->setAutoSize(true);
    $sheet->getColumnDimension('C')->setAutoSize(true);
    $sheet->getColumnDimension('D')->setAutoSize(true);
    $sheet->getColumnDimension('E')->setAutoSize(true);
    $sheet->getColumnDimension('F')->setAutoSize(true);

    $title = 'Report Master Freight Cost ' . $request->input('area');

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

  protected function getDataMasterFreightCost($request)
  {
    return FreightCost::select(
      'log_freight_cost.*',
      'log_destination_city.city_name',
      'tr_expedition.expedition_name',
      'tr_vehicle_type_detail.vehicle_description',
    )
      ->leftjoin('log_destination_city', 'log_destination_city.city_code', '=', 'log_freight_cost.city_code')
      ->leftjoin('tr_expedition', 'tr_expedition.code', '=', 'log_freight_cost.expedition_code')
      ->leftjoin('tr_vehicle_type_detail', 'tr_vehicle_type_detail.vehicle_code_type', '=', 'log_freight_cost.vehicle_code_type')
    ;
  }
}
