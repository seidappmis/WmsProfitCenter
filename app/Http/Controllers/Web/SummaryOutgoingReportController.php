<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\LogManifestHeader;
use App\Models\WMSBranchManifestHeader;
use DataTables;
use DB;
use Illuminate\Http\Request;

class SummaryOutgoingReportController extends Controller
{
  public function index(Request $request)
  {
    if ($request->ajax()) {
      $query = $this->getSummaryOutgoingReport($request);

      $datatables = DataTables::of($query)
      ;

      return $datatables->make(true);
    }

    return view('web.report.summary-outgoing-report.index');
  }

  public static function getSummaryOutgoingReport($request)
  {

    $query = WMSBranchManifestHeader::select(
      DB::raw('wms_pickinglist_detail.header_id AS picking_no'),
      'wms_branch_manifest_header.driver_register_id',
      'wms_branch_manifest_header.do_manifest_no',
      'wms_branch_manifest_header.expedition_code',
      'wms_branch_manifest_header.driver_id',
      'wms_branch_manifest_header.driver_name',
      'wms_branch_manifest_header.vehicle_number',
      'wms_branch_manifest_header.vehicle_code_type',
      'wms_branch_manifest_header.vehicle_description',
      'wms_branch_manifest_header.do_manifest_date',
      'wms_branch_manifest_header.do_manifest_time',
      'wms_branch_manifest_header.manifest_type',
      'wms_branch_manifest_header.checker',
      'wms_branch_manifest_header.destination_name_driver',
      'wms_branch_manifest_header.city_name',
      'wms_branch_manifest_header.city_code',
      'wms_branch_manifest_header.expedition_name',
      'wms_branch_manifest_header.container_no',
      'wms_branch_manifest_header.seal_no',
      'wms_branch_manifest_header.pdo_no',
      'wms_branch_manifest_header.created_at',
      'wms_branch_manifest_header.updated_at',
      'wms_branch_manifest_detail.invoice_no',
      'wms_branch_manifest_detail.delivery_no',
      'wms_branch_manifest_detail.lead_time',
      'wms_branch_manifest_detail.do_internal',
      'wms_branch_manifest_detail.delivery_items',
      'wms_branch_manifest_detail.do_date',
      'wms_branch_manifest_detail.reservasi_no',
      'wms_branch_manifest_detail.quantity',
      'wms_branch_manifest_detail.sold_to_code',
      'wms_branch_manifest_detail.sold_to',
      'wms_branch_manifest_detail.ship_to',
      'wms_branch_manifest_detail.ship_to_code',
      'wms_branch_manifest_detail.region',
      'wms_branch_manifest_detail.model',
      'wms_branch_manifest_detail.code_sales',
      'wms_branch_manifest_detail.status_confirm',
      'wms_branch_manifest_detail.confirm_date',
      'wms_branch_manifest_detail.actual_time_arrival',
      'wms_branch_manifest_detail.actual_unloading_date',
      'wms_branch_manifest_detail.doc_do_return_date',
      'wms_branch_manifest_detail.confirm_by',
      DB::raw('wms_branch_manifest_detail.do_reject AS status_reject'),
      DB::raw('DATE_ADD(do_manifest_date, INTERVAL wms_branch_manifest_detail.lead_time DAY) AS eta'),
      DB::raw('wms_branch_manifest_detail.cbm AS detail_cbm'),
      DB::raw('IF(wms_branch_manifest_detail.status_confirm, "Delivered", "") AS delivery_status'),
      DB::raw('IF(wms_branch_manifest_detail.status_confirm, "Confirmed", "") AS confirm'),
      DB::raw('(wms_branch_manifest_detail.cbm * wms_branch_manifest_detail.quantity) AS detail_total_cbm'),
      DB::raw('wms_master_model.description AS model_description'),
      DB::raw('IF(wms_branch_manifest_detail.status_confirm IS NULL, "", IF(wms_branch_manifest_detail.status_confirm = 1, "Confirmed", IF(wms_branch_manifest_detail.status_confirm = 0 && wms_branch_manifest_header.status_complete = 1, "Delivery", IF(wms_branch_manifest_detail.status_confirm = 0 && wms_branch_manifest_header.status_complete = 0, "Waiting Complete", "")))) AS status'),
      DB::raw('IF(wms_branch_manifest_detail.tcs IS NULL, "", IF(wms_branch_manifest_detail.tcs = 1, "TCS",IF(wms_branch_manifest_detail.tcs = 0 && wms_branch_manifest_detail.do_return = 0, "MANUAL", ""))) AS `desc`'),
      // DB::raw('uconfirm.username AS confirm_by'),
      DB::raw('uc.username AS created_by_name'),
      DB::raw('um.username AS updated_by_name')
    )
      ->leftjoin('wms_branch_manifest_detail', 'wms_branch_manifest_detail.do_manifest_no', '=', 'wms_branch_manifest_header.do_manifest_no')
      ->leftjoin('wms_pickinglist_header', 'wms_pickinglist_header.driver_register_id', '=', 'wms_branch_manifest_header.driver_register_id')
      ->leftjoin('wms_pickinglist_detail', function ($join) {
        $join->on('wms_pickinglist_detail.invoice_no', '=', 'wms_branch_manifest_detail.invoice_no');
        $join->on('wms_pickinglist_detail.delivery_no', '=', 'wms_branch_manifest_detail.delivery_no');
        $join->on('wms_pickinglist_detail.model', '=', 'wms_branch_manifest_detail.model');
        $join->on('wms_pickinglist_detail.header_id', '=', 'wms_pickinglist_header.id');
      })
      ->leftjoin('wms_master_model', 'wms_master_model.model_name', '=', 'wms_branch_manifest_detail.model')
      ->leftjoin(DB::raw('users AS uc'), 'uc.id', '=', 'wms_branch_manifest_header.created_by')
      ->leftjoin(DB::raw('users AS um'), 'um.id', '=', 'wms_branch_manifest_header.updated_by')
      ->leftjoin(DB::raw('users AS uconfirm'), 'uconfirm.id', '=', 'wms_branch_manifest_header.updated_by')
      ->groupBy('wms_branch_manifest_detail.id')
    ;

    $query->where('wms_branch_manifest_header.kode_cabang', $request->input('kode_cabang'));

    if (!empty($request->input('start_do_manifest_date'))) {
      $query->where('wms_branch_manifest_header.do_manifest_date', '>=', $request->input('start_do_manifest_date'));
    }
    if (!empty($request->input('end_do_manifest_date'))) {
      $query->where('wms_branch_manifest_header.do_manifest_date', '<=', $request->input('end_do_manifest_date'));
    }

    if (!empty($request->input('start_do_date'))) {
      $query->where('wms_branch_manifest_header.do_date', '>=', $request->input('start_do_date'));
    }
    if (!empty($request->input('end_do_date'))) {
      $query->where('wms_branch_manifest_header.do_date', '<=', $request->input('end_do_date'));
    }

    if (!empty($request->input('start_actual_time_arrival'))) {
      $query->where('wms_branch_manifest_detail.actual_time_arrival', '>=', $request->input('start_actual_time_arrival'));
    }
    if (!empty($request->input('end_actual_time_arrival'))) {
      $query->where('wms_branch_manifest_detail.actual_time_arrival', '<=', $request->input('end_actual_time_arrival'));
    }

    if (!empty($request->input('start_unloading_date'))) {
      $query->where('wms_branch_manifest_detail.actual_unloading_date', '>=', $request->input('start_unloading_date'));
    }
    if (!empty($request->input('end_unloading_date'))) {
      $query->where('wms_branch_manifest_detail.actual_unloading_date', '<=', $request->input('end_unloading_date'));
    }

    if (!empty($request->input('start_doc_do_return_date'))) {
      $query->where('wms_branch_manifest_detail.doc_do_return_date', '>=', $request->input('start_doc_do_return_date'));
    }
    if (!empty($request->input('end_doc_do_return_date'))) {
      $query->where('wms_branch_manifest_detail.doc_do_return_date', '<=', $request->input('end_doc_do_return_date'));
    }

    if (!empty($request->input('do_manifest_no'))) {
      $query->where('wms_branch_manifest_header.do_manifest_no', $request->input('do_manifest_no'));
    }

    if (!empty($request->input('invoice_no'))) {
      $query->where('wms_branch_manifest_detail.invoice_no', $request->input('invoice_no'));
    }

    if (!empty($request->input('delivery_no'))) {
      $query->where('wms_branch_manifest_detail.delivery_no', $request->input('delivery_no'));
    }

    if ($request->input('include_hq') == 'true' || $request->input('include_hq') == 'on') {
      $queryHQ = LogManifestHeader::select(
        DB::raw('wms_pickinglist_detail.header_id AS picking_no'),
        'log_manifest_header.driver_register_id',
        'log_manifest_header.do_manifest_no',
        'log_manifest_header.expedition_code',
        'log_manifest_header.driver_id',
        'log_manifest_header.driver_name',
        'log_manifest_header.vehicle_number',
        'log_manifest_header.vehicle_code_type',
        'log_manifest_header.vehicle_description',
        'log_manifest_header.do_manifest_date',
        'log_manifest_header.do_manifest_time',
        'log_manifest_header.manifest_type',
        'log_manifest_header.checker',
        'log_manifest_header.destination_name_driver',
        'log_manifest_header.city_name',
        'log_manifest_header.city_code',
        'log_manifest_header.expedition_name',
        'log_manifest_header.container_no',
        'log_manifest_header.seal_no',
        'log_manifest_header.pdo_no',
        'log_manifest_header.created_at',
        'log_manifest_header.updated_at',
        'log_manifest_detail.invoice_no',
        'log_manifest_detail.delivery_no',
        'log_manifest_detail.lead_time',
        'log_manifest_detail.do_internal',
        'log_manifest_detail.delivery_items',
        'log_manifest_detail.do_date',
        'log_manifest_detail.reservasi_no',
        'log_manifest_detail.quantity',
        'log_manifest_detail.sold_to_code',
        'log_manifest_detail.sold_to',
        'log_manifest_detail.ship_to',
        'log_manifest_detail.ship_to_code',
        'log_manifest_detail.region',
        'log_manifest_detail.model',
        'log_manifest_detail.code_sales',
        'log_manifest_detail.status_confirm',
        'log_manifest_detail.confirm_date',
        'log_manifest_detail.actual_time_arrival',
        DB::raw('log_manifest_detail.actual_loading_date AS actual_unloading_date'),
        'log_manifest_detail.doc_do_return_date',
        'log_manifest_detail.confirm_by',
        DB::raw('log_manifest_detail.do_reject AS status_reject'),
        DB::raw('DATE_ADD(do_manifest_date, INTERVAL log_manifest_detail.lead_time DAY) AS eta'),
        DB::raw('log_manifest_detail.cbm AS detail_cbm'),
        DB::raw('IF(log_manifest_detail.status_confirm, "Delivered", "") AS delivery_status'),
        DB::raw('IF(log_manifest_detail.status_confirm, "Confirmed", "") AS confirm'),
        DB::raw('(log_manifest_detail.cbm * log_manifest_detail.quantity) AS detail_total_cbm'),
        DB::raw('wms_master_model.description AS model_description'),
        DB::raw('IF(log_manifest_detail.status_confirm IS NULL, "", IF(log_manifest_detail.status_confirm = 1, "Confirmed", IF(log_manifest_detail.status_confirm = 0 && log_manifest_header.status_complete = 1, "Delivery", IF(log_manifest_detail.status_confirm = 0 && log_manifest_header.status_complete = 0, "Waiting Complete", "")))) AS status'),
        DB::raw('IF(log_manifest_detail.tcs IS NULL, "", IF(log_manifest_detail.tcs = 1, "TCS",IF(log_manifest_detail.tcs = 0 && log_manifest_detail.do_return = 0, "MANUAL", ""))) AS `desc`'),
        // DB::raw('log_manifest_detail.confirm_by AS confirm_by'),
        DB::raw('uc.username AS created_by_name'),
        DB::raw('um.username AS updated_by_name')
      )
        ->leftjoin('log_manifest_detail', 'log_manifest_detail.do_manifest_no', '=', 'log_manifest_header.do_manifest_no')
        ->leftjoin('wms_master_model', 'wms_master_model.model_name', '=', 'log_manifest_detail.model')
        ->leftjoin('wms_pickinglist_header', 'wms_pickinglist_header.driver_register_id', '=', 'log_manifest_header.driver_register_id')
        ->leftjoin('wms_pickinglist_detail', function ($join) {
          $join->on('wms_pickinglist_detail.invoice_no', '=', 'log_manifest_detail.invoice_no');
          $join->on('wms_pickinglist_detail.delivery_no', '=', 'log_manifest_detail.delivery_no');
          $join->on('wms_pickinglist_detail.model', '=', 'log_manifest_detail.model');
          $join->on('wms_pickinglist_detail.header_id', '=', 'wms_pickinglist_header.id');
        })
        ->leftjoin(DB::raw('users AS uc'), 'uc.id', '=', 'log_manifest_header.created_by')
        ->leftjoin(DB::raw('users AS um'), 'um.id', '=', 'log_manifest_header.updated_by')
      // ->leftjoin(DB::raw('users AS uconfirm'), 'uconfirm.id', '=', 'log_manifest_header.updated_by')
        ->groupBy('log_manifest_detail.id')
      ;

      if ($request->input('area') != 'All') {
        $queryHQ->where('log_manifest_header.area', $request->input('area'));
      }

      if ($request->input('do_received') == 'true') {
        $queryHQ->where('log_manifest_detail.kode_cabang', $request->input('kode_cabang'));
      }

      if (!empty($request->input('start_do_manifest_date'))) {
        $queryHQ->where('log_manifest_header.do_manifest_date', '>=', $request->input('start_do_manifest_date'));
      }
      if (!empty($request->input('end_do_manifest_date'))) {
        $queryHQ->where('log_manifest_header.do_manifest_date', '<=', $request->input('end_do_manifest_date'));
      }

      if (!empty($request->input('start_do_date'))) {
        $queryHQ->where('log_manifest_header.do_date', '>=', $request->input('start_do_date'));
      }
      if (!empty($request->input('end_do_date'))) {
        $queryHQ->where('log_manifest_header.do_date', '<=', $request->input('end_do_date'));
      }

      if (!empty($request->input('start_actual_time_arrival'))) {
        $queryHQ->where('log_manifest_detail.actual_time_arrival', '>=', $request->input('start_actual_time_arrival'));
      }
      if (!empty($request->input('end_actual_time_arrival'))) {
        $queryHQ->where('log_manifest_detail.actual_time_arrival', '<=', $request->input('end_actual_time_arrival'));
      }

      if (!empty($request->input('start_unloading_date'))) {
        $queryHQ->where('log_manifest_detail.actual_loading_date', '>=', $request->input('start_unloading_date'));
      }
      if (!empty($request->input('end_unloading_date'))) {
        $queryHQ->where('log_manifest_detail.actual_loading_date', '<=', $request->input('end_unloading_date'));
      }

      if (!empty($request->input('start_doc_do_return_date'))) {
        $queryHQ->where('log_manifest_detail.doc_do_return_date', '>=', $request->input('start_doc_do_return_date'));
      }
      if (!empty($request->input('end_doc_do_return_date'))) {
        $queryHQ->where('log_manifest_detail.doc_do_return_date', '<=', $request->input('end_doc_do_return_date'));
      }

      if (!empty($request->input('do_manifest_no'))) {
        $queryHQ->where('log_manifest_header.do_manifest_no', $request->input('do_manifest_no'));
      }

      if (!empty($request->input('invoice_no'))) {
        $queryHQ->where('log_manifest_detail.invoice_no', $request->input('invoice_no'));
      }

      if (!empty($request->input('delivery_no'))) {
        $queryHQ->where('log_manifest_detail.delivery_no', $request->input('delivery_no'));
      }

      $query->union($queryHQ);
    }

    return $query;
  }

