<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\MasterVehicleExpedition;
use DataTables;
use Illuminate\Http\Request;
use DB;

class MasterVehicleExpeditionController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = MasterVehicleExpedition::select(
                'tr_vehicle_expedition.*',
                DB::raw('vehicle_type_details.vehicle_desription as vehicle_type'),
                DB::raw('vehicle_type_details.cbm_min'),
                DB::raw('vehicle_type_details.cbm_max'),
                DB::raw('vehicle_type_groups.group_name AS vehicle_group'),
                DB::raw('master_expedition.expedition_name'),
                DB::raw('master_destination.description AS destination_name')
            )
                ->leftjoin('master_expedition', 'master_expedition.code', '=', 'tr_vehicle_expedition.expedition_code')
                ->leftjoin('vehicle_type_details', 'vehicle_type_details.vehicle_code_type', '=', 'tr_vehicle_expedition.vehicle_code_type')
                ->leftjoin('vehicle_type_groups', 'vehicle_type_groups.id', '=', 'vehicle_type_details.vehicle_group_id')
                ->leftjoin('master_destination', 'master_destination.destination_number', '=', 'tr_vehicle_expedition.destination');

            $datatables = DataTables::of($query)
                ->addIndexColumn() //DT_RowIndex (Penomoran)
                ->editColumn('status_active', '{{$status_active ? "ACTIVE" : "NO ACTIVE"}}')
                ->addColumn('action', function ($data) {
                    $action = '';
                    $action .= ' ' . get_button_edit(url('master-vehicle-expedition/' . $data->id . '/edit'));
                    $action .= ' ' . get_button_delete();
                    return $action;
                });

            return $datatables->make(true);
        }
        return view('web.master.master-vehicle-expedition.index');
    }


    public function create()
    {
        return view('web.master.master-vehicle-expedition.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'vehicle_number' => 'required',
        ]);

        $masterVehicleExpedition = new MasterVehicleExpedition;

        $masterVehicleExpedition->vehicle_code_type          = $request->input('vehicle_code_type');
        $masterVehicleExpedition->expedition_code            = $request->input('expedition_code');
        $masterVehicleExpedition->vehicle_number             = $request->input('vehicle_number');
        $masterVehicleExpedition->vehicle_detail_description = $request->input('vehicle_detail_description');
        $masterVehicleExpedition->remark1                    = $request->input('remark1');
        $masterVehicleExpedition->remark2                    = $request->input('remark2');
        $masterVehicleExpedition->remark3                    = $request->input('remark3');
        $masterVehicleExpedition->destination                = $request->input('destination');

        $masterVehicleExpedition->status_active = !empty($request->input('status_active'));

        $masterVehicleExpedition->save();

        return $masterVehicleExpedition;
    }


    public function edit($id)
    {
        $data['masterVehicleExpedition'] = MasterVehicleExpedition::findOrFail($id);

        return view('web.master.master-vehicle-expedition.edit', $data);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'vehicle_number' => 'required',
        ]);

        $masterVehicleExpedition                             = MasterVehicleExpedition::findOrFail($id);
        $masterVehicleExpedition->vehicle_code_type          = $request->input('vehicle_code_type');
        $masterVehicleExpedition->expedition_code            = $request->input('expedition_code');
        $masterVehicleExpedition->vehicle_number             = $request->input('vehicle_number');
        $masterVehicleExpedition->vehicle_detail_description = $request->input('vehicle_detail_description');
        $masterVehicleExpedition->remark1                    = $request->input('remark1');
        $masterVehicleExpedition->remark2                    = $request->input('remark2');
        $masterVehicleExpedition->remark3                    = $request->input('remark3');
        $masterVehicleExpedition->destination                = $request->input('destination');

        $masterVehicleExpedition->status_active = !empty($request->input('status_active'));

        $masterVehicleExpedition->save();

        return $masterVehicleExpedition;
    }


    public function destroy($id)
    {
        return MasterVehicleExpedition::destroy($id);
    }
}
