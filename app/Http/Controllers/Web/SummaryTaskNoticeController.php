<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\LogReturnSuratTugasHeader;
use DataTables;
use DB;
use Illuminate\Http\Request;

class SummaryTaskNoticeController extends Controller
{
  public function index(Request $request)
  {
    if ($request->ajax()) {
      $query = LogReturnSuratTugasHeader::select(
        DB::raw('log_return_surat_tugas_header.date AS upload_date'),
        DB::raw('log_return_surat_tugas_actual.created_date AS receive_date'),
        DB::raw('log_return_surat_tugas_plan.no AS no_doc'),
        DB::raw('log_return_surat_tugas_plan.costumer_code'),
        DB::raw('log_return_surat_tugas_plan.costumer_name'),
        DB::raw('log_return_surat_tugas_plan.cbm'),
        DB::raw('log_return_surat_tugas_plan.no_app AS no_apply'),
        DB::raw('log_return_surat_tugas_plan.model AS model_plan'),
        DB::raw('log_return_surat_tugas_plan.no_do AS do_number_plan'),
        DB::raw('log_return_surat_tugas_plan.vehicle_no AS no_mobil'),
        DB::raw('log_return_surat_tugas_plan.expedition AS expedisi'),
        DB::raw('log_return_surat_tugas_plan.driver AS driver'),
        DB::raw('log_return_surat_tugas_plan.qty AS qty_plan'),
        DB::raw('log_return_surat_tugas_plan.category AS category'),
        DB::raw('log_return_surat_tugas_actual.model AS model_actual'),
        DB::raw('log_return_surat_tugas_actual.qty AS qty_actual'),
        DB::raw('log_return_surat_tugas_actual.ceck AS `check`'),
        DB::raw('log_return_surat_tugas_actual.no_do AS do_number_actual'),
        DB::raw('log_return_surat_tugas_actual.serial_number AS no_serial'),
        DB::raw('log_return_surat_tugas_actual.no_so'),
        DB::raw('log_return_surat_tugas_actual.no_po'),
        DB::raw('log_return_surat_tugas_actual.kondisi'),
        DB::raw('log_return_surat_tugas_actual.rr'),
        DB::raw('log_return_surat_tugas_actual.remark'),
        DB::raw('log_return_surat_tugas_header.no_document AS no_st_or_no_urf')
      )
        ->leftjoin('log_return_surat_tugas_plan', 'log_return_surat_tugas_plan.id_header', '=', 'log_return_surat_tugas_header.id_header')
        ->leftjoin('log_return_surat_tugas_actual', 'log_return_surat_tugas_actual.id_detail_plan', '=', 'log_return_surat_tugas_plan.id_detail_plan')
      ;

      $query->where('log_return_surat_tugas_header.area', $request->input('area'));
      $query->where('log_return_surat_tugas_header.date', '>=', date('Y-m-d', strtotime($request->input('start_date'))));
      $query->where('log_return_surat_tugas_header.date', '<=', date('Y-m-d', strtotime($request->input('end_date'))));

      $datatables = DataTables::of($query)
        ->editColumn('date', function ($data) {
          return $data->date;
        })
      ;

      return $datatables->make(true);
    }

    return view('web.report.summary-task-notice.index');
  }
}
