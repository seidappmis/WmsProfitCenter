<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use DataTables;
use DB;
use Illuminate\Http\Request;

class SummaryFreightCostReportPerRegionController extends Controller
{
  public function index(Request $request)
  {
    if ($request->ajax()) {
      $query = $this->getData($request);

      $datatables = DataTables::of($query)
      ;

      return $datatables->make(true);
    }

    return view('web.report.summary-freight-cost-report-per-region.index');
  }

  protected function getData($request)
  {
    $sql = "
    SELECT
      lc.region,
      lc.short_description AS branch_short_description,
      lc.kode_cabang,
      lird.code_sales,
      DATE_FORMAT(lird.do_manifest_date, '%m') AS bulan,
      DATE_FORMAT(lird.do_manifest_date, '%Y') AS tahun,
      lird.city_name AS destination,
      SUM(lird.cbm_amount) + SUM(lird.ritase_amount) + SUM(lird.ritase2_amount) AS freight_cost,
      SUM(lird.multidro_amount) as multi_drop,
      SUM(lird.unloading_amount) AS unloading,
      SUM(lird.overstay_amount) AS overstay
    FROM log_invoice_receipt_header lirh
    LEFT JOIN log_invoice_receipt_detail lird ON lird.id_header = lirh.id
    LEFT JOIN log_manifest_header lmh ON lmh.do_manifest_no = lird.do_manifest_no
    LEFT JOIN log_cabang lc ON lird.kode_cabang = lc.kode_cabang
    WHERE lird.do_manifest_date >= ? AND lird.do_manifest_date <= ?
    ";

    $condition_params = [
      $request->input('start_date'),
      $request->input('end_date'),
    ];


    if (!empty($request->input('city_code'))) {
      $sql .= ' AND lmh.city_code = ?';
      $condition_params[] = $request->input('city_code');
    }

    if (!empty($request->input('code_sales'))) {
      $sql .= ' AND lird.code_sales = ?';
      $condition_params[] = $request->input('code_sales');
    }

    if (!empty($request->input('region'))) {
      $sql .= ' AND lc.region = ?';
      $condition_params[] = $request->input('region');
    }

    if (!empty($request->input('branch'))) {
      $sql .= ' AND lird.kode_cabang = ?';
      $condition_params[] = $request->input('branch');
    }

    if (!empty($request->input('paid_status'))) {
      $sql .= ' HAVING paid_status = ?';
      $condition_params[] = $request->input('paid_status');
    }

    $sql .= " GROUP BY lc.region, lc.short_description, lird.code_sales, DATE_FORMAT(lird.do_manifest_date, '%m%Y'), lird.city_name";

    $query = DB::select(DB::raw($sql), $condition_params);

    return $query;
  }

}
