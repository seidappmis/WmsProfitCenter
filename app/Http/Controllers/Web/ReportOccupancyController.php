<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\MasterCabang;
use Illuminate\Http\Request;

class ReportOccupancyController extends Controller
{
  public function index(Request $request)
  {
    $data['rs_branch'] = MasterCabang::select('kode_cabang', 'long_description')->get();

    return view('web.report.report-occupancy.index', $data);
  }

  public function export(Request $request)
  {
    return view('web.report.report-occupancy.print');
  }
}
