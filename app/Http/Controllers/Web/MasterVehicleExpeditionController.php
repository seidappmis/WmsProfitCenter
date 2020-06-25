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
                DB::raw('tr_vehicle_type_detail.vehicle_description as vehicle_type'),
                DB::raw('tr_vehicle_type_detail.cbm_min'),
                DB::raw('tr_vehicle_type_detail.cbm_max'),
                DB::raw('tr_vehicle_type_group.group_name AS vehicle_group'),
                DB::raw('tr_expedition.expedition_name'),
                DB::raw('tr_destination.destination_description AS destination_name')
            )
                ->leftjoin('tr_expedition', 'tr_expedition.code', '=', 'tr_vehicle_expedition.expedition_code')
                ->leftjoin('tr_vehicle_type_detail', 'tr_vehicle_type_detail.vehicle_code_type', '=', 'tr_vehicle_expedition.vehicle_code_type')
                ->leftjoin('tr_vehicle_type_group', 'tr_vehicle_type_group.id', '=', 'tr_vehicle_type_detail.vehicle_group_id')
                ->leftjoin('tr_destination', 'tr_destination.destination_number', '=', 'tr_vehicle_expedition.destination');

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

    public function getSelect2VehicleNumber(Request $request)
    {
      $query = MasterVehicleExpedition::select(
        DB::raw("vehicle_number AS id"),
        DB::raw("vehicle_number AS text")
      )
        ->toBase();

      return get_select2_data($request, $query);
    }
}
