<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\MovementTransactionLog;
use DataTables;
use DB;
use Illuminate\Http\Request;

class ReportInventoryMovementController extends Controller
{
  public function index(Request $request)
  {
    if ($request->ajax()) {
      $query = $this->getData($request);

      $datatables = DataTables::of($query)
        ->addIndexColumn() //DT_RowIndex (Penomoran)
        ->editColumn('created_at', function ($data) {
          return date('d/m/Y', strtotime($data->created_at));
        })
        ->editColumn('quantity', function ($data) {
          return $data->action == 'INCREASE' ? $data->quantity : ($data->quantity * (-1));
        })
        ->addColumn('debit_credit', function ($data) {
          return $data->action == 'INCREASE' ? 'S' : 'H';
        })
      ;

      return $datatables->make(true);
    }

    return view('web.report.report-inventory-movement.index');
  }

  public function export(Request $request)
  {
    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet       = $spreadsheet->getActiveSheet();

    $col = 'A';
    $sheet->setCellValue(($col++) . '1', 'Transaction ID');
    $sheet->setCellValue(($col++) . '1', 'Transaction Date');
    $sheet->setCellValue(($col++) . '1', 'Model');
    $sheet->setCellValue(($col++) . '1', 'QTY');
    $sheet->setCellValue(($col++) . '1', 'Debit/Credit');
    $sheet->setCellValue(($col++) . '1', 'Branch Code');
    $sheet->setCellValue(($col++) . '1', 'Branch');
    $sheet->setCellValue(($col++) . '1', 'Storage Location');
    $sheet->setCellValue(($col++) . '1', 'Movement Type');
    $sheet->setCellValue(($col++) . '1', 'Picking No');
    $sheet->setCellValue(($col++) . '1', 'Manifest No');
    $sheet->setCellValue(($col++) . '1', 'Ship to Code');
    $sheet->setCellValue(($col) . '1', 'User');
    // getPHPSpreadsheetTitleStyle() ada di wms Helper
    $sheet->getStyle('A1:' . ($col) . '1')->applyFromArray(getPHPSpreadsheetTitleStyle());

    $data = $this->getData($request)->get();

    $row = 2;
    foreach ($data as $key => $value) {
      $col = 'A';
      $sheet->setCellValue(($col++) . $row, ($key + 1));
      $sheet->setCellValue(($col++) . $row, $value->log_id);
      $sheet->setCellValue(($col++) . $row, $value->created_at);
      $sheet->setCellValue(($col++) . $row, $value->model);
      $sheet->setCellValue(($col++) . $row, $value->quantity);
      $sheet->setCellValue(($col++) . $row, $value->debit_credit);
      $sheet->setCellValue(($col++) . $row, $value->kode_customer);
      $sheet->setCellValue(($col++) . $row, $value->long_description);
      $sheet->setCellValue(($col++) . $row, $value->storage_location);
      $sheet->setCellValue(($col++) . $row, $value->movement_code);
      $sheet->setCellValue(($col++) . $row, $value->arrival_no);
      $sheet->setCellValue(($col++) . $row, $value->do_manifest_no);
      $sheet->setCellValue(($col++) . $row, $value->ship_to_code);
      $sheet->setCellValue(($col++) . $row, $value->username);
      $row++;
    }

    $sheet->getColumnDimension('A')->setAutoSize(true);
    $sheet->getColumnDimension('B')->setAutoSize(true);
    $sheet->getColumnDimension('C')->setAutoSize(true);
    $sheet->getColumnDimension('D')->setAutoSize(true);
    $sheet->getColumnDimension('E')->setAutoSize(true);
    $sheet->getColumnDimension('F')->setAutoSize(true);

    $title = 'Report Stock Inventory ';

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
    $query = MovementTransactionLog::select(
      'wms_movement_transaction_log.*',
      'log_cabang.kode_customer',
      'log_cabang.long_description',
      'log_manifest_detail.ship_to_code',
      'users.username',
      'wms_master_movement_type.action',
      DB::raw('CASE WHEN wms_master_movement_type.action = "INCREASE" THEN wms_movement_transaction_log.storage_location_to ELSE wms_movement_transaction_log.storage_location_from END AS storage_location')
    )
      ->leftjoin('wms_master_movement_type', 'wms_master_movement_type.id', '=', 'wms_movement_transaction_log.mvt_master_id')
      ->leftjoin('log_manifest_detail', function ($join) {
        $join->on('log_manifest_detail.do_manifest_no', '=', 'wms_movement_transaction_log.do_manifest_no');
        $join->on('log_manifest_detail.model', '=', 'wms_movement_transaction_log.model');
      })
      ->leftjoin('log_cabang', 'log_cabang.kode_cabang', '=', 'wms_movement_transaction_log.kode_cabang')
      ->leftjoin('users', 'users.id', '=', 'wms_movement_transaction_log.created_by')
    ;

    $query->where('wms_movement_transaction_log.kode_cabang', $request->input('kode_cabang'));
    $query->where('wms_movement_transaction_log.created_at', '>=', date('Y-m-d', strtotime($request->input('start_date'))));
    $query->where('wms_movement_transaction_log.created_at', '<=', date('Y-m-d', strtotime($request->input('end_date'))));

    if (!empty($request->input('model'))) {
      $query->where('wms_movement_transaction_log.model', $request->input('model'));
    }

    if (!empty($request->input('movement_code'))) {
      $query->where('wms_movement_transaction_log.movement_code', $request->input('movement_code'));
    }

    if (!empty($request->input('storage_location'))) {
      $query->having('storage_location', $request->input('storage_location'));
    }

    return $query;
  }
}
