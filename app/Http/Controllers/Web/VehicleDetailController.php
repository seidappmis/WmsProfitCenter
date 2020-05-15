<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Models\VehicleDetail;
use DataTables;
use Illuminate\Http\Request;

class VehicleDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $vehicle_group_id)
    {
        if ($request->ajax()) {
          // $query = VehicleDetail::all();
          $query = Vehicle::find($vehicle_group_id)->details;

          $datatables = DataTables::of($query)
            ->addIndexColumn() //DT_RowIndex (Penomoran)
            ->addColumn('action', function ($data) {
              $action = '';
              $action .= ' ' . get_button_edit(url('master-vehicle/' . $data->vehicle_group_id . '/detail/' . $data->id . '/edit'));
              $action .= ' ' . get_button_delete();
              return $action;
            });

          return $datatables->make(true);
        }
        
        $data = [
          'vehicleGroup' => Vehicle::find($vehicle_group_id),
        ];

        return view('web.master.master-vehicle.detail.view', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($vehicle_group_id)
    {
        $data = [
          'vehicleGroup' => Vehicle::find($vehicle_group_id),
        ];

        return view('web.master.master-vehicle.detail.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $vehicle_group_id)
    {
        $vehicleDetail                     = new VehicleDetail;
        $vehicleDetail->vehicle_group_id   = $vehicle_group_id;
        $vehicleDetail->vehicle_code_type  = $request->input('vehicle_code_type');
        $vehicleDetail->vehicle_desription = $request->input('vehicle_desription');
        $vehicleDetail->sap_description    = $request->input('sap_description');
        $vehicleDetail->cbm_min            = $request->input('cbm_min');
        $vehicleDetail->cbm_max            = $request->input('cbm_max');
        // $vehicleDetail->number = $request->input('numb');

        return $vehicleDetail->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($vehicle_group_id, $vehicle_detail_id)
    {
        $data = [
          'vehicleGroup' => Vehicle::find($vehicle_group_id),
          'vehicleDetail' => VehicleDetail::find($vehicle_detail_id),
        ];

        return view('web.master.master-vehicle.detail.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $vehicle_group_id, $vehicle_detail_id)
    {
        $vehicleDetail                     = VehicleDetail::findOrFail($vehicle_detail_id);
        $vehicleDetail->vehicle_group_id   = $vehicle_group_id;
        $vehicleDetail->vehicle_code_type  = $request->input('vehicle_code_type');
        $vehicleDetail->vehicle_desription = $request->input('vehicle_desription');
        $vehicleDetail->sap_description    = $request->input('sap_description');
        $vehicleDetail->cbm_min            = $request->input('cbm_min');
        $vehicleDetail->cbm_max            = $request->input('cbm_max');
        // $vehicleDetail->number = $request->input('numb');

        return $vehicleDetail->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($vehicle_group_id, $vehicle_detail_id)
    {
        // delete data detail table only
        // vehicle_group_id  : id for vehicle type group
        // vehicle_detail_id : id for vehicle type detail

        return VehicleDetail::destroy($vehicle_detail_id);
    }
}
