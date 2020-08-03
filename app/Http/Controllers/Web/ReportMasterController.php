<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\VehicleDetail;
use DataTables;
use DB;
use Illuminate\Http\Request;

class ReportMasterController extends Controller
{
  public function index(Request $request)
  {
    if ($request->ajax()) {
        $query = VehicleDetail::select('tr_vehicle_type_detail.*',
          DB::raw('tr_vehicle_type_group.group_name as vehicle_group')
      )
      ->leftjoin('tr_vehicle_type_group', 'tr_vehicle_type_group.id', '=', 'tr_vehicle_type_detail.vehicle_group_id');

       $datatables = DataTables::of($query);

       return $datatables->make(true);
    }


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
        break;
      case 'Master Destination':
        $view['name'] = 'web.report.report-master._master_destination';
        break;
      case 'Master Destination City':
        $view['name'] = 'web.report.report-master._master_destination_city';
        break;
      case 'Master Driver':
        $view['name'] = 'web.report.report-master._master_driver';
        break;
      case 'Master Expedition':
        $view['name'] = 'web.report.report-master._master_expedition';
        break;
      case 'Master Gate':
        $view['name'] = 'web.report.report-master._master_gate';
        break;
      case 'Master Model':
        $view['name'] = 'web.report.report-master._master_model';
        break;
      case 'Master Vehicle':
        $view['name'] = 'web.report.report-master._master_vehicle';
        break;
       case 'Master Vehicle Expedition':
        $view['name'] = 'web.report.report-master._master_vehicle_expedition';
        break;
      case 'Master Vendor':
        $view['name'] = 'web.report.report-master._master_vendor';
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

      case 'Master Destination':
        return $this->exportMasterDestination($request);
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

    // getPHPSpreadsheetTitleStyle() ada di wms Helper
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

  protected function exportMasterDestination($request)
  {
    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet       = $spreadsheet->getActiveSheet();

    $sheet->setCellValue('A1', 'DESTINATION NUMBER');
    $sheet->setCellValue('B1', 'DESTINATION NAME');
    $sheet->setCellValue('C1', 'REGION');

    // getPHPSpreadsheetTitleStyle() ada di wms Helper
    $sheet->getStyle('A1:C1')->applyFromArray(getPHPSpreadsheetTitleStyle()); 

    $data = \App\Models\MasterDestination::all();

    $row = 2;
    foreach ($data as $key => $destination) {
      $sheet->setCellValue('A' . $row, $destination->destination_number);
      $sheet->setCellValue('B' . $row, $destination->destination_description);
      $sheet->setCellValue('C' . $row, $destination->region);
      $row++;
    }

    $sheet->getColumnDimension('A')->setAutoSize(true);
    $sheet->getColumnDimension('B')->setAutoSize(true);
    $sheet->getColumnDimension('C')->setAutoSize(true);

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
