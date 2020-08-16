<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReceiptInvoiceAccountingController extends Controller
{
  public function index(Request $request)
  {
    return view('web.invoicing.receipt-invoice-accounting.index');
  }

  public function create()
  {
    return view('web.invoicing.receipt-invoice-accounting.create');
  }

  public function show()
  {
    return view('web.invoicing.receipt-invoice-accounting.view');
  }
}
