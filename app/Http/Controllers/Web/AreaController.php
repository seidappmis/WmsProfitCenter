<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Area;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AreaController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    if ($request->ajax()) {
      $query = Area::all();

      $datatables = DataTables::of($query)
        ->addIndexColumn() //DT_RowIndex (Penomoran)
        ->addColumn('action', function ($data) {
          $action = '';
          $action .= ' ' . get_button_edit(url('master-area/' . $data->area . '/edit'));
          $action .= ' ' . get_button_delete();
          return $action;
        });

      return $datatables->make(true);
    }
    return view('web.settings.master-area.index');
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view('web.settings.master-area.create');
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
      'area' => 'unique:tr_area|max:20',
      'code' => 'max:3',
    ]);

    $masterArea       = new Area;
    $masterArea->area = $request->input('area');
    $masterArea->code = $request->input('code');

    return $masterArea->save();
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
    $data['masterArea'] = Area::findOrFail($id);

    return view('web.settings.master-area.edit', $data);
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
      'area' => 'max:20',
      'code' => 'max:3',
    ]);

    $masterArea       = Area::findOrFail($id);
    $masterArea->area = $request->input('area');
    $masterArea->code = $request->input('code');

    return $masterArea->save();
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    return Area::destroy($id);
  }

  /**
   * Show the application dataAjax.
   *
   * @return \Illuminate\Http\Response
   */
  public function getSelect2Area(Request $request)
  {
    $query = Area::select(
      DB::raw('area AS id'),
      DB::raw('area AS text')
    );

    if (auth()->user()->area != "All") {
      $query->where('area', auth()->user()->area);
    }

    return get_select2_data($request, $query);
  }

  public function getSelect2AreaOnly(Request $request)
  {
    $query = Area::select(
      DB::raw('area AS id'),
      DB::raw('area AS text')
    )->where('area', '!=', 'All');

    if (auth()->user()->area != "All") {
      $query->where('area', auth()->user()->area);
    }

    return get_select2_data($request, $query);
  }

  public function getSelect2AreaCode(Request $request)
  {
    $query = Area::select(
      DB::raw('code AS id'),
      DB::raw('area AS text')
    )->where('area', '!=', 'All');

    if (auth()->user()->area != "All") {
      $query->where('area', auth()->user()->area);
    }

    return get_select2_data($request, $query);
  }
}
