<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\LogManifestDetail;
use App\Models\LogManifestHeader;
use App\Models\WMSBranchManifestHeader;
use App\Models\WMSBranchManifestDetail;
use DataTables;
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

    $manifestHeader = LogManifestHeader::where('area', $request->input('area'))->where('do_manifest_no', $request->input('manifest_no'))->first();

    if (empty($manifestHeader)) {
      $manifestHeader = WMSBranchManifestHeader::where('do_manifest_no', $request->input('manifest_no'))
        ->whereIn('kode_cabang', auth()->user()->getStringGrantCabang())
        ->first();
      if (!empty($manifestHeader)) {
        $manifestHeader->type = 'BRANCH';
      }
    } else {
      $manifestHeader->type = 'HQ';
    }

    if (empty($manifestHeader)) {
      return sendError('No Manifest Found');
    }

    $data['manifestHeader'] = $manifestHeader;

    return sendSuccess('Manifest Found', $data);
  }

  public function update(Request $request)
  {
    if (empty($request->input('do_manifest_no'))) {
      return sendError('Please Fill No. Manifest First');
    }

    $logManifestHeader = LogManifestHeader::where('area', $request->input('area'))->where('do_manifest_no', $request->input('do_manifest_no'))->first();

    if (empty($logManifestHeader)) {
      return sendError('No Manifest Found');
    }

    $logManifestHeader->vehicle_number      = $request->input('vehicle_number');
    $logManifestHeader->seal_no             = $request->input('seal_no');
    $logManifestHeader->expedition_code     = $request->input('expedition_code');
    $logManifestHeader->expedition_name     = $request->input('expedition_name');
    $logManifestHeader->vehicle_code_type   = $request->input('vehicle_code_type');
    $logManifestHeader->vehicle_description = $request->input('vehicle_description');
    $logManifestHeader->city_code           = $request->input('city_code');
    $logManifestHeader->city_name           = $request->input('city_name');
    $logManifestHeader->pdo_no              = $request->input('pdo_no');
    $logManifestHeader->checker             = $request->input('checker');
    $logManifestHeader->container_no        = $request->input('container_no');

    $logManifestHeader->save();

    return sendSuccess('Success update manifest.', $logManifestHeader);
  }

  public function listDo(Request $request)
  {
    if ($request->ajax()) {

      $query = LogManifestDetail::select('log_manifest_detail.*')
        ->where('do_manifest_no', $request->input('do_manifest_no'))
        ->where('delivery_no', $request->input('search')['value'])
      ;

      $datatables = DataTables::of($query)
        ->addIndexColumn() //DT_RowIndex (Penomoran)
        ->addColumn('description', function ($data) {
          return 'TCS';
        })
        ->addColumn('status', function ($data) {
          return '';
        })
        ->addColumn('action', function ($data) {
          $action = '';
          $action .= ' ' . get_button_view('#', 'Change DO', 'btn-change-do');
          return $action;
        })
        ->rawColumns(['do_status', 'action']);

      return $datatables->make(true);
    }
  }

  public function updateDO(Request $request)
  {
    $detail = LogManifestDetail::findOrFail($request->input('id'));

    $detail->do_internal  = $request->input('do_internal');
    $detail->sold_to_code = $request->input('sold_to_code');
    $detail->city_code    = $request->input('city_code');
    $detail->city_name    = $request->input('city_name');

    $detail->save();

    return sendSuccess('DO changed', $detail);
  }
}
