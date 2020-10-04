<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\DriverRegistered;
use DataTables;
use Illuminate\Http\Request;

class StandbyDriverListController extends Controller
{
  public function index(Request $request)
  {
    if ($request->ajax()) {
      $query = DriverRegistered::transporterWaitingConcept($request)
        ->get();

      $datatables = DataTables::of($query)
        ->addIndexColumn() //DT_RowIndex (Penomoran)
        ->editColumn('driver_id', function ($data) {
          return $data->driver_id . '<br>' . $data->driver_name;
        })
        ->addColumn('action', function ($data) {
          $action = '';
          $action .= ' ' . get_button_view(url('picking-list/transporter/' . $data->id), 'Assign Picking');
          $action .= ' ' . get_button_edit(url('picking-list/transporter/' . $data->id . '/edit'));
          $action .= ' ' . get_button_delete('Is Leave');
          return $action;
        })
        ->rawColumns(['driver_id', 'action']);

      return $datatables->make(true);
    }
    return view('web.report.standby-driver-list.index');
  }

  public function export(Request $request)
  {
    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet       = $spreadsheet->getActiveSheet();

    $col = 'A';
    $sheet->setCellValue(($col++) . '1', 'NO');
    $sheet->setCellValue(($col++) . '1', 'VEHICLE NUMBER');
    $sheet->setCellValue(($col++) . '1', 'DRIVER ID');
    $sheet->setCellValue(($col++) . '1', 'DRIVER NAME');
    $sheet->setCellValue(($col++) . '1', 'VEHICLE DESCRIPTION');
    $sheet->setCellValue(($col++) . '1', 'CBM MAX');
    $sheet->setCellValue(($col++) . '1', 'VEHICLE CODE TYPE');
    $sheet->setCellValue(($col++) . '1', 'DESTINATION NUMBER');
    $sheet->setCellValue(($col++) . '1', 'DESTINATION');
    $sheet->setCellValue(($col++) . '1', 'EXPEDITION CODE');
    $sheet->setCellValue(($col++) . '1', 'SAP VENDOR CODE');
    $sheet->setCellValue(($col++) . '1', 'TRANSPORTER');
    $sheet->setCellValue(($col++) . '1', 'CHECKIN TIME');
    $sheet->setCellValue(($col) . '1', 'AREA');

    // getPHPSpreadsheetTitleStyle() ada di wms Helper
    $sheet->getStyle('A1:' . ($col) . '1')->applyFromArray(getPHPSpreadsheetTitleStyle());

    $data = DriverRegistered::transporterWaitingConcept($request)
      ->get();

    $row = 2;
    foreach ($data as $key => $value) {
      $col = 'A';
      $sheet->setCellValue(($col++) . $row, ($key + 1));
      $sheet->setCellValue(($col++) . $row, $value->vehicle_number);
      $sheet->setCellValue(($col++) . $row, $value->driver_id);
      $sheet->setCellValue(($col++) . $row, $value->driver_name);
      $sheet->setCellValue(($col++) . $row, $value->vehicle_description);
      $sheet->setCellValue(($col++) . $row, $value->cbm_max);
      $sheet->setCellValue(($col++) . $row, $value->vehicle_code_type);
      $sheet->setCellValue(($col++) . $row, $value->destination_number);
      $sheet->setCellValue(($col++) . $row, $value->destination_name);
      $sheet->setCellValue(($col++) . $row, $value->expedition_code);
      $sheet->setCellValue(($col++) . $row, $value->sap_vendor_code);
      $sheet->setCellValue(($col++) . $row, $value->expedition_name);
      $sheet->setCellValue(($col++) . $row, $value->created_at);
      $sheet->setCellValue(($col++) . $row, $value->area);
      $row++;
    }

    $sheet->getColumnDimension('A')->setAutoSize(true);
    $sheet->getColumnDimension('B')->setAutoSize(true);
    $sheet->getColumnDimension('C')->setAutoSize(true);
    $sheet->getColumnDimension('D')->setAutoSize(true);
    $sheet->getColumnDimension('E')->setAutoSize(true);
    $sheet->getColumnDimension('F')->setAutoSize(true);

    $title = 'Standby Driver List Area ' . $request->input('area');

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
