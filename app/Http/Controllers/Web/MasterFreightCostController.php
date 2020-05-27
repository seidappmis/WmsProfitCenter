<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\FreightCost;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
            DB::raw('destination_cities.city_name AS destination_city_name')
          )
          ->leftjoin('destination_cities', 'destination_cities.city_code', '=',
          'log_freight_cost.city_code')
          ->where('log_freight_cost.area', $request->get('area'));

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

        $data  = [
          'areas' => \App\Models\Area::all()
        ];
        return view('web.master.master-freight-cost.index', $data);
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

        $masterFreight                     = new FreightCost;
        $masterFreight->area               = $request->input('area' );
        $masterFreight->ambil_sendiri      = !empty($request->input('ambil_sendiri'));
        $masterFreight->city_code          = $request->input('city_code');
        $masterFreight->expedition_code    = $request->input('expedition_code');
        $masterFreight->vehicle_code_type  = $request->input('vehicle_code_type');
        if($request['ritase_cbm'] == 'ritase'){
            $masterFreight->ritase = $request->input('ritase_cbm_input');  
            $masterFreight->cbm = $request->input('ritasecbm_input');  
        } 
        elseif ($request['ritase_cbm'] == 'cbm')   {
            $masterFreight->cbm = $request->input('ritase_cbm_input');    
            $masterFreight->ritase = $request->input('ritasecbm_input'); 
        }else{
            $masterFreight->cbm = $request->input('ritasecbm_input');    
            $masterFreight->ritase = $request->input('ritasecbm_input'); 
        }
        $masterFreight->leadtime           = $request->input('leadtime');

        return $masterFreight->save();
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
        'file-freight-cost' => 'required'
      ]);

      $file = fopen($request->file('file-freight-cost'), "r");

      $title                 = true;
      $master_freight_cost   = [];
      $rs_key = [];

      $date = date('Y-m-d H:i:s');

      while (!feof($file)) {
        $row = fgetcsv($file);
        if ($title) {
          $title = false;
          continue; // Skip baris judul
        }
        $freight_cost = [
          'area'              => $row[0],
          'city_code'         => $row[1],
          'expedition_code'   => $row[2],
          'vehicle_code_type' => $row[3],
          'ritase'            => $row[4],
          'cbm'               => $row[5],
          'leadtime'          => $row[6],
        ];
        $freight_cost['created_at']   = $date;
        $freight_cost['created_by']   = auth()->user()->id;

        $master_freight_cost[] = $freight_cost;
      }

      // Cek apakah data pernah diupload

      fclose($file);

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
        return view('web.master.master-freight-cost.edit',$data);
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

        $masterFreight                     = FreightCost::findOrFail($id);
        $masterFreight->area               = $request->input('area' );
        $masterFreight->ambil_sendiri      = !empty($request->input('ambil_sendiri'));
        $masterFreight->city_code          = $request->input('city_code');
        $masterFreight->expedition_code    = $request->input('expedition_code');
        $masterFreight->vehicle_code_type  = $request->input('vehicle_code_type');
        if($request['ritase_cbm'] == 'ritase'){
            $masterFreight->ritase = $request->input('ritase_cbm_input');  
            $masterFreight->cbm = $request->input('ritasecbm_input');  
        } 
        elseif ($request['ritase_cbm'] == 'cbm')   {
            $masterFreight->cbm = $request->input('ritase_cbm_input');    
            $masterFreight->ritase = $request->input('ritasecbm_input'); 
        }else{
            $masterFreight->cbm = $request->input('ritasecbm_input');    
            $masterFreight->ritase = $request->input('ritasecbm_input'); 
        }
        $masterFreight->leadtime           = $request->input('leadtime');

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
}
