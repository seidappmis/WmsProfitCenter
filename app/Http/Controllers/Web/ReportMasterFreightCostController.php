<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\FreightCost;
use DataTables;
use Illuminate\Http\Request;

class ReportMasterFreightCostController extends Controller
{
  public function index(Request $request)
  {
    if ($request->ajax()) {
      $query = FreightCost::select(
        'log_freight_cost.*',
        'log_destination_city.city_name',
        'tr_expedition.expedition_name',
        'tr_vehicle_type_detail.vehicle_description',
      )
        ->leftjoin('log_destination_city', 'log_destination_city.city_code', '=', 'log_freight_cost.city_code')
        ->leftjoin('tr_expedition', 'tr_expedition.code', '=', 'log_freight_cost.expedition_code')
        ->leftjoin('tr_vehicle_type_detail', 'tr_vehicle_type_detail.vehicle_code_type', '=', 'log_freight_cost.vehicle_code_type')
      ;

      $query->where('log_freight_cost.area', $request->input('area'));

      $datatables = DataTables::of($query)
        ->editColumn('created_at', function ($data) {
          return $data->created_at;
        })
      ;

      return $datatables->make(true);
    }

    return view('web.report.report-master-freight-cost.index');
  }
}