  public function export(Request $request)
  {
    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet       = $spreadsheet->getActiveSheet();

    $col = 'A';
    $sheet->setCellValue(($col++) . '1', 'OUTGOING TYPE');
    $sheet->setCellValue(($col++) . '1', 'MANIFEST DATE');
    $sheet->setCellValue(($col++) . '1', 'MANIFEST NO');
    $sheet->setCellValue(($col++) . '1', 'PICKING LIST NO');
    $sheet->setCellValue(($col++) . '1', 'SHIPMENT NO');
    $sheet->setCellValue(($col++) . '1', 'DO NO');
    $sheet->setCellValue(($col++) . '1', 'DO INTERNAL');
    $sheet->setCellValue(($col++) . '1', 'RESERVATION NO');
    $sheet->setCellValue(($col++) . '1', 'DO DATE');
    $sheet->setCellValue(($col++) . '1', 'ITEM');
    $sheet->setCellValue(($col++) . '1', 'ETD');
    $sheet->setCellValue(($col++) . '1', 'ETA');
    $sheet->setCellValue(($col++) . '1', 'LEAD TIME');
    $sheet->setCellValue(($col++) . '1', 'CHECKER');
    $sheet->setCellValue(($col++) . '1', 'SOLD TO CODE');
    $sheet->setCellValue(($col++) . '1', 'SOLD TO DETAIL');
    $sheet->setCellValue(($col++) . '1', 'SHIP TO CODE');
    $sheet->setCellValue(($col++) . '1', 'SHIP TO DETAIL');
    $sheet->setCellValue(($col++) . '1', 'REGION');
    $sheet->setCellValue(($col++) . '1', 'DESTINATION MANIFEST');
    $sheet->setCellValue(($col++) . '1', 'DESTINATION DO');
    $sheet->setCellValue(($col++) . '1', 'MODEL');
    $sheet->setCellValue(($col++) . '1', 'MODEL DESCRIPTION');
    $sheet->setCellValue(($col++) . '1', 'QUANTITY');
    $sheet->setCellValue(($col++) . '1', 'CBM');
    $sheet->setCellValue(($col++) . '1', 'TOTAL CBM');
    $sheet->setCellValue(($col++) . '1', 'TRANSPORTER CODE');
    $sheet->setCellValue(($col++) . '1', 'TRANSPORTER DETAIL');
    $sheet->setCellValue(($col++) . '1', 'VEHICLE NO');
    $sheet->setCellValue(($col++) . '1', 'VEHICLE TYPE');
    $sheet->setCellValue(($col++) . '1', 'VEHICLE DESCRIPTION');
    $sheet->setCellValue(($col++) . '1', 'CONT NO');
    $sheet->setCellValue(($col++) . '1', 'SEAL NO');
    $sheet->setCellValue(($col++) . '1', 'PDO NO');
    $sheet->setCellValue(($col++) . '1', 'CODE SALES');
    $sheet->setCellValue(($col++) . '1', 'STATUS');
    $sheet->setCellValue(($col++) . '1', 'CREATED BY');
    $sheet->setCellValue(($col++) . '1', 'CREATED DATE');
    $sheet->setCellValue(($col++) . '1', 'MODIFY BY');
    $sheet->setCellValue(($col++) . '1', 'MODIFY DATE');
    $sheet->setCellValue(($col++) . '1', 'DESC');
    $sheet->setCellValue(($col++) . '1', 'DELIVERY STATUS');
    $sheet->setCellValue(($col++) . '1', 'CONFIRM');
    $sheet->setCellValue(($col++) . '1', 'STATUS CONFIRM');
    $sheet->setCellValue(($col++) . '1', 'CONFIRM BY');
    $sheet->setCellValue(($col++) . '1', 'CONFIRM DATE');
    $sheet->setCellValue(($col++) . '1', 'ACTUAL TIME ARRIVAL');
    $sheet->setCellValue(($col++) . '1', 'ACTUAL UNLOADING DATE');
    $sheet->setCellValue(($col++) . '1', 'DOC DO RETURN DATE');
    $sheet->setCellValue(($col) . '1', 'STATUS REJECT');

    // getPHPSpreadsheetTitleStyle() ada di wms Helper
    $sheet->getStyle('A1:' . ($col) . '1')->applyFromArray(getPHPSpreadsheetTitleStyle());

    $data = $this->getSummaryOutgoingReport($request)
      ->get();

    $row = 2;
    foreach ($data as $key => $value) {
      $col = 'A';
      $sheet->setCellValue(($col++) . $row, $value->manifest_type);
      $sheet->setCellValue(($col++) . $row, $value->do_manifest_date);
      $sheet->setCellValue(($col++) . $row, $value->do_manifest_no);
      $sheet->setCellValue(($col++) . $row, $value->picking_no);
      $sheet->setCellValue(($col++) . $row, $value->invoice_no);
      $sheet->setCellValue(($col++) . $row, $value->delivery_no);
      $sheet->setCellValue(($col++) . $row, $value->do_internal);
      $sheet->setCellValue(($col++) . $row, $value->reservasi_no);
      $sheet->setCellValue(($col++) . $row, $value->do_date);
      $sheet->setCellValue(($col++) . $row, $value->delivery_items);
      $sheet->setCellValue(($col++) . $row, $value->do_manifest_date);
      $sheet->setCellValue(($col++) . $row, $value->eta);
      $sheet->setCellValue(($col++) . $row, $value->lead_time);
      $sheet->setCellValue(($col++) . $row, $value->checker);
      $sheet->setCellValue(($col++) . $row, $value->sold_to_code);
      $sheet->setCellValue(($col++) . $row, $value->sold_to);
      $sheet->setCellValue(($col++) . $row, $value->ship_to_code);
      $sheet->setCellValue(($col++) . $row, $value->ship_to);
      $sheet->setCellValue(($col++) . $row, $value->region);
      $sheet->setCellValue(($col++) . $row, $value->destination_name_driver);
      $sheet->setCellValue(($col++) . $row, $value->city_name);
      $sheet->setCellValue(($col++) . $row, $value->model);
      $sheet->setCellValue(($col++) . $row, $value->model_description);
      $sheet->setCellValue(($col++) . $row, $value->quantity);
      $sheet->setCellValue(($col++) . $row, $value->detail_cbm);
      $sheet->setCellValue(($col++) . $row, $value->detail_total_cbm);
      $sheet->setCellValue(($col++) . $row, $value->expedition_code);
      $sheet->setCellValue(($col++) . $row, $value->expedition_name);
      $sheet->setCellValue(($col++) . $row, $value->vehicle_number);
      $sheet->setCellValue(($col++) . $row, $value->vehicle_code_type);
      $sheet->setCellValue(($col++) . $row, $value->vehicle_description);
      $sheet->setCellValue(($col++) . $row, $value->container_no);
      $sheet->setCellValue(($col++) . $row, $value->seal_no);
      $sheet->setCellValue(($col++) . $row, $value->pdo_no);
      $sheet->setCellValue(($col++) . $row, $value->code_sales);
      $sheet->setCellValue(($col++) . $row, $value->status);
      $sheet->setCellValue(($col++) . $row, $value->created_by_name);
      $sheet->setCellValue(($col++) . $row, $value->created_at);
      $sheet->setCellValue(($col++) . $row, $value->updated_by_name);
      $sheet->setCellValue(($col++) . $row, $value->updated_at);
      $sheet->setCellValue(($col++) . $row, $value->desc);
      $sheet->setCellValue(($col++) . $row, $value->delivery_status);
      $sheet->setCellValue(($col++) . $row, $value->confirm);
      $sheet->setCellValue(($col++) . $row, $value->status_confirm);
      $sheet->setCellValue(($col++) . $row, $value->confirm_by);
      $sheet->setCellValue(($col++) . $row, $value->confirm_date);
      $sheet->setCellValue(($col++) . $row, $value->actual_time_arrival);
      $sheet->setCellValue(($col++) . $row, $value->actual_unloading_date);
      $sheet->setCellValue(($col++) . $row, $value->doc_do_return_date);
      $sheet->setCellValue(($col++) . $row, $value->status_reject);
      $row++;
    }

    $sheet->getColumnDimension('A')->setAutoSize(true);
    $sheet->getColumnDimension('B')->setAutoSize(true);
    $sheet->getColumnDimension('C')->setAutoSize(true);
    $sheet->getColumnDimension('D')->setAutoSize(true);
    $sheet->getColumnDimension('E')->setAutoSize(true);
    $sheet->getColumnDimension('F')->setAutoSize(true);

    $title = 'Summary Outgoing Report ' . $request->input('area');

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
