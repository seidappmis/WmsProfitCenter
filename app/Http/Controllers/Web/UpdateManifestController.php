<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\LogManifestDetail;
use App\Models\LogManifestHeader;
use App\Models\WMSBranchManifestDetail;
use App\Models\FreightCost;
use App\Models\WMSBranchManifestHeader;
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

    if ($request->input('type') == 'HQ') {
      $manifestHeader = LogManifestHeader::where('area', $request->input('area'))->where('do_manifest_no', $request->input('do_manifest_no'))->first();
    } else {
      $manifestHeader = WMSBranchManifestHeader::where('do_manifest_no', $request->input('do_manifest_no'))->first();
    }

    if (empty($manifestHeader)) {
      return sendError('No Manifest Found');
    }

    $manifestHeader->vehicle_number      = $request->input('vehicle_number');
    $manifestHeader->seal_no             = $request->input('seal_no');
    $manifestHeader->expedition_code     = $request->input('expedition_code');
    $manifestHeader->expedition_name     = $request->input('expedition_name');
    $manifestHeader->vehicle_code_type   = $request->input('vehicle_code_type');
    $manifestHeader->vehicle_description = $request->input('vehicle_description');
    $manifestHeader->city_code           = $request->input('city_code');
    $manifestHeader->city_name           = $request->input('city_name');
    $manifestHeader->pdo_no              = $request->input('pdo_no');
    $manifestHeader->checker             = $request->input('checker');
    $manifestHeader->container_no        = $request->input('container_no');

    if ($request->input('type') == 'HQ') {
      foreach($manifestHeader->details AS $key => $value){
        $freightCost = FreightCost::where('area', $manifestHeader->area)
          ->where('vehicle_code_type', $manifestHeader->vehicle_code_type)
          ->where('expedition_code', $manifestHeader->expedition_code)
          ->where('city_code', $manifestHeader->city_code)
          ->first();

        if (empty($freightCost)) {
          return sendError('Freight Cost Not Found');
        }
  
        $value->nilai_ritase  = $freightCost->ritase;
        $value->nilai_ritase2 = $freightCost->ritase2;
        $value->lead_time     = $freightCost->leadtime;
        $value->base_price    = $freightCost->cbm;
        $value->nilai_cbm     = $value->base_price * $value->cbm;

        $value->save();
      }
    }

    $manifestHeader->save();

    return sendSuccess('Success update manifest.', $manifestHeader);
  }

  public function listDo(Request $request)
  {
    if ($request->ajax()) {

      if ($request->input('type') == 'HQ') {
        $query = LogManifestDetail::select('log_manifest_detail.*')
          ->where('do_manifest_no', $request->input('do_manifest_no'))
          ->where('delivery_no', $request->input('search')['value'])
        ;
      } else {
        $query = WMSBranchManifestDetail::select('wms_branch_manifest_detail.*')
          ->where('do_manifest_no', $request->input('do_manifest_no'))
          ->where('delivery_no', $request->input('search')['value'])
        ;
      }

      $datatables = DataTables::of($query)
        ->addIndexColumn() //DT_RowIndex (Penomoran)
        ->addColumn('description', function ($data) {
          return 'TCS';
        })
        ->addColumn('status', function ($data) {
          return $data->status();
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
