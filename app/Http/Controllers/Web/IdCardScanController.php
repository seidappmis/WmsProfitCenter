<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\MasterDriver;
use App\Models\DriverRegistered;
use Illuminate\Http\Request;

class IdCardScanController extends Controller
{
  public function index(Request $request)
  {
    return view('web.outgoing.idcard-scan.index');
  }

  public function show($id)
  {
    $driver = MasterDriver::findOrFail($id);

    $driverRegistered = DriverRegistered::where('driver_id', $id)->first();
    if (!empty($driverRegistered)) {
      return ['status' => false, 'message' => 'ID Driver ' . $id . ' Already Checkin in area : ' . $driverRegistered->area . '!!'];
    }

    $driver->expedition;

    return $driver;
  }

  public function store(Request $request)
  {
    $request->validate([
      'driver_id' => 'max:45',
    ]);

    $storeDateTime = date('Y-m-d H:i:s');

    $driverRegistered                      = new DriverRegistered;
    $driverRegistered->id                  = $storeDateTime;
    $driverRegistered->driver_id           = $request->input('driver_id');
    $driverRegistered->driver_name         = $request->input('driver_name');
    $driverRegistered->expedition_code     = $request->input('expedition_code');
    $driverRegistered->expedition_name     = $request->input('expedition_name');
    $driverRegistered->destination_number  = $request->input('destination_number');
    $driverRegistered->destination_name    = $request->input('destination_name');
    $driverRegistered->vehicle_number      = $request->input('vehicle_number');
    $driverRegistered->area                = $request->input('area');
    $driverRegistered->vehicle_code_type   = $request->input('vehicle_code_type');
    $driverRegistered->vehicle_description = $request->input('vehicle_description');

    $driverRegistered->region = $request->input('region');

    $driverRegistered->datetime_in = $storeDateTime;
    // $driverRegistered->datetime_out        = $request->input('datetime_out');
    // $driverRegistered->wk_step_number      = $request->input('wk_step_number');

    $driverRegistered->save();

    return $driverRegistered;
  }
}
