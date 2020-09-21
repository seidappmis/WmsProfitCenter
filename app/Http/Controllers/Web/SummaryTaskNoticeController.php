<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\LogReturnSuratTugasHeader;
use DataTables;
use Illuminate\Http\Request;

class SummaryTaskNoticeController extends Controller
{
  public function index(Request $request)
  {
    if ($request->ajax()) {
      $query = LogReturnSuratTugasHeader::select(
        'log_return_surat_tugas_header.*'
      )
        ->leftjoin('log_return_surat_tugas_plan', 'log_return_surat_tugas_plan.id_header', '=', 'log_return_surat_tugas_header.id_header')
        ->leftjoin('log_return_surat_tugas_actual', 'log_return_surat_tugas_actual.id_detail_plan', '=', 'log_return_surat_tugas_plan.id_detail_plan')
      ;

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
