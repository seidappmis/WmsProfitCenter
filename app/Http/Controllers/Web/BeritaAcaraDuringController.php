<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BeritaAcaraDuringController extends Controller
{
  public function index(Request $request)
  {
    return view('web.during.berita-acara-during.index');
  }
}
