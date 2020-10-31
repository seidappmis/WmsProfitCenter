<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SummaryFreightCostReportPerManifestController extends Controller
{
  public function index(Request $request)
  {
    return view('web.report.summary-freight-cost-report-per-manifest.index');
  }
}
