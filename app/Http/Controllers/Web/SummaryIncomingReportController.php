<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\IncomingManualDetail;
use App\Models\FinishGoodDetail;
use DataTables;
use DB;
use Illuminate\Http\Request;

class SummaryIncomingReportController extends Controller
{
  public function index(Request $request)
  {
    if ($request->ajax()) {
      $query = $this->getSummaryIncomingReport($request);

      $datatables = DataTables::of($query)
        ->editColumn('created_at', function ($data) {
          return format_tanggal_jam_wms($data->created_at);
        })
      ;

      return $datatables->make(true);
    }

    return view('web.report.summary-incoming-report.index');
  }

  public function export(Request $request)
  {
    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet       = $spreadsheet->getActiveSheet();

    $col = 'A';
    $sheet->setCellValue(($col++) . '1', 'RECEIPT NO');
    $sheet->setCellValue(($col++) . '1', 'DELIVERY TICKET');
    $sheet->setCellValue(($col++) . '1', 'TYPE');
    $sheet->setCellValue(($col++) . '1', 'EAN CODE');
    $sheet->setCellValue(($col++) . '1', 'CONTAINER NO');
    $sheet->setCellValue(($col++) . '1', 'INVOICE NO');
    $sheet->setCellValue(($col++) . '1', 'NO GR SAP');
    $sheet->setCellValue(($col++) . '1', 'DOCUMENT DATE');
    $sheet->setCellValue(($col++) . '1', 'SUPPLIER');
    $sheet->setCellValue(($col++) . '1', 'EXPEDITION');
    $sheet->setCellValue(($col++) . '1', 'WAREHOUSE');
    $sheet->setCellValue(($col++) . '1', 'AREA');
    $sheet->setCellValue(($col++) . '1', 'MODEL');
    $sheet->setCellValue(($col++) . '1', 'DESCRIPTION');
    $sheet->setCellValue(($col++) . '1', 'QUANTITY');
    $sheet->setCellValue(($col++) . '1', 'CBM');
    $sheet->setCellValue(($col++) . '1', 'TOTAL CBM');
    $sheet->setCellValue(($col++) . '1', 'STORAGE LOCATION');
    $sheet->setCellValue(($col++) . '1', 'CREATED DATE');
    $sheet->setCellValue(($col) . '1', 'CREATED BY');

    // getPHPSpreadsheetTitleStyle() ada di wms Helper
    $sheet->getStyle('A1:' . ($col) . '1')->applyFromArray(getPHPSpreadsheetTitleStyle());

    $data = $this->getSummaryIncomingReport($request)
      ->get();

    $row = 2;
    foreach ($data as $key => $value) {
      $col = 'A';
      $sheet->setCellValue(($col++) . $row, $value->receipt_no);
      $sheet->setCellValue(($col++) . $row, $value->delivery_ticket);
      $sheet->setCellValue(($col++) . $row, $value->type);
      $sheet->getStyle($col . $row)->getNumberFormat()->setFormatCode('#');
      $sheet->setCellValue(($col++) . $row, $value->ean_code);
      $sheet->setCellValue(($col++) . $row, $value->container_no);
      $sheet->setCellValue(($col++) . $row, $value->invoice_no);
      $sheet->setCellValue(($col++) . $row, $value->no_gr_sap);
      $spreadsheet->getActiveSheet()->getStyle(($col) . $row)
        ->getNumberFormat()
        ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_YYYYMMDDSLASH);
      $sheet->setCellValue(($col++) . $row, format_tanggal_wms($value->document_date));
      $sheet->setCellValue(($col++) . $row, $value->vendor_name);
      $sheet->setCellValue(($col++) . $row, $value->expedition_name);
      $sheet->setCellValue(($col++) . $row, $value->area);
      $sheet->setCellValue(($col++) . $row, $value->area);
      $sheet->setCellValue(($col++) . $row, $value->model);
      $sheet->setCellValue(($col++) . $row, $value->description);
      $sheet->setCellValue(($col++) . $row, $value->qty);
      $sheet->setCellValue(($col++) . $row, $value->cbm);
      $sheet->setCellValue(($col++) . $row, $value->total_cbm);
      $sheet->setCellValue(($col++) . $row, $value->storage_location);
      $spreadsheet->getActiveSheet()->getStyle(($col) . $row)
        ->getNumberFormat()
        ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_YYYYMMDDSLASH);
      $sheet->setCellValue(($col++) . $row, format_tanggal_jam_wms($value->created_at));
      $sheet->setCellValue(($col++) . $row, $value->created_by_name);
      $row++;
    }

    $colResize = 'A';
    while ($colResize != $col) {
      $sheet->getColumnDimension($colResize++)->setAutoSize(true);
    }

    $title = 'Summary Incoming Report ' . $request->input('area');

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

  protected function getSummaryIncomingReport($request)
  {
    $queryManual = IncomingManualDetail::select(
      'log_incoming_manual_detail.model',
      'log_incoming_manual_detail.no_gr_sap',
      'log_incoming_manual_detail.description',
      'log_incoming_manual_detail.qty',
      'log_incoming_manual_detail.cbm',
      'log_incoming_manual_detail.total_cbm',
      'wms_master_model.ean_code',
      'log_incoming_manual_header.invoice_no',
      'log_incoming_manual_header.document_date',
      'log_incoming_manual_header.vendor_name',
      'log_incoming_manual_header.expedition_name',
      'log_incoming_manual_header.area',
      'log_incoming_manual_header.container_no',
      DB::raw('log_incoming_manual_header.arrival_no AS receipt_no'),
      DB::raw('log_incoming_manual_header.inc_type AS type'),
      DB::raw('log_incoming_manual_header.po AS delivery_ticket'),
      DB::raw('wms_master_storage.sto_type_desc AS storage_location'),
      DB::raw('users.username AS created_by_name')
    )
      ->leftjoin('log_incoming_manual_header', 'log_incoming_manual_header.arrival_no', '=', 'log_incoming_manual_detail.arrival_no_header')
      ->leftjoin('wms_master_model', 'wms_master_model.model_name', '=', 'log_incoming_manual_detail.model')
      ->leftjoin('wms_master_storage', 'wms_master_storage.id', '=', 'log_incoming_manual_detail.storage_id')
      ->leftjoin('users', 'users.id', '=', 'log_incoming_manual_header.created_by')
    ;

    $queryManual->where('log_incoming_manual_header.created_at', '>=', date('Y-m-d', strtotime($request->input('start_date'))));
    $queryManual->where('log_incoming_manual_header.created_at', '<=', date('Y-m-d', strtotime($request->input('end_date')))  . '  23:59:59');
    
    $queryProduction = FinishGoodDetail::select(
      'log_finish_good_detail.model',
      DB::raw('"" AS no_gr_sap'),
      DB::raw('"" AS description'),
      DB::raw('log_finish_good_detail.quantity AS qty'),
      DB::raw('wms_master_model.cbm'),
      DB::raw('wms_master_model.cbm * log_finish_good_detail.quantity AS total_cbm'),
      'wms_master_model.ean_code',
      DB::raw('"" AS invoice_no'),
      DB::raw('"" AS document_date'),
      DB::raw('"" AS vendor_name'),
      DB::raw('"" AS expedition_name'),
      'log_finish_good_header.area',
      DB::raw('"" AS container_no'),
      DB::raw('log_finish_good_header.receipt_no AS receipt_no'),
      DB::raw('"PRODUCTION" AS type'),
      DB::raw('"" AS delivery_ticket'),
      DB::raw('wms_master_storage.sto_type_desc AS storage_location'),
      DB::raw('users.username AS created_by_name')
    )
    ->leftjoin('log_finish_good_header', 'log_finish_good_header.receipt_no', '=', 'log_finish_good_detail.receipt_no_header')
      ->leftjoin('wms_master_model', 'wms_master_model.model_name', '=', 'log_finish_good_detail.model')
      ->leftjoin('wms_master_storage', 'wms_master_storage.id', '=', 'log_finish_good_detail.storage_id')
      ->leftjoin('users', 'users.id', '=', 'log_finish_good_header.created_by')
    ;

    $queryProduction->where('log_finish_good_header.created_at', '>=', date('Y-m-d', strtotime($request->input('start_date'))));
    $queryProduction->where('log_finish_good_header.created_at', '<=', date('Y-m-d', strtotime($request->input('end_date')))  . '  23:59:59');

    if (!empty($request->input('area'))) {
      $queryManual->where('log_incoming_manual_header.area', $request->input('area'));
      $queryProduction->where('log_finish_good_header.area', $request->input('area'));
    }
    if (!empty($request->input('cabang'))) {
      $queryManual->where('log_incoming_manual_header.kode_cabang', $request->input('cabang'));
      $queryProduction->where('log_finish_good_header.kode_cabang', $request->input('cabang'));
    }

    if (!empty($request->input('model'))) {
      $queryManual->where('log_incoming_manual_detail.model', $request->input('model'));
      $queryProduction->where('log_finish_good_header.model', $request->input('model'));
    }


    if ($request->input('type') === 'all') {
      return $queryManual->union($queryProduction);
    } elseif ($request->input('type') === 'production') {
      return $queryProduction;
    } else {
      return $queryManual;
    }

  }
}
