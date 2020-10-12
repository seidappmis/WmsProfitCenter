<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\DriverRegistered;
use App\Models\MasterDriver;
use App\Models\MasterVehicleExpedition;
use DB;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class IdCardScanController extends Controller
{
  public function index(Request $request)
  {
    return view('web.outgoing.idcard-scan.index');
  }

  public function show($id)
  {
    $driver = MasterDriver::findOrFail($id);

    $driverRegistered = DriverRegistered::where('driver_id', $id)
      ->where('wk_step_number', '!=', 6)
      // ->whereNull('datetime_out')
      ->first();

    if (!empty($driverRegistered)) {
      return ['status' => false, 'message' => 'ID Driver ' . $id . ' Already Checkin in area : ' . $driverRegistered->area . '!!'];
    }

    $driver->expedition;

    return ['status' => true, 'data' => $driver];
  }

  public function store(Request $request)
  {
    $request->validate([
      'driver_id' => 'max:45',
    ]);

    // Check vehicle number
    $checkVehicle = DriverRegistered::where('vehicle_number', $request->input('vehicle_number'))->whereRaw('(`wk_step_number` IS NULL OR wk_step_number !=6)')->first();

    if (!empty($checkVehicle)) {
      return sendError('Vehicle Number ' . $checkVehicle->vehicle_number . ' Already Checkin !!');
    }

    $storeDateTime = date('Y-m-d H:i:s');

    $driverRegistered                      = new DriverRegistered;
    $driverRegistered->id                  = Uuid::uuid4();
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

    return sendSuccess('Driver Check in success', $driverRegistered);
  }

  public function getSelect2VehicleNumber(Request $request)
  {
    $query = MasterVehicleExpedition::select(
      DB::raw("vehicle_number AS id"),
      DB::raw("vehicle_number AS text"),
      'tr_vehicle_type_detail.vehicle_description',
      'tr_vehicle_type_detail.vehicle_code_type',
      'tr_vehicle_type_detail.vehicle_group_id',
      'tr_vehicle_type_detail.cbm_min',
      'tr_vehicle_type_detail.cbm_max'
    )->toBase();

    $query->leftjoin('tr_vehicle_type_detail', 'tr_vehicle_type_detail.vehicle_code_type', '=', 'tr_vehicle_expedition.vehicle_code_type');

    if (!empty($request->input('expedition_code'))) {
      $query->where('expedition_code', $request->input('expedition_code'));
    }

    $query->orderBy('vehicle_number');

    return get_select2_data($request, $query);
  }
}
