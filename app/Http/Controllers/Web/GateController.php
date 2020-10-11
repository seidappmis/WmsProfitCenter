<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Gate;
use DataTables;
use DB;
use Illuminate\Http\Request;

class GateController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    if ($request->ajax()) {
      $query = Gate::select('id', 'gate_number', 'description', 'area');

      if (auth()->user()->area != "All") {
        $query->where('area', auth()->user()->area);
      }

      $datatables = DataTables::of($query)
        ->addIndexColumn() //DT_RowIndex (Penomoran)
        ->addColumn('action', function ($data) {
          $action = '';
          $action .= ' ' . get_button_edit(url('master-gate/' . $data->id . '/edit'));
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
      'gate_number' => 'required',
      'description' => 'required|max:100',
      'area'        => 'required|max:20',
    ]);

    if (
      Gate::where('gate_number', $request->input('gate_number'))
      ->where('area', $request->input('area'))
      ->first()
    ) {
      return sendError('Gate ' . $request->input('gate_number') . ' already exist in ' . $request->input('area') . '!');
    }

    $masterGate              = new Gate;
    $masterGate->gate_number = $request->input('gate_number');
    $masterGate->description = $request->input('description');
    $masterGate->area        = $request->input('area');

    $masterGate->save();

    return sendSuccess('Success add gate ' . $masterGate->area, $masterGate);
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
    $data['masterGate'] = Gate::findOrFail($id);

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
      'gate_number' => 'required',
      'description' => 'required|max:100',
      'area'        => 'required|max:20',
    ]);

    $masterGate              = Gate::findOrFail($id);
    $masterGate->gate_number = $request->input('gate_number');
    $masterGate->description = $request->input('description');
    $masterGate->area        = $request->input('area');

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
    return Gate::destroy($id);
  }

  public function getSelect2FreeGate(Request $request)
  {
    $query = Gate::getLoadingGate(auth()->user()->area)
      ->select(
        DB::raw('tr_gate.gate_number AS id'),
        DB::raw("CONCAT(tr_gate.gate_number, '|', tr_gate.description) AS text")
      )
      ->whereNull('driver_id')
      ;

    if (!empty($request->input('area'))) {
      $query->where('area', $request->input('area'));
    }

    return get_select2_data($request, $query);
  }
}
