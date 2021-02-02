<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\LOGConceptOverload;
use DataTables;
use Illuminate\Http\Request;

class ReportOverloadConceptOrDOController extends Controller
{
  public function index(Request $request)
  {
    if ($request->ajax()) {
      $query = $this->getOverloadConceptOrDOData($request);

      $datatables = DataTables::of($query)
        ->editColumn('created_at', function ($data) {
          return $data->created_at;
        })
      ;

      return $datatables->make(true);
    }

    return view('web.report.report-overload-concept-or-do.index');
  }

  public function export(Request $request)
  {
    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet       = $spreadsheet->getActiveSheet();

    $col = 'A';
    $sheet->setCellValue(($col++) . '1', 'AREA');
    $sheet->setCellValue(($col++) . '1', 'INVOICE');
    $sheet->setCellValue(($col++) . '1', 'LINE NO');
    $sheet->setCellValue(($col++) . '1', 'OUTPUT DATE');
    $sheet->setCellValue(($col++) . '1', 'OUTPUT TIME');
    $sheet->setCellValue(($col++) . '1', 'DESTINATION NUMBER');
    $sheet->setCellValue(($col++) . '1', 'VEHICLE CODE TYPE');
    $sheet->setCellValue(($col++) . '1', 'CAR NO');
    $sheet->setCellValue(($col++) . '1', 'CONT NO');
    $sheet->setCellValue(($col++) . '1', 'CHECKIN DATE');
    $sheet->setCellValue(($col++) . '1', 'CHECKIN TIME');
    $sheet->setCellValue(($col++) . '1', 'EXPEDITION ID');
    $sheet->setCellValue(($col++) . '1', 'DELIVERY NO');
    $sheet->setCellValue(($col++) . '1', 'DELIVERY ITEMS');
    $sheet->setCellValue(($col++) . '1', 'MODEL');
    $sheet->setCellValue(($col++) . '1', 'QUANTITY');
    $sheet->setCellValue(($col++) . '1', 'CBM');
    $sheet->setCellValue(($col++) . '1', 'SHIP TO');
    $sheet->setCellValue(($col++) . '1', 'SOLD TO');
    $sheet->setCellValue(($col++) . '1', 'SHIP TO CITY');
    $sheet->setCellValue(($col++) . '1', 'SHIP TO DISTRICT');
    $sheet->setCellValue(($col++) . '1', 'SHIP TO STREET');
    $sheet->setCellValue(($col++) . '1', 'SOLD TO CITY');
    $sheet->setCellValue(($col++) . '1', 'SOLD TO DISTRIC');
    $sheet->setCellValue(($col++) . '1', 'SOLD TO STREET');
    $sheet->setCellValue(($col++) . '1', 'REMARKS');
    $sheet->setCellValue(($col++) . '1', 'CREATED DATE');
    $sheet->setCellValue(($col++) . '1', 'CREATED BY');
    $sheet->setCellValue(($col++) . '1', 'SPLIT DATE');
    $sheet->setCellValue(($col++) . '1', 'SPLIT BY');
    $sheet->setCellValue(($col++) . '1', 'AREA');
    $sheet->setCellValue(($col++) . '1', 'CONCEPT TYPE');
    $sheet->setCellValue(($col++) . '1', 'EXPEDITION NAME');
    $sheet->setCellValue(($col++) . '1', 'SOLD TO CODE');
    $sheet->setCellValue(($col++) . '1', 'SHIP TO CODE');
    $sheet->setCellValue(($col++) . '1', 'EXPEDITION CODE');
    $sheet->setCellValue(($col++) . '1', 'CODE SALES');
    $sheet->setCellValue(($col++) . '1', 'STATUS CONFIRM');
    $sheet->setCellValue(($col++) . '1', 'CONFIRM BY');
    $sheet->setCellValue(($col++) . '1', 'CONFIRM DATE');
    $sheet->setCellValue(($col++) . '1', 'OVERLOAD REASON');
    $sheet->setCellValue(($col++) . '1', 'QUANTITY BEFORE');
    $sheet->setCellValue(($col) . '1', 'CBM BEFORE');

    // getPHPSpreadsheetTitleStyle() ada di wms Helper
    $sheet->getStyle('A1:' . ($col) . '1')->applyFromArray(getPHPSpreadsheetTitleStyle());

    $data = $this->getOverloadConceptOrDOData($request)->get();

    $row = 2;
    foreach ($data as $key => $value) {
      $col = 'A';
      $sheet->setCellValue(($col++) . $row, $value->area);
      $sheet->setCellValue(($col++) . $row, $value->invoice_no);
      $sheet->setCellValue(($col++) . $row, $value->line_no);
      $sheet->setCellValue(($col++) . $row, $value->output_date);
      $sheet->setCellValue(($col++) . $row, $value->output_time);
      $sheet->setCellValue(($col++) . $row, $value->destination_number);
      $sheet->setCellValue(($col++) . $row, $value->vehicle_code_type);
      $sheet->setCellValue(($col++) . $row, $value->car_no);
      $sheet->setCellValue(($col++) . $row, $value->cont_no);
      $sheet->setCellValue(($col++) . $row, $value->checkin_date);
      $sheet->setCellValue(($col++) . $row, $value->checkin_time);
      $sheet->setCellValue(($col++) . $row, $value->expedition_id);
      $sheet->setCellValue(($col++) . $row, $value->delivery_no);
      $sheet->setCellValue(($col++) . $row, $value->delivery_items);
      $sheet->setCellValue(($col++) . $row, $value->model);
      $sheet->setCellValue(($col++) . $row, $value->quantity);
      $sheet->setCellValue(($col++) . $row, $value->cbm);
      $sheet->setCellValue(($col++) . $row, $value->ship_to);
      $sheet->setCellValue(($col++) . $row, $value->sold_to);
      $sheet->setCellValue(($col++) . $row, $value->ship_to_city);
      $sheet->setCellValue(($col++) . $row, $value->ship_to_district);
      $sheet->setCellValue(($col++) . $row, $value->ship_to_street);
      $sheet->setCellValue(($col++) . $row, $value->sold_to_city);
      $sheet->setCellValue(($col++) . $row, $value->sold_to_district);
      $sheet->setCellValue(($col++) . $row, $value->sold_to_street);
      $sheet->setCellValue(($col++) . $row, $value->remarks);
      $spreadsheet->getActiveSheet()->getStyle(($col) . $row)
        ->getNumberFormat()
        ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_YYYYMMDDSLASH);
      $sheet->setCellValue(($col++) . $row, format_tanggal_jam_wms($value->created_at));
      $sheet->setCellValue(($col++) . $row, $value->created_by);
      $spreadsheet->getActiveSheet()->getStyle(($col) . $row)
        ->getNumberFormat()
        ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_YYYYMMDDSLASH);
      $sheet->setCellValue(($col++) . $row, format_tanggal_jam_wms($value->split_date));
      $sheet->setCellValue(($col++) . $row, $value->split_by);
      $sheet->setCellValue(($col++) . $row, $value->area);
      $sheet->setCellValue(($col++) . $row, $value->concept_type);
      $sheet->setCellValue(($col++) . $row, $value->expedition_name);
      $sheet->setCellValue(($col++) . $row, $value->sold_to_code);
      $sheet->setCellValue(($col++) . $row, $value->ship_to_code);
      $sheet->setCellValue(($col++) . $row, $value->expedition_code);
      $sheet->setCellValue(($col++) . $row, $value->code_sales);
      $sheet->setCellValue(($col++) . $row, $value->status_confirm);
      $sheet->setCellValue(($col++) . $row, $value->confirm_by);
      $sheet->setCellValue(($col++) . $row, $value->confirm_date);
      $sheet->setCellValue(($col++) . $row, $value->overload_reason);
      $sheet->setCellValue(($col++) . $row, $value->quantity_before);
      $sheet->setCellValue(($col++) . $row, $value->cbm_before);
      $row++;
    }

    $colResize = 'A';
    while ($colResize != $col) {
      $sheet->getColumnDimension($colResize++)->setAutoSize(true);
    }

    $title = 'Report Overload Concept or DO ' . $request->input('area');

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

  protected function getOverloadConceptOrDOData($request)
  {
    $query = LOGConceptOverload::select(
      'log_concept_overload.*'
    )
    ;

    if (auth()->user()->cabang->hq) {
      $query->where('log_concept_overload.area', $request->input('area'));
    } else {
      $query->leftjoin('wms_manual_concept', function($join){
        $join->on('wms_manual_concept.invoice_no', '=', 'log_concept_overload.invoice_no');
        $join->on('wms_manual_concept.delivery_no', '=', 'log_concept_overload.delivery_no');
        $join->on('wms_manual_concept.delivery_items', '=', 'log_concept_overload.delivery_items');
      })
      ->where('wms_manual_concept.kode_cabang', $request->input('kode_cabang'));
    }
    $query->where('log_concept_overload.created_at', '>=', date('Y-m-d', strtotime($request->input('start_date'))));
    $query->where('log_concept_overload.created_at', '<=', date('Y-m-d', strtotime($request->input('end_date')))  . '  23:59:59');

    return $query;
  }
}
