<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\LogManifestHeader;
use Illuminate\Http\Request;

class UpdateManifestController extends Controller
{
  public function index()
  {
    return view('web.outgoing.update-manifest.index');
  }

  public function show(Request $request)
  {
    if (empty($request->input('manifest_no'))) {
      return sendError('Please Fill No. Manifest First');
    }

    $logManifestHeader = LogManifestHeader::where('area', $request->input('area'))->where('do_manifest_no', $request->input('manifest_no'))->first();

    if (empty($logManifestHeader)) {
      return sendError('No Manifest Found');
    }

    $data['logManifestHeader'] = $logManifestHeader;
    
    return sendSuccess('Manifest Found', $data);
  }
}
