<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

class UploadConceptController extends Controller
{
  public function index()
  {
    return view('web.outgoing.upload-concept.index');
  }
}
