<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SummaryFreightCostAnalysisController extends Controller
{
  public function index(Request $request)
  {
    return view('web.invoicing.summary-freight-cost-analysis.index');
  }
}
