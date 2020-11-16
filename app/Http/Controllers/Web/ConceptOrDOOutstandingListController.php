<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Concept;
use App\Models\ManualConcept;
use DataTables;
use DB;
use Illuminate\Http\Request;

class ConceptOrDOOutstandingListController extends Controller
{
  public function index(Request $request)
  {
    if ($request->ajax()) {
      $query = $this->getConceptorDOOutstandingList($request);

      $datatables = DataTables::of($query)
        ->editColumn('created_at', function ($data) {
          return format_tanggal_jam_wms($data->created_at);
        })
      ;

      return $datatables->make(true);
    }

    return view('web.report.concept-or-do-outstanding-list.index');
  }

  protected function getConceptorDOOutstandingList($request)
  {
    if ($request->input('type') == 'area') {
      $query = Concept::select(
        'tr_concept.*',
        DB::raw('tr_destination.destination_description AS destination_name'),
        DB::raw('users.username AS upload_by')
      )
        ->leftjoin('tr_destination', 'tr_destination.destination_number', '=', 'tr_concept.destination_number')
        ->leftjoin('users', 'users.id', '=', 'tr_concept.created_by')
        ->leftjoin('tr_concept_flow_detail', function ($join) {
          $join->on('tr_concept_flow_detail.invoice_no', '=', 'tr_concept.invoice_no');
          $join->on('tr_concept_flow_detail.line_no', '=', 'tr_concept.line_no');
        })
        ->whereNull('tr_concept_flow_detail.id_header')
        ->where('tr_concept.area', $request->input('area'))
      ;
      if (!empty($request->input('expedition_code'))) {
        $query->leftjoin('tr_expedition', 'tr_expedition.id', '=', 'tr_concept.expedition_id')
          ->where('tr_expedition.code', $request->input('expedition_code'));
      }

      if (!empty($request->input('invoice_no'))) {
        $query->where('tr_concept.invoice_no', $request->input('invoice_no'));
      }

      if (!empty($request->input('delivery_no'))) {
        $query->where('tr_concept.delivery_no', $request->input('delivery_no'));
      }

      if (!empty($request->input('start_upload_concept_date'))) {
        $query->where('tr_concept.created_at', '>=', $request->input('start_upload_concept_date'));
      }

      if (!empty($request->input('end_upload_concept_date'))) {
        $query->where('tr_concept.created_at', '<=', $request->input('end_upload_concept_date'));
      }

      if (!empty($request->input('vehicle_code_type'))) {
        $query->where('tr_concept.vehicle_code_type', $request->input('vehicle_code_type'));
      }

    } else {
      $query = ManualConcept::select(
        'wms_manual_concept.*'
      )
        ->leftjoin('wms_pickinglist_detail', function ($join) {
          $join->on('wms_pickinglist_detail.invoice_no', '=', 'wms_manual_concept.invoice_no');
          $join->on('wms_pickinglist_detail.delivery_no', '=', 'wms_manual_concept.delivery_no');
          $join->on('wms_pickinglist_detail.delivery_items', '=', 'wms_manual_concept.delivery_items');
        })
        ->whereNull('wms_pickinglist_detail.id')
        ->where('wms_manual_concept.kode_cabang', $request->input('branch'))
      ;

      if (!empty($request->input('invoice_no'))) {
        $query->where('wms_manual_concept.invoice_no', $request->input('invoice_no'));
      }

      if (!empty($request->input('delivery_no'))) {
        $query->where('wms_manual_concept.delivery_no', $request->input('delivery_no'));
      }

      if (!empty($request->input('start_upload_concept_date'))) {
        $query->where('wms_manual_concept.created_at', '>=', $request->input('start_upload_concept_date'));
      }

      if (!empty($request->input('end_upload_concept_date'))) {
        $query->where('wms_manual_concept.created_at', '<=', $request->input('end_upload_concept_date'));
      }
    }

    return $query;
  }

