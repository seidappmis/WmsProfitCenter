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
    public function index(Request $request )
    {
        if ($request->ajax()) {
            $query = MasterDriver::select(
                'master_driver.*',
                DB::raw('master_expedition.expedition_name')
            )
            ->leftjoin('master_expedition', 'master_expedition.code', '=', 'master_driver.expedition_code');
  
            $datatables = DataTables::of($query)
              ->addIndexColumn() //DT_RowIndex (Penomoran)
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
        return view ('web.master.master-driver.create');
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
            'expedition_code'  => 'required|max:3',
            'photo_name'         => 'image',
            'driving_license_number'  => 'required|max:50',
          ]);
          $masterDriver = new MasterDriver;

          $masterDriver->expedition_code = $request->input('expedition_code');
      
          // DRIVER ID = Expedition Code - YY - nomor
          $prefix = $masterDriver->expedition_code . '-' . date('y');
      
          $prefix_length = strlen($prefix);
          $max_no        = DB::select('SELECT MAX(SUBSTR(driver_id, ?)) AS max_no FROM master_driver WHERE SUBSTR(driver_id,1,?) = ? ', [$prefix_length + 2, $prefix_length, $prefix])[0]->max_no;
          $max_no        = str_pad($max_no + 1, 3, 0, STR_PAD_LEFT);
      
          $driver_id = $prefix . '-' . $max_no;
      
          $photo_name = '';
          if (!empty($request->file('photo_name'))) {
            $photo_name = $masterDriver->expedition_code . date('y') . $max_no . '.' . $request->file('photo_name')->extension();
            $path       = $request->file('photo_name')->storeAs(
              'Photo', $photo_name
            );
            $masterDriver->photo_name = $photo_name;
          }
      
          $masterDriver->driver_id = $request->input('driver_id');
          $masterDriver->driver_name     = $request->input('driver_name');
          $masterDriver->driving_license_type  = $request->input('driving_license_type');
          $masterDriver->driving_license_number = $request->input('driving_license_number');
          $masterDriver->ktp_no     = $request->input('ktp_no');
          $masterDriver->phone1   = $request->input('phone1');  
          $masterDriver->phone2   = $request->input('phone2');  
          $masterDriver->remarks1   = $request->input('remarks1');  
          $masterDriver->remarks2   = $request->input('remarks2');
          $masterDriver->remarks3   = $request->input('remarks3'); 
          $masterDriver->status_active =!empty($request->input('status_active'));

          $masterDriver->save();

          return $masterDriver;
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
        return view('web.master.master-driver.edit', $data);
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
        $masterDriver              = MasterDriver::findOrFail($id);
        $request->validate([
            
            'driving_license_number'  => 'required',
           
            ]);
            if (!empty($request->file('photo_name'))) {
                $photo_name = str_replace('-', '', $masterDriver->driver_id) . '.' . $request->file('photo_name')->extension();
                $path       = $request->file('photo_name')->storeAs(
                  'public/Photo', $photo_name
                );
                $masterDriver->photo_name = $photo_name;

            }
          $masterDriver->expedition_code = $request->input('expedition_code');
          $masterDriver->driver_id = $request->input('driver_id');
          $masterDriver->driver_name     = $request->input('driver_name');
          $masterDriver->driving_license_type  = $request->input('driving_license_type');
          $masterDriver->driving_license_number = $request->input('driving_license_number');
          $masterDriver->ktp_no     = $request->input('ktp_no');
          $masterDriver->phone1   = $request->input('phone1');  
          $masterDriver->phone2   = $request->input('phone2');  
          $masterDriver->remarks1   = $request->input('remarks1');  
          $masterDriver->remarks2   = $request->input('remarks2');
          $masterDriver->remarks3   = $request->input('remarks3'); 
          $masterDriver->status_active =!empty($request->input('status_active'));
       

          $masterDriver->save();
          return $masterDriver();
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
    public function getSelect2ActiveExpedition(Request $request)
  {
    $query = MasterDriver::select(
      DB::raw("code AS id"),
      DB::raw("CONCAT(code, '-', expedition_name) AS text")
    )
      ->where('status_active', 1)
      ->toBase();

    return get_select2_data($request, $query);
  }
    
}
