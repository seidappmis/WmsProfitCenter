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
        'wms_branch_expedition_vehicle.*',
        DB::raw('vehicle_type_details.vehicle_desription as vehicle_type'),
        DB::raw('vehicle_type_details.cbm_min'),
        DB::raw('vehicle_type_details.cbm_max'),
        DB::raw('vehicle_type_groups.group_name AS vehicle_group'),
        DB::raw('wms_branch_expedition.expedition_name'),
        DB::raw('master_destination.description AS destination_name')
      )
        ->leftjoin('wms_branch_expedition', 'wms_branch_expedition.code', '=', 'wms_branch_expedition_vehicle.expedition_code')
        ->leftjoin('vehicle_type_details', 'vehicle_type_details.vehicle_code_type', '=', 'wms_branch_expedition_vehicle.vehicle_code_type')
        ->leftjoin('vehicle_type_groups', 'vehicle_type_groups.id', '=', 'vehicle_type_details.vehicle_group_id')
        ->leftjoin('master_destination', 'master_destination.destination_number', '=', 'wms_branch_expedition_vehicle.destination');

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
