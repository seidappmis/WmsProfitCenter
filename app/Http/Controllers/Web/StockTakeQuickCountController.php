<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StockTakeQuickCountController extends Controller
{
  public function index(Request $request)
  {
    return view('web.stock-take.stock-take-quick-count.index');
  }
}
