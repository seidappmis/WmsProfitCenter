<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\ConceptFlowHeader;
use DataTables;
use Illuminate\Http\Request;

class LoadingStatusListController extends Controller
{
  public function index(Request $request)
  {
    if ($request->ajax()) {
      $query = $this->getLoadingStatusListData($request);

      $datatables = DataTables::of($query)
        ->editColumn('created_at', function($data){
          return format_tanggal_jam_wms($data->created_at);
        })
        ->editColumn('mapping_concept_date', function($data){
          return format_tanggal_jam_wms($data->mapping_concept_date);
        })
        ->editColumn('select_gate_date', function($data){
          return format_tanggal_jam_wms($data->select_gate_date);
        })
        ->editColumn('load_loading_start', function($data){
          return format_tanggal_jam_wms($data->load_loading_start);
        })
        ->editColumn('load_loading_end', function($data){
          return format_tanggal_jam_wms($data->load_loading_end);
        })
        ->editColumn('reg_date_in', function($data){
          return format_tanggal_jam_wms($data->reg_date_in);
        })
        ->editColumn('reg_date_out', function($data){
          return format_tanggal_jam_wms($data->reg_date_out);
        })
      ;

      return $datatables->make(true);
    }

    return view('web.report.loading-status-list.index');
  }

  public function export(Request $request)
  {
    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet       = $spreadsheet->getActiveSheet();

    $col = 'A';
    $sheet->setCellValue(($col++) . '1', 'CONCEPT INVOICE NO');
    $sheet->setCellValue(($col++) . '1', 'CONCEPT LINE NO');
    $sheet->setCellValue(($col++) . '1', 'CONCEPT OUTPUT DATE');
    $sheet->setCellValue(($col++) . '1', 'CONCEPT OUTPUT TIME');
    $sheet->setCellValue(($col++) . '1', 'CONCEPT DESTINATION NAME');
    $sheet->setCellValue(($col++) . '1', 'CONCEPT VEHICLE CODE TYPE');
    $sheet->setCellValue(($col++) . '1', 'CONCEPT CAR NO');
    $sheet->setCellValue(($col++) . '1', 'CONCEPT CONT NO');
    $sheet->setCellValue(($col++) . '1', 'CONCEPT CHECKIN DATE');
    $sheet->setCellValue(($col++) . '1', 'CONCEPT CHECKIN TIME');
    $sheet->setCellValue(($col++) . '1', 'CONCEPT DELIVERY NO');
    $sheet->setCellValue(($col++) . '1', 'CONCEPT DELIVERY ITEMS');
    $sheet->setCellValue(($col++) . '1', 'CONCEPT MODEL');
    $sheet->setCellValue(($col++) . '1', 'CONCEPT QUANTITY');
    $sheet->setCellValue(($col++) . '1', 'CONCEPT CBM');
    $sheet->setCellValue(($col++) . '1', 'CONCEPT SHIP TO');
    $sheet->setCellValue(($col++) . '1', 'CONCEPT SOLD TO');
    $sheet->setCellValue(($col++) . '1', 'CONCEPT SHIP TO CITY');
    $sheet->setCellValue(($col++) . '1', 'CONCEPT SHIP TO STREET');
    $sheet->setCellValue(($col++) . '1', 'CONCEPT SOLD TO CITY');
    $sheet->setCellValue(($col++) . '1', 'CONCEPT SOLD TO DISTRICT');
    $sheet->setCellValue(($col++) . '1', 'CONCEPT SOLD TO STREET');
    $sheet->setCellValue(($col++) . '1', 'CONCEPT REMARKS');
    $sheet->setCellValue(($col++) . '1', 'CONCEPT UPLOAD DATE');
    $sheet->setCellValue(($col++) . '1', 'REG DRIVER ID');
    $sheet->setCellValue(($col++) . '1', 'REG DRIVER NAME');
    $sheet->setCellValue(($col++) . '1', 'REG VEHICLE NO');
    $sheet->setCellValue(($col++) . '1', 'REG VEHICLE DESC');
    $sheet->setCellValue(($col++) . '1', 'REG VEHICLE TYPE');
    $sheet->setCellValue(($col++) . '1', 'REG CBM TRUCK');
    $sheet->setCellValue(($col++) . '1', 'REG DATE IN');
    $sheet->setCellValue(($col++) . '1', 'REG DATE OUT');
    $sheet->setCellValue(($col++) . '1', 'REG DESTINATION');
    $sheet->setCellValue(($col++) . '1', 'REG REGION');
    $sheet->setCellValue(($col++) . '1', 'REG EXPEDITION CODE');
    $sheet->setCellValue(($col++) . '1', 'REG EXPEDITION NAME');
    $sheet->setCellValue(($col++) . '1', 'MAPPING CONCEPT DATE');
    $sheet->setCellValue(($col++) . '1', 'SELECT GATE DATE');
    $sheet->setCellValue(($col++) . '1', 'LOAD GATE NUMBER');
    $sheet->setCellValue(($col++) . '1', 'LOAD LOADING START');
    $sheet->setCellValue(($col++) . '1', 'LOAD LOADING END');
    $sheet->setCellValue(($col++) . '1', 'LOAD LOADING MINUTES');
    $sheet->setCellValue(($col++) . '1', 'LOAD LOAD DO MANIFEST NO');
    $sheet->setCellValue(($col++) . '1', 'STATUS');
    $sheet->setCellValue(($col++) . '1', 'SOLD TO CODE');
    $sheet->setCellValue(($col++) . '1', 'SHIP TO CODE');
    $sheet->setCellValue(($col) . '1', 'AREA');

    // getPHPSpreadsheetTitleStyle() ada di wms Helper
    $sheet->getStyle('A1:' . ($col) . '1')->applyFromArray(getPHPSpreadsheetTitleStyle());

    $data = $this->getLoadingStatusListData($request)->get();

    $row = 2;
    foreach ($data as $key => $value) {
      $col = 'A';
      $sheet->setCellValue(($col++) . $row, $value->invoice_no);
      $sheet->setCellValue(($col++) . $row, $value->line_no);
      $sheet->setCellValue(($col++) . $row, $value->output_date);
      $sheet->setCellValue(($col++) . $row, $value->output_time);
      $sheet->setCellValue(($col++) . $row, $value->concept_destination_name);
      $sheet->setCellValue(($col++) . $row, $value->vehicle_code_type);
      $sheet->setCellValue(($col++) . $row, $value->car_no);
      $sheet->setCellValue(($col++) . $row, $value->cont_no);
      $sheet->setCellValue(($col++) . $row, $value->checkin_date);
      $sheet->setCellValue(($col++) . $row, $value->checkin_time);
      $sheet->setCellValue(($col++) . $row, $value->delivery_no);
      $sheet->setCellValue(($col++) . $row, $value->delivery_items);
      $sheet->setCellValue(($col++) . $row, $value->model);
      $sheet->setCellValue(($col++) . $row, $value->quantity);
      $sheet->setCellValue(($col++) . $row, $value->cbm);
      $sheet->setCellValue(($col++) . $row, $value->ship_to);
      $sheet->setCellValue(($col++) . $row, $value->sold_to);
      $sheet->setCellValue(($col++) . $row, $value->ship_to_city);
      $sheet->setCellValue(($col++) . $row, $value->ship_to_street);
      $sheet->setCellValue(($col++) . $row, $value->sold_to_city);
      $sheet->setCellValue(($col++) . $row, $value->sold_to_district);
      $sheet->setCellValue(($col++) . $row, $value->sold_to_street);
      $sheet->setCellValue(($col++) . $row, $value->remarks);
      $spreadsheet->getActiveSheet()->getStyle(($col) . $row)
        ->getNumberFormat()
        ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_YYYYMMDDSLASH);
      $sheet->setCellValue(($col++) . $row, format_tanggal_jam_wms($value->created_at));
      $sheet->setCellValue(($col++) . $row, $value->reg_driver_id);
      $sheet->setCellValue(($col++) . $row, $value->reg_driver_name);
      $sheet->setCellValue(($col++) . $row, $value->reg_vehicle_no);
      $sheet->setCellValue(($col++) . $row, $value->reg_vehicle_description);
      $sheet->setCellValue(($col++) . $row, $value->reg_vehicle_type);
      $sheet->setCellValue(($col++) . $row, $value->reg_cbm_truck);
      $spreadsheet->getActiveSheet()->getStyle(($col) . $row)
        ->getNumberFormat()
        ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_YYYYMMDDSLASH);
      $sheet->setCellValue(($col++) . $row, format_tanggal_jam_wms($value->reg_date_in));
      $spreadsheet->getActiveSheet()->getStyle(($col) . $row)
        ->getNumberFormat()
        ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_YYYYMMDDSLASH);
      $sheet->setCellValue(($col++) . $row, format_tanggal_jam_wms($value->reg_date_out));
      $sheet->setCellValue(($col++) . $row, $value->reg_destination);
      $sheet->setCellValue(($col++) . $row, $value->reg_region);
      $sheet->setCellValue(($col++) . $row, $value->reg_expedition_code);
      $sheet->setCellValue(($col++) . $row, $value->reg_expedition_name);
      $spreadsheet->getActiveSheet()->getStyle(($col) . $row)
        ->getNumberFormat()
        ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_YYYYMMDDSLASH);
      $sheet->setCellValue(($col++) . $row, format_tanggal_jam_wms($value->mapping_concept_date));
      $spreadsheet->getActiveSheet()->getStyle(($col) . $row)
        ->getNumberFormat()
        ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_YYYYMMDDSLASH);
      $sheet->setCellValue(($col++) . $row, format_tanggal_jam_wms($value->select_gate_date));
      $sheet->setCellValue(($col++) . $row, $value->load_gate_number);
      $spreadsheet->getActiveSheet()->getStyle(($col) . $row)
        ->getNumberFormat()
        ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_YYYYMMDDSLASH);
      $sheet->setCellValue(($col++) . $row, format_tanggal_jam_wms($value->load_loading_start));
      $spreadsheet->getActiveSheet()->getStyle(($col) . $row)
        ->getNumberFormat()
        ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_YYYYMMDDSLASH);
      $sheet->setCellValue(($col++) . $row, format_tanggal_jam_wms($value->load_loading_end));
      $sheet->setCellValue(($col++) . $row, $value->load_loading_minutes);
      $sheet->setCellValue(($col++) . $row, $value->load_do_manifest_no);
      $sheet->setCellValue(($col++) . $row, $value->status);
      $sheet->setCellValue(($col++) . $row, $value->sold_to_code);
      $sheet->setCellValue(($col++) . $row, $value->ship_to_code);
      $sheet->setCellValue(($col++) . $row, $value->area);
      $row++;
    }

    $colResize = 'A';
    while ($colResize != $col) {
      $sheet->getColumnDimension($colResize++)->setAutoSize(true);
    }

    $title = 'Loading Status List ' . $request->input('area');

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

  protected function getLoadingStatusListData($request)
  {
    $query = ConceptFlowHeader::getLoadingSummary($request);

    if (!empty($request->input('invoice_no'))) {
      $query->where('tr_concept.invoice_no', $request->input('invoice_no'));
    }

    if (!empty($request->input('delivery_no'))) {
      $query->where('tr_concept.delivery_no', $request->input('delivery_no'));
    }

    if (!empty($request->input('vehicle_number'))) {
      $query->where('tr_driver_registered.vehicle_number', $request->input('vehicle_number'));
    }

    if (!empty($request->input('destination_number'))) {
      $query->where('tr_concept_truck_flow.destination_number', $request->input('destination_number'));
    }

    if (!empty($request->input('expedition_code'))) {
      $query->where('tr_driver_registered.expedition_code', $request->input('expedition_code'));
    }

    if (!empty($request->input('vehicle_code_type'))) {
      $query->where('tr_concept.vehicle_code_type', $request->input('vehicle_code_type'));
    }

    if (!empty($request->input('do_manifest_no'))) {
      $query->where('tr_concept_truck_flow.do_manifest_no', $request->input('do_manifest_no'));
    }

    if (!empty($request->input('start_upload_concept_date'))) {
      $query->where('tr_concept.created_at', '>=', $request->input('start_upload_concept_date'));
    }

    if (!empty($request->input('end_upload_concept_date'))) {
      $query->where('tr_concept.created_at', '<=', $request->input('end_upload_concept_date'));
    }

    if (!empty($request->input('start_register_driver_date'))) {
      $query->where('tr_driver_register.created_at', '>=', $request->input('start_register_driver_date'));
    }

    if (!empty($request->input('end_register_driver_date'))) {
      $query->where('tr_driver_register.created_at', '<=', $request->input('end_register_driver_date'));
    }

    if (!empty($request->input('start_mapping_concept_date'))) {
      $query->where('tr_concept_flow_header.created_at', '>=', $request->input('start_mapping_concept_date'));
    }

    if (!empty($request->input('end_mapping_concept_date'))) {
      $query->where('tr_concept_flow_header.created_at', '<=', $request->input('end_mapping_concept_date'));
    }

    if (!empty($request->input('start_loading_start_date'))) {
      $query->where('tr_concept_truck_flow.start_date', '>=', $request->input('start_loading_start_date'));
    }

    if (!empty($request->input('end_loading_start_date'))) {
      $query->where('tr_concept_truck_flow.start_date', '<=', $request->input('end_loading_start_date'));
    }

    if (!empty($request->input('start_loading_finish_date'))) {
      $query->where('tr_concept_truck_flow.end_date', '>=', $request->input('start_loading_finish_date'));
    }

    if (!empty($request->input('end_loading_finish_date'))) {
      $query->where('tr_concept_truck_flow.end_date', '<=', $request->input('end_loading_finish_date'));
    }

    if (!empty($request->input('start_complete_date'))) {
      $query->where('tr_concept_truck_flow.complete_date', '>=', $request->input('start_complete_date'));
    }

    if (!empty($request->input('end_complete_date'))) {
      $query->where('tr_concept_truck_flow.complete_date', '<=', $request->input('end_complete_date'));
    }

    if (!empty($request->input('status'))) {
      $query->having('status', $request->input('status'));
    }

    return $query;
  }
}
