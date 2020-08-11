<?php

namespace App\Http\Controllers;

use App\Models\UserScanner;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;

class ReportMasterUserMobileController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()){
            $query =UserScanner::selectRaw()
        }
    }
}
