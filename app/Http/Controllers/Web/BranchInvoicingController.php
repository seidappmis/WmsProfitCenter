<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BranchInvoicingController extends Controller
{
  public function index(Request $request)
  {
    return view('web.invoicing.branch-invoicing.index');
  }

  public function create(){
    return view('web.invoicing.branch-invoicing.create');
  }
}
