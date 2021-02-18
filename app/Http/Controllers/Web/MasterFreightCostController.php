<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\FreightCost;
use DataTables;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MasterFreightCostController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    if ($request->ajax()) {
      $query = FreightCost::select(
        'log_freight_cost.*',
        DB::raw('log_destination_city.city_name AS destination_city_name'),
        DB::raw('tr_expedition.expedition_name AS expedition_name'),
        DB::raw('tr_vehicle_type_detail.vehicle_description AS vehicle_description')
      )
        ->leftjoin(
          'log_destination_city',
          'log_destination_city.city_code',
          '=',
          'log_freight_cost.city_code'
        )
        ->leftjoin('tr_expedition', 'tr_expedition.code', '=', 'log_freight_cost.expedition_code')
        ->leftjoin('tr_vehicle_type_detail', 'tr_vehicle_type_detail.vehicle_code_type', '=', 'log_freight_cost.vehicle_code_type');

      if (!empty($request->get('area'))) {
        $query->where('log_freight_cost.area', $request->get('area'));
      }

      $datatables = DataTables::of($query)
        ->addIndexColumn() //DT_RowIndex (Penomoran)
        ->addColumn('action', function ($data) {
          $action = '';
          $action .= ' ' . get_button_edit(url('master-freight-cost/' . $data->id . '/edit'));
          $action .= ' ' . get_button_delete();
          return $action;
        });

      return $datatables->make(true);
    }

    return view('web.master.master-freight-cost.index');
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view('web.master.master-freight-cost.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $request->validate([
      'area'              => 'required',
      'ambil_sendiri'     => 'nullable',
      'city_code'         => 'required|max:10',
      'expedition_code'   => 'required|max:3',
      'vehicle_code_type' => 'required|max:6',
      'ritase_cbm_input'  => 'numeric',
      'leadtime'          => 'nullable',
    ]);

    $masterFreight                    = new FreightCost;
    $masterFreight->area              = $request->input('area');
    $masterFreight->ambil_sendiri     = !empty($request->input('ambil_sendiri'));
    $masterFreight->city_code         = $request->input('city_code');
    $masterFreight->expedition_code   = $request->input('expedition_code');
    $masterFreight->vehicle_code_type = $request->input('vehicle_code_type');

    // Check Freight Cost
    if (
      FreightCost::where('area', $masterFreight->area)
      ->where('city_code', $masterFreight->city_code)
      ->where('expedition_code', $masterFreight->expedition_code)
      ->where('vehicle_code_type', $masterFreight->vehicle_code_type)
      ->exists()
    ) {
      return sendError('Freight Cost already exist!');
    }

    if ($request['ritase_cbm'] == 'ritase') {
      $masterFreight->ritase = !empty($request->input('ritase_cbm_input')) ? $request->input('ritase_cbm_input') : 0;
      $masterFreight->cbm    = !empty($request->input('ritasecbm_input')) ? $request->input('ritasecbm_input') : 0;
    } elseif ($request['ritase_cbm'] == 'cbm') {
      $masterFreight->cbm    = !empty($request->input('ritase_cbm_input')) ? $request->input('ritase_cbm_input') : 0;
      $masterFreight->ritase = !empty($request->input('ritasecbm_input')) ? $request->input('ritasecbm_input') : 0;
    } else {
      $masterFreight->cbm    = !empty($request->input('ritasecbm_input')) ? $request->input('ritasecbm_input') : 0;
      $masterFreight->ritase = !empty($request->input('ritasecbm_input')) ? $request->input('ritasecbm_input') : 0;
    }
    $masterFreight->leadtime = $request->input('leadtime');

    $masterFreight->save();

    return sendSuccess('Freight Cost created', $masterFreight);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function proses_upload(Request $request)
  {
    $request->validate([
      'file-freight-cost' => 'required',
    ]);

    $file = fopen($request->file('file-freight-cost'), "r");

    $title               = true;
    $master_freight_cost = [];
    $rs_area             = [];

    $rs_key = [];

    $date = date('Y-m-d H:i:s');

    while (!feof($file)) {
      $row = fgetcsv($file);
      if ($title || empty($row[0])) {
        $title = false;
        continue; // Skip baris judul
      }

      $freight_cost = [
        'area_code'         => $row[0],
        // 'area' => $row[0], // Cari dari database
        'city_code'         => $row[1],
        'expedition_code'   => $row[2],
        'vehicle_code_type' => $row[3],
        'ritase'            => $row[4],
        'cbm'               => $row[5],
        'leadtime'          => $row[6],
      ];
      $freight_cost['created_at'] = $date;
      $freight_cost['created_by'] = auth()->user()->id;

      if (!empty($freight_cost['city_code'])) {
        // Cari area
        if (empty($rs_area[$freight_cost['area_code']])) {
          $area = Area::where('code', $freight_cost['area_code'])->first();
          if (empty($area)) {
            $result['status']  = false;
            $result['message'] = 'Area ' . $freight_cost['area_code'] . ' not found in master area !';
            return $result;
          }

          $rs_area[$freight_cost['area_code']] = $area->area;
        }
        $freight_cost['area'] = $rs_area[$freight_cost['area_code']];

        // check  freight cost
        $check = FreightCost::where('area', $freight_cost['area'])
        ->where('city_code', $freight_cost['city_code'])
        ->where('expedition_code', $freight_cost['expedition_code'])
        ->where('vehicle_code_type', $freight_cost['vehicle_code_type'])
        ->first();

        if (!empty($check)) {
          return sendError('Freight Cost for expedition code ' . $freight_cost['expedition_code'] . ' to city code ' . $freight_cost['city_code'] . ' with vehicle code type ' . $freight_cost['vehicle_code_type'] . ' already exists!');
        }

        $master_freight_cost[] = $freight_cost;
      }
    }

    // Cek apakah data pernah diupload tidak ada
    // karena semua data dapat bernilai sama

    fclose($file);

    foreach ($master_freight_cost as $key => $value) {
      unset($value['area_code']);

      $master_freight_cost[$key] = $value;
    }

    FreightCost::insert($master_freight_cost);

    return true;
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
  public function edit($id)
  {
    $data['masterFreight'] = FreightCost::findOrFail($id);
    return view('web.master.master-freight-cost.edit', $data);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    $request->validate([
      'area'              => 'required',
      'ambil_sendiri'     => 'nullable',
      'city_code'         => 'required|max:10',
      'expedition_code'   => 'required|max:3',
      'vehicle_code_type' => 'required|max:6',
      'ritase_cbm_input'  => 'numeric',
      'leadtime'          => 'nullable',
    ]);

    $masterFreight                    = FreightCost::findOrFail($id);
    $masterFreight->area              = $request->input('area');
    $masterFreight->ambil_sendiri     = !empty($request->input('ambil_sendiri'));
    $masterFreight->city_code         = $request->input('city_code');
    $masterFreight->expedition_code   = $request->input('expedition_code');
    $masterFreight->vehicle_code_type = $request->input('vehicle_code_type');
    if ($request['ritase_cbm'] == 'ritase') {
      $masterFreight->ritase = $request->input('ritase_cbm_input');
      $masterFreight->cbm    = $request->input('ritasecbm_input');
    } elseif ($request['ritase_cbm'] == 'cbm') {
      $masterFreight->cbm    = $request->input('ritase_cbm_input');
      $masterFreight->ritase = $request->input('ritasecbm_input');
    } else {
      $masterFreight->cbm    = $request->input('ritasecbm_input');
      $masterFreight->ritase = $request->input('ritasecbm_input');
    }
    $masterFreight->leadtime = $request->input('leadtime');

    return $masterFreight->save();
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    return FreightCost::destroy($id);
  }

  public function getSelect2Vehicle(Request $request)
  {
    $query = FreightCost::select(
      DB::raw("log_freight_cost.vehicle_code_type AS id"),
      DB::raw("vehicle_description AS text"),
    )->toBase();

    $query->leftjoin('tr_vehicle_type_detail', 'tr_vehicle_type_detail.vehicle_code_type', '=', 'log_freight_cost.vehicle_code_type');
    $query->where('expedition_code', $request->input('expedition_code'));
    $query->groupBy('log_freight_cost.vehicle_code_type');
    $query->orderBy('vehicle_description');

    // $query = MasterVehicleExpedition::select(
    //   DB::raw("tr_vehicle_expedition.vehicle_code_type AS id"),
    //   DB::raw("vehicle_description AS text"),
    // )->toBase();

    // $query->leftjoin('tr_vehicle_type_detail', 'tr_vehicle_type_detail.vehicle_code_type', '=', 'tr_vehicle_expedition.vehicle_code_type');

    // $query->where('expedition_code', $request->input('expedition_code'));

    // $query->groupBy('tr_vehicle_expedition.vehicle_code_type');
    // $query->orderBy('vehicle_description');

    return get_select2_data($request, $query);
  }
}
