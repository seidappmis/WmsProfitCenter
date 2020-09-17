<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SummaryTaskNoticeController extends Controller
{
    public function index(Request $request)
    {
      return view('web.report.summary-task-notice.index');
    }
}
