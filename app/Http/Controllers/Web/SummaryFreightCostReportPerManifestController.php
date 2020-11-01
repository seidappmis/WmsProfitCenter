<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use DataTables;
use DB;
use Illuminate\Http\Request;

class SummaryFreightCostReportPerManifestController extends Controller
{
  public function index(Request $request)
  {
    if ($request->ajax()) {
      $query = $this->getData($request);

      $datatables = DataTables::of($query)
      ;

      return $datatables->make(true);
    }

    return view('web.report.summary-freight-cost-report-per-manifest.index');
  }

  protected function getData($request)
  {
    $sql = "
    SELECT
      lirh.invoice_receipt_id,
      lirh.invoice_receipt_no,
      lirh.kwitansi_no,
      lirh.invoice_receipt_date,
      lirh.amount_after_tax,
      lmh.manifest_type AS status,
      CASE
        WHEN (lirh.invoice_receipt_no IS NOT NULL && lirh.invoice_receipt_id IS NOT NULL) THEN 'Already Receipt'
        WHEN (lirh.invoice_receipt_no IS NULL && lirh.invoice_receipt_id IS NULL) THEN 'Unreceipt'
        ELSE 'Draft Receipt'
      END AS paid_status,
      DATE_FORMAT(lird.do_manifest_date, '%m.%y') AS bulan,
      lird.acc_code,
      lird.kode_cabang,
      lird.code_sales,
      lird.do_manifest_no,
      lmh.do_manifest_date,
      lirh.expedition_name,
      lmh.city_name,
      lmh.vehicle_description,
      lmh.vehicle_number,
      lird.delivery_no,
      lc.short_description AS branch_short_description,
      lird.ship_to_code,
      lird.ship_to,
      lird.city_name,
      lird.cbm_do,
      lird.cbm_vehicle,
      lird.freight_cost,
      lird.cbm_amount,
      lird.ritase_freight_cost,
      lird.ritase_amount,
      lird.ritase2_amount,
      lird.multidro_amount,
      lird.unloading_amount,
      lird.overstay_amount,
      lirh.amount_before_tax,
      lc.region
    FROM log_invoice_receipt_header lirh
    LEFT JOIN log_invoice_receipt_detail lird ON lird.id_header = lirh.id
    LEFT JOIN log_manifest_header lmh ON lmh.do_manifest_no = lird.do_manifest_no
    LEFT JOIN log_cabang lc ON lird.kode_cabang = lc.kode_cabang
    WHERE lmh.do_manifest_date >= ? AND lmh.do_manifest_date <= ?
    ";

    $condition_params = [
      $request->input('start_date'),
      $request->input('end_date'),
    ];

    if (!empty($request->input('do_manifest_no'))) {
      $sql .= ' AND lird.do_manifest_no = ?';
      $condition_params[] = $request->input('do_manifest_no');
    }

    if (!empty($request->input('city_code'))) {
      $sql .= ' AND lmh.city_code = ?';
      $condition_params[] = $request->input('city_code');
    }

    if (!empty($request->input('invoice_receipt_id'))) {
      $sql .= ' AND lirh.invoice_receipt_id = ?';
      $condition_params[] = $request->input('invoice_receipt_id');
    }

    if (!empty($request->input('region'))) {
      $sql .= ' AND lc.region = ?';
      $condition_params[] = $request->input('region');
    }

    if (!empty($request->input('expedition_code'))) {
      $sql .= ' AND lirh.expedition_code = ?';
      $condition_params[] = $request->input('expedition_code');
    }

    if (!empty($request->input('paid_status'))) {
      $sql .= ' HAVING paid_status = ?';
      $condition_params[] = $request->input('paid_status');
    }

    $query = DB::select(DB::raw($sql), $condition_params);


    return $query;
  }
}
