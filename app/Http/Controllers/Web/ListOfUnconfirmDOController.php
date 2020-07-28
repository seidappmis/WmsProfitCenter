<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LogManifestDetail;
use DB;

class ListOfUnconfirmDOController extends Controller
{
    public function index(Request $request)
    {
      $unconfirmManifesDetail = LogManifestDetail::select(
        'log_manifest_detail.*',
        'log_manifest_header.do_manifest_date',
        'log_manifest_header.city_name',
        DB::raw('CASE WHEN log_manifest_detail.do_return = 1 THEN "RETURN" ELSE "NORMAL" END AS do_type')
      )
      ->leftjoin('log_manifest_header', 'log_manifest_header.do_manifest_no', '=', 'log_manifest_detail.do_manifest_no')
      ->where('log_manifest_header.status_complete', 1)
      ->where('log_manifest_detail.status_confirm', 0)
      ->where('log_manifest_header.area', auth()->user()->area)
      ->orderBy('log_manifest_header.do_manifest_no')
      ->get()
      ;

      $rs_unconfirmManifesDetail = [];
      foreach ($unconfirmManifesDetail as $key => $value) {
        $rs_unconfirmManifesDetail[$value->do_manifest_no]['manifest'] = $value;
        $rs_unconfirmManifesDetail[$value->do_manifest_no]['detail'][] = $value;
      }

      $data['unconfirmManifesDetail'] = $unconfirmManifesDetail;
      $data['rs_unconfirmManifesDetail'] = $rs_unconfirmManifesDetail;

      return view('web.invoicing.list-of-unconfirm-do.index', $data);
    }
}
