<?php

namespace App\Http\Controllers\Web;

use App\Models\MasterDestination;
use DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class MasterDestinationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = MasterDestination::all();

            $datatables = DataTables::of($query)
                ->addIndexColumn() //DT_RowIndex (Penomoran)
                ->addColumn('action', function ($data) {
                    $action = '';
                    $action .= ' ' . get_button_edit(url('master-destination/' . $data->destination_number . '/edit'));
                    $action .= ' ' . get_button_delete();
                    return $action;
                });

            return $datatables->make(true);
        }

        return view('web.master.master-destination.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('web.master.master-destination.create');
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
            'destination_number'  => 'required|unique:tr_destination|max:6',
            'destination_description'  => 'required|max:100',
            'new_region'  => 'max:10',
            'current_region'  => 'max:10',
            'cabang'  => 'max:2',

        ]);

        $masterDestination            = new MasterDestination;
        $masterDestination->destination_number = $request->input('destination_number');
        $masterDestination->destination_description = $request->input('destination_description');
        if ($request['region_type'] == 'new_region') {
            $masterDestination->region = $request->input('new_region');
        } elseif ($request['region_type'] == 'current') {
            $masterDestination->region = $request->input('current_region');
        }
        $masterDestination->kode_cabang = $request->input('cabang');

        return $masterDestination->save();
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
        $data['masterDestination'] = MasterDestination::findOrFail($id);

        return view('web.master.master-destination.edit', $data);
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
            'destination_description'  => 'required|max:100',
            'new_region'  => 'max:10',
            'current_region'  => 'max:10',
            'cabang'  => 'max:2',
        ]);

        $masterDestination            = MasterDestination::findOrFail($id);
        $masterDestination->destination_description = $request->input('destination_description');
        if ($request['region_type'] == 'new_region') {
            $masterDestination->region = $request->input('new_region');
        } elseif ($request['region_type'] == 'current') {
            $masterDestination->region = $request->input('current_region');
        }
        $masterDestination->kode_cabang = $request->input('cabang');

        return $masterDestination->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return MasterDestination::destroy($id);
    }

    public function getSelect2Destination(Request $request)
    {
        $query = MasterDestination::select(
            DB::raw("destination_number AS id"),
            DB::raw("destination_description AS text")
        );

        $query->orderBy('destination_description');

        return get_select2_data($request, $query);
    }
}
