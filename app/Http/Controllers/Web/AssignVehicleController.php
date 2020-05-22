<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\DriverRegistered;
use DataTables;
use Illuminate\Http\Request;

class AssignVehicleController extends Controller
{
  public function index(Request $request)
  {
    if ($request->ajax()) {
      $query = DriverRegistered::where('area', $request->input('area'))
        ->whereNull('datetime_out')
        ->get();

      $datatables = DataTables::of($query)
        ->addIndexColumn() //DT_RowIndex (Penomoran)
        ->addColumn('cbm_max', function ($data) {
          return $data->vehicle->cbm_max;
        })
        ->addColumn('action', function ($data) {
          $action = '';
          $action .= ' ' . get_button_edit(url('assign-vehicles/' . $data->id . '/edit'));
          $action .= ' ' . get_button_delete('Is Leave');
          return $action;
        });

      return $datatables->make(true);
    }
    return view('web.outgoing.assign-vehicles.index');
  }

  public function edit($id)
  {
    $data['driverRegistered'] = DriverRegistered::findOrFail($id);

    return view('web.outgoing.assign-vehicles.edit', $data);
  }

  public function update(Request $request, $id)
  {
    $driverRegistered = DriverRegistered::findOrFail($id);

    $driverRegistered->vehicle_code_type   = $request->input('vehicle_code_type');
    $driverRegistered->vehicle_description = $request->input('vehicle_description');
    $driverRegistered->destination_number  = $request->input('destination_number');
    $driverRegistered->destination_name    = $request->input('destination_name');

    $driverRegistered->save();

    return $driverRegistered;
  }

  public function destroy($id)
  {
    $driverRegistered = DriverRegistered::findOrFail($id);

    $driverRegistered->datetime_out   = date('Y-m-d H:i:s');
    $driverRegistered->wk_step_number = 6;

    $driverRegistered->save();

    return $driverRegistered;
  }
}
