<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\MasterGate;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MasterGateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
          // $query = MasterGate::all();
          $query = MasterGate::select(
            'gate_number',
            'description',
            DB::raw('master_areas.area AS area_name')
          )
            ->leftjoin('master_areas', 'master_gates.area_code', '=', 'master_areas.code')
            ->get();

          $datatables = DataTables::of($query)
            ->addIndexColumn() //DT_RowIndex (Penomoran)
            ->addColumn('action', function ($data) {
              $action = '';
              $action .= ' ' . get_button_edit(url('master-gate/' . $data->gate_number . '/edit'));
              $action .= ' ' . get_button_delete();
              return $action;
            });

           return $datatables->make(true);
        }
        return view('web.master.master-gate.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('web.master.master-gate.create');
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
          'gate_number'  => 'required|unique:master_gates|max:10',
          'description'  => 'required|max:100',
          'area'         => 'required',
        ]);

        $masterGate              = new MasterGate;
        $masterGate->gate_number = $request->input('gate_number');
        $masterGate->description = $request->input('description');
        $masterGate->area_code   = $request->input('area');

        return $masterGate->save();
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
        $data['masterGate'] = MasterGate::findOrFail($id);

    return view('web.master.master-gate.edit', $data);
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
          'gate_number'  => 'required|max:10',
          'description'  => 'required|max:100',
          'area'         => 'required',
        ]);

        $masterGate              = MasterGate::findOrFail($id);
        $masterGate->gate_number = $request->input('gate_number');
        $masterGate->description = $request->input('description');
        $masterGate->area_code   = $request->input('area');

        return $masterGate->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return MasterGate::destroy($id);
    }
}
