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
      $query = VehicleDetail::select(
        'tr_vehicle_type_detail.*',
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

      case 'Master Destination City':
        return $this->exportMasterDestinationCity($request);
        break;

      case 'Master Driver':
        return $this->exportMasterDriver($request);
        break;

      case 'Master Expedition':
        return $this->exportMasterExpedition($request);
        break;

      case 'Master Gate':
        return $this->exportMasterGate($request);
        break;

      case 'Master Vehicle':
        return $this->exportMasterVehicle($request);
        break;

      case 'Master Vehicle Expedition':
        return $this->exportMasterVehicleExpedition($request);
        break;

      case 'Master Vendor':
        return $this->exportMasterVendor($request);
        break;

      case 'Master Model':
        return $this->exportMasterModel($request);
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

  protected function exportMasterDestinationCity($request)
  {
    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet       = $spreadsheet->getActiveSheet();

    $sheet->setCellValue('A1', 'CITY CODE');
    $sheet->setCellValue('B1', 'CITY NAME');

    // getPHPSpreadsheetTitleStyle() ada di wms Helper
    $sheet->getStyle('A1:B1')->applyFromArray(getPHPSpreadsheetTitleStyle());

    $data = \App\Models\DestinationCity::all();

    $row = 2;
    foreach ($data as $key => $destinationCity) {
      $sheet->setCellValue('A' . $row, $destinationCity->city_code);
      $sheet->setCellValue('B' . $row, $destinationCity->city_name);
      $row++;
    }

    $sheet->getColumnDimension('A')->setAutoSize(true);
    $sheet->getColumnDimension('B')->setAutoSize(true);

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

  protected function exportMasterDriver($request)
  {
    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet       = $spreadsheet->getActiveSheet();

    $sheet->setCellValue('A1', 'DRIVER ID');
    $sheet->setCellValue('B1', 'DRIVER NAME');
    $sheet->setCellValue('C1', 'KTP NO.');
    $sheet->setCellValue('D1', 'DRIVING LICENSE TYPE');
    $sheet->setCellValue('E1', 'DRIVING LICENSE NO.');
    $sheet->setCellValue('F1', 'EXPEDITION CODE');
    $sheet->setCellValue('G1', 'EXPEDITION NAME');
    $sheet->setCellValue('H1', 'PHONE 1');
    $sheet->setCellValue('I1', 'PHONE 2');
    $sheet->setCellValue('J1', 'STATUS');

    // getPHPSpreadsheetTitleStyle() ada di wms Helper
    $sheet->getStyle('A1:J1')->applyFromArray(getPHPSpreadsheetTitleStyle());

    $data = \App\Models\MasterDriver::select(
      'tr_driver.*',
      DB::raw('tr_expedition.expedition_name as expedition_name')
    )
      ->leftjoin('tr_expedition', 'tr_expedition.code', '=', 'tr_driver.expedition_code')
      ->get();

    $row = 2;
    foreach ($data as $key => $driver) {
      $sheet->setCellValue('A' . $row, $driver->driver_id);
      $sheet->setCellValue('B' . $row, $driver->driver_name);
      $sheet->setCellValue('C' . $row, $driver->ktp_no);
      $sheet->getStyle('C' . $row)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);
      $sheet->setCellValue('D' . $row, $driver->driving_license_type);
      $sheet->setCellValue('E' . $row, $driver->driving_license_no);
      $sheet->getStyle('E' . $row)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);
      $sheet->setCellValue('F' . $row, $driver->expedition_code);
      $sheet->setCellValue('G' . $row, $driver->expedition_name);
      $sheet->setCellValue('H' . $row, $driver->phone1);
      $sheet->setCellValue('I' . $row, $driver->phone2);
      $sheet->setCellValue('J' . $row, '=IF(' . $driver->active_status . '=1,"Active","No Active")');
      $row++;
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

  protected function exportMasterExpedition($request)
  {
    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet       = $spreadsheet->getActiveSheet();

    $sheet->setCellValue('A1', 'CODE');
    $sheet->setCellValue('B1', 'SAP VENDOR CODE');
    $sheet->setCellValue('C1', 'NAME');
    $sheet->setCellValue('D1', 'ADDRESS');
    $sheet->setCellValue('E1', 'CONTACT PERSON');
    $sheet->setCellValue('F1', 'PHONE NUMBER 1');
    $sheet->setCellValue('G1', 'PHONE NUMBER 2');
    $sheet->setCellValue('H1', 'FAX NUMBER');
    $sheet->setCellValue('I1', 'BANK');
    $sheet->setCellValue('J1', 'CURRENCY');
    $sheet->setCellValue('K1', 'STATUS');

    // getPHPSpreadsheetTitleStyle() ada di wms Helper
    $sheet->getStyle('A1:K1')->applyFromArray(getPHPSpreadsheetTitleStyle());

    $data = \App\Models\MasterExpedition::all();

    $row = 2;
    foreach ($data as $key => $expedition) {
      $sheet->setCellValue('A' . $row, $expedition->code);
      $sheet->setCellValue('B' . $row, $expedition->sap_vendor_code);
      $sheet->setCellValue('C' . $row, $expedition->expedition_name);
      $sheet->setCellValue('D' . $row, $expedition->address);
      $sheet->setCellValue('E' . $row, $expedition->contact_person);
      $sheet->setCellValue('F' . $row, $expedition->phone_number_1);
      $sheet->getStyle('F' . $row)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);
      $sheet->setCellValue('G' . $row, $expedition->phone_number_2);
      $sheet->getStyle('G' . $row)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);
      $sheet->setCellValue('H' . $row, $expedition->fax_number);
      $sheet->setCellValue('I' . $row, $expedition->bank);
      $sheet->setCellValue('J' . $row, $expedition->currency);
      $sheet->setCellValue('K' . $row, '=IF(' . $expedition->status_active . '=1,"Active","No Active")');
      $row++;
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

  protected function exportMasterGate($request)
  {
    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet       = $spreadsheet->getActiveSheet();

    $sheet->setCellValue('A1', 'AREA');
    $sheet->setCellValue('B1', 'GATE NUMBER');
    $sheet->setCellValue('C1', 'DESCRIPTION');

    // getPHPSpreadsheetTitleStyle() ada di wms Helper
    $sheet->getStyle('A1:C1')->applyFromArray(getPHPSpreadsheetTitleStyle());

    $data = \App\Models\Gate::all();

    $row = 2;
    foreach ($data as $key => $gate) {
      $sheet->setCellValue('A' . $row, $gate->area);
      $sheet->setCellValue('B' . $row, $gate->gate_number);
      $sheet->setCellValue('C' . $row, $gate->description);
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

  protected function exportMasterVehicle($request)
  {
    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet       = $spreadsheet->getActiveSheet();

    $sheet->setCellValue('A1', 'GROUP NAME');
    $sheet->setCellValue('B1', 'VEHICLE CODE');
    $sheet->setCellValue('C1', 'VEHICLE DESCRIPTION');
    $sheet->setCellValue('D1', 'VEHICLE SAP DESCRIPTION');
    $sheet->setCellValue('E1', 'CBM MIN');
    $sheet->setCellValue('F1', 'CBM MAX');

    // getPHPSpreadsheetTitleStyle() ada di wms Helper
    $sheet->getStyle('A1:F1')->applyFromArray(getPHPSpreadsheetTitleStyle());

    $data = \App\Models\VehicleDetail::select(
      'tr_vehicle_type_detail.*',
      DB::raw('tr_vehicle_type_group.group_name as vehicle_group')
    )
      ->leftjoin('tr_vehicle_type_group', 'tr_vehicle_type_group.id', '=', 'tr_vehicle_type_detail.vehicle_group_id')
      ->get();

    $row = 2;
    foreach ($data as $key => $vehicle) {
      $sheet->setCellValue('A' . $row, $vehicle->vehicle_group);
      $sheet->setCellValue('B' . $row, $vehicle->vehicle_code_type);
      $sheet->setCellValue('C' . $row, $vehicle->vehicle_description);
      $sheet->setCellValue('D' . $row, $vehicle->sap_description);
      $sheet->setCellValue('E' . $row, $vehicle->cbm_min);
      $sheet->setCellValue('F' . $row, $vehicle->cbm_max);
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

  protected function exportMasterVehicleExpedition($request)
  {
    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet       = $spreadsheet->getActiveSheet();

    $sheet->setCellValue('A1', 'CODE');
    $sheet->setCellValue('B1', 'EXPEDITION NAME');
    $sheet->setCellValue('C1', 'VEHICLE NO.');
    $sheet->setCellValue('D1', 'DESTINATION');
    $sheet->setCellValue('E1', 'DESCRIPTION');
    $sheet->setCellValue('F1', 'REMARKS 1');
    $sheet->setCellValue('G1', 'REMARKS 2');
    $sheet->setCellValue('H1', 'REMARKS 3');
    $sheet->setCellValue('I1', 'STATUS');

    // getPHPSpreadsheetTitleStyle() ada di wms Helper
    $sheet->getStyle('A1:I1')->applyFromArray(getPHPSpreadsheetTitleStyle());

    if (auth()->user()->cabang->hq) {
      $data = \App\Models\MasterVehicleExpedition::select(
        'tr_vehicle_expedition.*',
        DB::raw('tr_expedition.expedition_name as expedition_name')
      )
        ->leftjoin('tr_expedition', 'tr_expedition.code', '=', 'tr_vehicle_expedition.expedition_code')
        ->get();
    } else {
      $data = \App\Models\BranchExpeditionVehicle::select(
        'wms_branch_vehicle_expedition.*',
        DB::raw('tr_vehicle_type_detail.vehicle_description as vehicle_type'),
        DB::raw('tr_vehicle_type_detail.cbm_min'),
        DB::raw('tr_vehicle_type_detail.cbm_max'),
        DB::raw('tr_vehicle_type_group.group_name AS vehicle_group'),
        DB::raw('wms_branch_expedition.expedition_name'),
        DB::raw('tr_destination.destination_description AS destination_name')
      )
        ->leftjoin('wms_branch_expedition', 'wms_branch_expedition.code', '=', 'wms_branch_vehicle_expedition.expedition_code')
        ->leftjoin('tr_vehicle_type_detail', 'tr_vehicle_type_detail.vehicle_code_type', '=', 'wms_branch_vehicle_expedition.vehicle_code_type')
        ->leftjoin('tr_vehicle_type_group', 'tr_vehicle_type_group.id', '=', 'tr_vehicle_type_detail.vehicle_group_id')
        ->leftjoin('tr_destination', 'tr_destination.destination_number', '=', 'wms_branch_vehicle_expedition.destination')
        ->where('wms_branch_expedition.kode_cabang', auth()->user()->cabang->kode_cabang)
        ->get();
    }

    $row = 2;
    foreach ($data as $key => $vehicleExpedition) {
      $sheet->setCellValue('A' . $row, $vehicleExpedition->expedition_code);
      $sheet->setCellValue('B' . $row, $vehicleExpedition->expedition_name);
      $sheet->setCellValue('C' . $row, $vehicleExpedition->vehicle_number);
      $sheet->setCellValue('D' . $row, $vehicleExpedition->destination);
      $sheet->setCellValue('E' . $row, $vehicleExpedition->vehicle_detail_description);
      $sheet->setCellValue('F' . $row, $vehicleExpedition->remark1);
      $sheet->setCellValue('G' . $row, $vehicleExpedition->remark2);
      $sheet->setCellValue('H' . $row, $vehicleExpedition->remark3);
      $sheet->setCellValue('I' . $row, '=IF(' . $vehicleExpedition->status_active . '=1,"Active","No Active")');
      $row++;
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

  protected function exportMasterVendor($request)
  {
    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet       = $spreadsheet->getActiveSheet();

    $sheet->setCellValue('A1', 'VENDOR CODE');
    $sheet->setCellValue('B1', 'VENDOR NAME');
    $sheet->setCellValue('C1', 'DESCRIPTION');
    $sheet->setCellValue('D1', 'VENDOR ADDRESS');
    $sheet->setCellValue('E1', 'CONTACT PERSON NAME');
    $sheet->setCellValue('F1', 'CONTACT PERSON PHONE');
    $sheet->setCellValue('G1', 'CONTACT PERSON EMAIL');

    // getPHPSpreadsheetTitleStyle() ada di wms Helper
    $sheet->getStyle('A1:G1')->applyFromArray(getPHPSpreadsheetTitleStyle());

    $data = \App\Models\Vendor::all();

    $row = 2;
    foreach ($data as $key => $vendor) {
      $sheet->setCellValue('A' . $row, $vendor->vendor_code);
      $sheet->setCellValue('B' . $row, $vendor->vendor_name);
      $sheet->setCellValue('C' . $row, $vendor->description);
      $sheet->setCellValue('D' . $row, $vendor->vendor_address);
      $sheet->setCellValue('E' . $row, $vendor->contact_person_name);
      $sheet->setCellValue('F' . $row, $vendor->contact_person_phone);
      $sheet->setCellValue('G' . $row, $vendor->contact_person_email);
      $row++;
    }

    $sheet->getColumnDimension('A')->setAutoSize(true);
    $sheet->getColumnDimension('B')->setAutoSize(true);
    $sheet->getColumnDimension('C')->setAutoSize(true);
    $sheet->getColumnDimension('D')->setAutoSize(true);
    $sheet->getColumnDimension('E')->setAutoSize(true);
    $sheet->getColumnDimension('F')->setAutoSize(true);
    $sheet->getColumnDimension('G')->setAutoSize(true);

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

  protected function exportMasterModel($request)
  {
    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet       = $spreadsheet->getActiveSheet();

    $sheet->setCellValue('A1', 'MODEL NAME');
    $sheet->setCellValue('B1', 'EAN CODE');
    $sheet->setCellValue('C1', 'CBM');
    $sheet->setCellValue('D1', 'MATERIAL GROUP');
    $sheet->setCellValue('E1', 'CATEGORY');
    $sheet->setCellValue('F1', 'TYPE');
    $sheet->setCellValue('G1', 'PIECES/CARTON');
    $sheet->setCellValue('H1', 'CARTON/PALET');
    $sheet->setCellValue('I1', 'PALET');
    $sheet->setCellValue('J1', 'DESCRIPTION');

    // getPHPSpreadsheetTitleStyle() ada di wms Helper
    $sheet->getStyle('A1:J1')->applyFromArray(getPHPSpreadsheetTitleStyle());

    $data = \App\Models\MasterModel::all();

    $row = 2;
    foreach ($data as $key => $model) {
      $sheet->setCellValue('A' . $row, $model->model_name);
      $sheet->setCellValue('B' . $row, $model->ean_code);
      $sheet->setCellValue('C' . $row, $model->cbm);
      $sheet->setCellValue('D' . $row, $model->material_group);
      $sheet->setCellValue('E' . $row, $model->category);
      $sheet->setCellValue('F' . $row, $model->model_type);
      $sheet->setCellValue('G' . $row, $model->pcs_ctn);
      $sheet->setCellValue('H' . $row, $model->ctn_plt);
      $sheet->setCellValue('I' . $row, $model->max_pallet);
      $sheet->setCellValue('J' . $row, $model->description);
      $row++;
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