  public function export(Request $request)
  {
    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet       = $spreadsheet->getActiveSheet();

    if ($request->input('type') == 'area') {
      $col = 'A';
      $sheet->setCellValue(($col++) . '1', 'SHIPMENT NO');
      $sheet->setCellValue(($col++) . '1', 'LINE NO');
      $sheet->setCellValue(($col++) . '1', 'OUTPUT DATE');
      $sheet->setCellValue(($col++) . '1', 'OUTPUT TIME');
      $sheet->setCellValue(($col++) . '1', 'DESTINATION NAME');
      $sheet->setCellValue(($col++) . '1', 'VEHICLE CODE TYPE');
      $sheet->setCellValue(($col++) . '1', 'EXPEDITION NAME');
      $sheet->setCellValue(($col++) . '1', 'CAR NO');
      $sheet->setCellValue(($col++) . '1', 'CONT NO');
      $sheet->setCellValue(($col++) . '1', 'CHECKIN DATE');
      $sheet->setCellValue(($col++) . '1', 'CHECKIN TIME');
      $sheet->setCellValue(($col++) . '1', 'DELIVERY NO');
      $sheet->setCellValue(($col++) . '1', 'DELIVERY ITEMS');
      $sheet->setCellValue(($col++) . '1', 'MODEL');
      $sheet->setCellValue(($col++) . '1', 'QUANTITY');
      $sheet->setCellValue(($col++) . '1', 'CBM');
      $sheet->setCellValue(($col++) . '1', 'SHIP TO');
      $sheet->setCellValue(($col++) . '1', 'SOLD TO');
      $sheet->setCellValue(($col++) . '1', 'SHIP TO CITY');
      $sheet->setCellValue(($col++) . '1', 'SHIP TO DISTRICT');
      $sheet->setCellValue(($col++) . '1', 'SOLD TO CITY');
      $sheet->setCellValue(($col++) . '1', 'SOLD TO DISTRICT');
      $sheet->setCellValue(($col++) . '1', 'SOLD TO STREET');
      $sheet->setCellValue(($col++) . '1', 'REMARKS');
      $sheet->setCellValue(($col++) . '1', 'AREA');
      $sheet->setCellValue(($col++) . '1', 'UPLOAD DATE');
      $sheet->setCellValue(($col) . '1', 'UPLOAD BY');
      // getPHPSpreadsheetTitleStyle() ada di wms Helper
      $sheet->getStyle('A1:' . ($col) . '1')->applyFromArray(getPHPSpreadsheetTitleStyle());

      $data = $this->getConceptorDOOutstandingList($request)->get();

      $row = 2;
      foreach ($data as $key => $value) {
        $col = 'A';
        $sheet->setCellValue(($col++) . $row, $value->invoice_no);
        $sheet->setCellValue(($col++) . $row, $value->line_no);
        $sheet->setCellValue(($col++) . $row, $value->output_date);
        $sheet->setCellValue(($col++) . $row, $value->output_time);
        $sheet->setCellValue(($col++) . $row, $value->destination_name);
        $sheet->setCellValue(($col++) . $row, $value->vehicle_code_type);
        $sheet->setCellValue(($col++) . $row, $value->expedition_name);
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
        $sheet->setCellValue(($col++) . $row, $value->ship_to_district);
        $sheet->setCellValue(($col++) . $row, $value->sold_to_city);
        $sheet->setCellValue(($col++) . $row, $value->sold_to_district);
        $sheet->setCellValue(($col++) . $row, $value->sold_to_street);
        $sheet->setCellValue(($col++) . $row, $value->remarks);
        $sheet->setCellValue(($col++) . $row, $value->area);
        $sheet->setCellValue(($col++) . $row, format_tanggal_jam_wms($value->created_at));
        $sheet->setCellValue(($col++) . $row, $value->upload_by);
        $row++;
      }

      $colResize = 'A';
      while($colResize != $col){
        $sheet->getColumnDimension($colResize++)->setAutoSize(true);
      }
      
    } else {
      $col = 'A';
      $sheet->setCellValue(($col++) . '1', 'INVOICE NO');
      $sheet->setCellValue(($col++) . '1', 'DELIVERY NO');
      $sheet->setCellValue(($col++) . '1', 'DELIVERY ITEMS');
      $sheet->setCellValue(($col++) . '1', 'DO DATE');
      $sheet->setCellValue(($col++) . '1', 'KODE CUSTOMER');
      $sheet->setCellValue(($col++) . '1', 'LONG DESCRIPTION CUSTOMER');
      $sheet->setCellValue(($col++) . '1', 'MODEL');
      $sheet->setCellValue(($col++) . '1', 'EAN CODE');
      $sheet->setCellValue(($col++) . '1', 'QUANTITY');
      $sheet->setCellValue(($col++) . '1', 'CBM');
      $sheet->setCellValue(($col++) . '1', 'CREATED DATE');
      $sheet->setCellValue(($col++) . '1', 'CREATED BY');
      $sheet->setCellValue(($col++) . '1', 'CODE SALES');
      $sheet->setCellValue(($col++) . '1', 'AREA');
      $sheet->setCellValue(($col++) . '1', 'KODE CABANG');
      $sheet->setCellValue(($col++) . '1', 'SPLIT DATE');
      $sheet->setCellValue(($col++) . '1', 'SPLIT BY');
      $sheet->setCellValue(($col) . '1', 'REMARKS');
      // getPHPSpreadsheetTitleStyle() ada di wms Helper
      $sheet->getStyle('A1:' . ($col) . '1')->applyFromArray(getPHPSpreadsheetTitleStyle());

      $data = $this->getConceptorDOOutstandingList($request)->get();

      $row = 2;
      foreach ($data as $key => $value) {
        $col = 'A';
        $sheet->setCellValue(($col++) . $row, $value->invoice_no);
        $sheet->setCellValue(($col++) . $row, $value->delivery_no);
        $sheet->setCellValue(($col++) . $row, $value->delivery_items);
        $sheet->setCellValue(($col++) . $row, $value->do_date);
        $sheet->setCellValue(($col++) . $row, $value->kode_customer);
        $sheet->setCellValue(($col++) . $row, $value->long_description_customer);
        $sheet->setCellValue(($col++) . $row, $value->model);
        $sheet->setCellValue(($col++) . $row, $value->ean_code);
        $sheet->setCellValue(($col++) . $row, $value->quantity);
        $sheet->setCellValue(($col++) . $row, $value->cbm);
        $sheet->setCellValue(($col++) . $row, format_tanggal_jam_wms($value->created_at));
        $sheet->setCellValue(($col++) . $row, $value->created_by);
        $sheet->setCellValue(($col++) . $row, $value->code_sales);
        $sheet->setCellValue(($col++) . $row, $value->area);
        $sheet->setCellValue(($col++) . $row, $value->kode_cabang);
        $sheet->setCellValue(($col++) . $row, $value->split_date);
        $sheet->setCellValue(($col++) . $row, $value->split_by);
        $sheet->setCellValue(($col++) . $row, $value->remarks);
        $row++;
      }

      $colResize = 'A';
      while($colResize != $col){
        $sheet->getColumnDimension($colResize++)->setAutoSize(true);
      }

    }

    $title = 'Concept or DO Outstanding List ' . $request->input('area');

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
