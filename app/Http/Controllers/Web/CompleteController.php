<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\ConceptFlowHeader;
use App\Models\ConceptTruckFlow;
use App\Models\DriverRegistered;
use App\Models\LogManifestHeader;
use DataTables;
use DB;
use Illuminate\Http\Request;

class CompleteController extends Controller
{
  public function index(Request $request)
  {
    if ($request->ajax()) {
      $query = LogManifestHeader::select(
        'log_manifest_header.driver_register_id',
        'log_manifest_header.vehicle_number',
        'log_manifest_header.destination_name_driver',
        'log_manifest_header.expedition_name',
        'log_manifest_header.status_complete',
        'tr_concept_truck_flow.complete_date',
        DB::raw('GROUP_CONCAT(log_manifest_header.do_manifest_no) AS do_manifest_no')
      )
        ->leftjoin('tr_concept_truck_flow', 'tr_concept_truck_flow.id', '=', 'log_manifest_header.driver_register_id')
        ->where('log_manifest_header.area', $request->input('area'))
        ->where('log_manifest_header.manifest_type', '!=', 'LCL')
        ->groupBy('log_manifest_header.do_manifest_no');

      $datatables = DataTables::of($query)
        ->addIndexColumn() //DT_RowIndex (Penomoran)
        ->editColumn('vehicle_number', function ($data) {
          return $data->vehicle_number . '<br>' . $data->driver_name;
        })
        ->editColumn('do_manifest_no', function ($data) {
          return $data->do_manifest_no . '<br>' . $data->complete_date;
        })
        ->addColumn('picking_no', function ($data) {
          return $data->picking->picking_no;
        })
        ->addColumn('status', function ($data) {
          return $data->status();
        })
        ->addColumn('action', function ($data) {
          $action = '';
          $action .= ' ' . get_button_view(url('complete/' . $data->driver_register_id), 'View');
          return $action;
        })
        ->rawColumns(['status', 'vehicle_number', 'do_manifest_no', 'do_status', 'action']);

      return $datatables->make(true);
    }

    return view('web.outgoing.complete.index');
  }

  public function show($id)
  {
    $data['rsManifestHeader'] = LogManifestHeader::where('driver_register_id', $id)
    ->where('manifest_type', '!=', 'LCL')
    ->get();

    if (empty($data['rsManifestHeader'])) {
      abort(404);
    }

    return view('web.outgoing.complete.view', $data);
  }

  public function complete($id)
  {
    $rsManifestHeader = LogManifestHeader::where('driver_register_id', $id)->get();

    if (empty($rsManifestHeader)) {
      abort(404);
    }

    try {
      DB::beginTransaction();
      foreach ($rsManifestHeader as $key => $manifestHeader) {
        // Update Tr DRIVER REGISTERED
        if ($manifestHeader->driver_name != "Ambil Sendiri") {
          $driverRegistered                 = DriverRegistered::findOrFail($manifestHeader->driver_register_id);
          $driverRegistered->wk_step_number = 6;
          $driverRegistered->save();

          // UPDATE tr_workflow_header
          $conceptFlowHeader              = ConceptFlowHeader::where('driver_register_id', $manifestHeader->driver_register_id)->first();
          $conceptFlowHeader->workflow_id = 6;
          $conceptFlowHeader->save();

          // Update Truck flow
          $conceptTruckFlow = ConceptTruckFlow::where('concept_flow_header', $conceptFlowHeader->id)->first();

          $conceptTruckFlow->complete_date         = date('Y-m-d H:i:s');
          $conceptTruckFlow->created_complete_date = $conceptTruckFlow->complete_date;
          $conceptTruckFlow->created_complete_by   = auth()->user()->id;
          $conceptTruckFlow->save();
        }

        $manifestHeader->status_complete = 1;
        $manifestHeader->save();
      }

      DB::commit();

      return sendSuccess('Success complete manifest', $rsManifestHeader);
    } catch (Exception $e) {
      DB::rollBack();
    }

  }
}
