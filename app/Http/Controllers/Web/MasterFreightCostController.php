<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\FreightCost;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
          'log_freight_cost.city_code');

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
        //
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
