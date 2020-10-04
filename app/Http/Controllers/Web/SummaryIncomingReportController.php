<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\IncomingManualDetail;
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
          return $data->created_at;
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
      $sheet->setCellValue(($col++) . $row, $value->ean_code);
      $sheet->setCellValue(($col++) . $row, $value->invoice_no);
      $sheet->setCellValue(($col++) . $row, $value->no_gr_sap);
      $sheet->setCellValue(($col++) . $row, $value->document_date);
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
      $sheet->setCellValue(($col++) . $row, $value->created_at);
      $sheet->setCellValue(($col++) . $row, $value->created_by_name);
      $row++;
    }

    $sheet->getColumnDimension('A')->setAutoSize(true);
    $sheet->getColumnDimension('B')->setAutoSize(true);
    $sheet->getColumnDimension('C')->setAutoSize(true);
    $sheet->getColumnDimension('D')->setAutoSize(true);
    $sheet->getColumnDimension('E')->setAutoSize(true);
    $sheet->getColumnDimension('F')->setAutoSize(true);

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
    $query = IncomingManualDetail::select(
      'log_incoming_manual_detail.*',
      'wms_master_model.ean_code',
      'log_incoming_manual_header.invoice_no',
      'log_incoming_manual_header.document_date',
      'log_incoming_manual_header.vendor_name',
      'log_incoming_manual_header.expedition_name',
      'log_incoming_manual_header.area',
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

    $query->where('log_incoming_manual_header.created_at', '>=', date('Y-m-d', strtotime($request->input('start_date'))));
    $query->where('log_incoming_manual_header.created_at', '<=', date('Y-m-d', strtotime($request->input('end_date'))));

    if (!empty($request->input('area'))) {
      $query->where('log_incoming_manual_header.area', $request->input('area'));
    }
    if (!empty($request->input('cabang'))) {
      $query->where('log_incoming_manual_header.kode_cabang', $request->input('cabang'));
    }

    return $query;
  }
}
