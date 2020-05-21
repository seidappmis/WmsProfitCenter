<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\MasterDriver;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MasterDriverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if ($request->ajax()) {
            $query = MasterDriver::all();
  
            $datatables = DataTables::of($query)
              ->addIndexColumn() //DT_RowIndex (Penomoran)
              ->editColumn('dltype', '{{$dltype == 1 ? "SIM A" : "SIM B":"SIM B1"}}')
              ->addColumn('action', function ($data) {
                $action = '';
                $action .= ' ' . get_button_edit(url('master-driver/' . $data->driver_id . '/edit'));
                $action .= ' ' . get_button_delete();
                return $action;
              });
  
             return $datatables->make(true);
          }
          return view('web.master.master-driver.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('web.master.master-gate.create');
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
            'expedition_name'  => 'required',
            'diver_id'  => 'required|max:20',
            'l_driver'  => 'required',
          ]);
  
          $masterDriver              = new MasterDriver;
          $masterDriver->expedition_name = $request->input('expedition_name');
          $masterDriver->driver_id = $request->input('driver_id');
          $masterDriver->name     = $request->input('name');
          $masterDriver->dltype   = $request->input('dltype');
          $masterDriver->l_number = $request->input('l_number');
          $masterDriver->ktp      = $request->input('ktp');
          $masterDriver->phone1   = $request->input('phone1');  
          $masterDriver->phone2   = $request->input('phone2');  
          $masterDriver->remarks1   = $request->input('remarks1');  
          $masterDriver->remarks2   = $request->input('remarks2');
          $masterDriver->remarks3   = $request->input('remarks3'); 
          $masterDriver->status_active =!empty($request->input('status_active'));
          $masterDriver->photos     = $request->input('photos');  
          return $masterDriver->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['masterDriver'] = MasterDriver::findOrFail($id);
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
            'expedition_name'  => 'required',
            'diver_id'  => 'required|max:20',
            'l_driver'  => 'required',
          ]);
  
          $masterDriver              = MasterDriver::findOrFail($id);
          $masterDriver->expedition_name = $request->input('expedition_name');
          $masterDriver->driver_id = $request->input('driver_id');
          $masterDriver->name     = $request->input('name');
          $masterDriver->dltype   = $request->input('dltype');
          $masterDriver->l_number = $request->input('l_number');
          $masterDriver->ktp      = $request->input('ktp');
          $masterDriver->phone1   = $request->input('phone1');  
          $masterDriver->phone2   = $request->input('phone2');  
          $masterDriver->remarks1   = $request->input('remarks1');  
          $masterDriver->remarks2   = $request->input('remarks2');
          $masterDriver->remarks3   = $request->input('remarks3'); 
          $masterDriver->status_active =!empty($request->input('status_active'));
          $masterDriver->photos     = $request->input('photos');  
          return $masterDriver->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return MasterDriver::destroy($id);
    }
}
