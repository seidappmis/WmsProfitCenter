<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\BranchExpeditionVehicle;
use DataTables;
use Illuminate\Http\Request;
use DB;

class BranchExpeditionVehicleController extends Controller
{

  public function index(Request $request)
  {
    if ($request->ajax()) {
      $query = BranchExpeditionVehicle::select(
        'wms_branch_vehicle_expedition.*',
        DB::raw('tr_vehicle_type_detail.vehicle_description as vehicle_type'),
        DB::raw('tr_vehicle_type_detail.cbm_min'),
        DB::raw('tr_vehicle_type_detail.cbm_max'),
        DB::raw('tr_vehicle_type_group.group_name AS vehicle_group'),
        DB::raw('wms_branch_expedition.expedition_name'),
        DB::raw('tr_destination.destination_description AS destination_name')
      )
        ->leftjoin('wms_branch_expedition', 'wms_branch_expedition.code', '=', 'wms_branch_vehicle_expedition.expedition_code')
        ->leftjoin('tr_vehicle_type_detail', 'tr_vehicle_type_detail.vehicle_code_type', '=', 'wms_branch_vehicle_expedition.vehicle_code_type')
        ->leftjoin('tr_vehicle_type_group', 'tr_vehicle_type_group.id', '=', 'tr_vehicle_type_detail.vehicle_group_id')
        ->leftjoin('tr_destination', 'tr_destination.destination_number', '=', 'wms_branch_vehicle_expedition.destination');

      $datatables = DataTables::of($query)
        ->addIndexColumn() //DT_RowIndex (Penomoran)
        ->editColumn('status_active', '{{$status_active ? "ACTIVE" : "NO ACTIVE"}}')
        ->addColumn('action', function ($data) {
          $action = '';
          $action .= ' ' . get_button_edit(url('branch-expedition-vehicle/' . $data->id . '/edit'));
          $action .= ' ' . get_button_delete();
          return $action;
        });

      return $datatables->make(true);
    }
    return view('web.master.branch-expedition-vehicle.index');
  }

  public function create()
  {

    return view('web.master.branch-expedition-vehicle.create');
  }

  public function store(Request $request)
  {
    $request->validate([
      'vehicle_number' => 'required',
    ]);

    $branchExpeditionVehicle = new BranchExpeditionVehicle;

    $branchExpeditionVehicle->vehicle_code_type          = $request->input('vehicle_code_type');
    $branchExpeditionVehicle->expedition_code            = $request->input('expedition_code');
    $branchExpeditionVehicle->vehicle_number             = $request->input('vehicle_number');
    $branchExpeditionVehicle->vehicle_detail_description = $request->input('vehicle_detail_description');
    $branchExpeditionVehicle->remark1                    = $request->input('remark1');
    $branchExpeditionVehicle->remark2                    = $request->input('remark2');
    $branchExpeditionVehicle->remark3                    = $request->input('remark3');
    $branchExpeditionVehicle->destination                = $request->input('destination');

    $branchExpeditionVehicle->status_active = !empty($request->input('status_active'));

    $branchExpeditionVehicle->save();

    return $branchExpeditionVehicle;
  }

  public function edit($id)
  {
    $data['branchExpeditionVehicle'] = BranchExpeditionVehicle::findOrFail($id);

    return view('web.master.branch-expedition-vehicle.edit', $data);
  }

  public function update(Request $request, $id)
  {
    $request->validate([
      'vehicle_number' => 'required',
    ]);

    $branchExpeditionVehicle                             = BranchExpeditionVehicle::findOrFail($id);
    $branchExpeditionVehicle->vehicle_code_type          = $request->input('vehicle_code_type');
    $branchExpeditionVehicle->expedition_code            = $request->input('expedition_code');
    $branchExpeditionVehicle->vehicle_number             = $request->input('vehicle_number');
    $branchExpeditionVehicle->vehicle_detail_description = $request->input('vehicle_detail_description');
    $branchExpeditionVehicle->remark1                    = $request->input('remark1');
    $branchExpeditionVehicle->remark2                    = $request->input('remark2');
    $branchExpeditionVehicle->remark3                    = $request->input('remark3');
    $branchExpeditionVehicle->destination                = $request->input('destination');

    $branchExpeditionVehicle->status_active = !empty($request->input('status_active'));

    $branchExpeditionVehicle->save();

    return $branchExpeditionVehicle;
  }

  public function destroy($id)
  {
    return BranchExpeditionVehicle::destroy($id);
  }
}
