<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
          $query = Vehicle::all();

          $datatables = DataTables::of($query)
            ->addIndexColumn() //DT_RowIndex (Penomoran)
            ->addColumn('detail_code', function ($data) {
              return $data->details()->count();
            })
            ->addColumn('action', function ($data) {
              $action = '';
              $action .= ' ' . get_button_view(url('master-vehicle/' . $data->id . '/detail'));
              $action .= ' ' . get_button_delete();
              return $action;
            });

          return $datatables->make(true);
        }
        return view('web.master.master-vehicle.group.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('web.master.master-vehicle.group.create');
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
          'group_name'  => 'required|max:45',
        ]);

        $vehicleGroup             = new Vehicle;
        $vehicleGroup->group_name = $request->input('group_name');

        $vehicleGroup->save();

        return $vehicleGroup;
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
        //
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
          'group_name'  => 'max:45',
        ]);

        $vehicleGroup             = Vehicle::findOrFail($id);
        $vehicleGroup->group_name = $request->input('group_name');

        return $vehicleGroup->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // delete datatable group and
        // delete all datatable detail with same id group

        $vehicleGroup = Vehicle::find($id);

        if ($vehicleGroup->details()->count() > 0) {
            return sendError('This vehicle category group has details!');
        }

        return DB::transaction(function () use($vehicleGroup){
            $vehicleGroup->details()->delete();
            $vehicleGroup->delete();
            return sendSuccess('Vehicle Group deleted.', $vehicleGroup);
        });
    }
}
