<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\DestinationCityOfBranch;
use DataTables;
use DB;
use Illuminate\Http\Request;

class DestinationCityOfBranchController extends Controller
{

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    if ($request->ajax()) {
      $query = DestinationCityOfBranch::where('kode_cabang', auth()->user()->cabang->kode_cabang);

      $datatables = DataTables::of($query)
        ->addIndexColumn() //DT_RowIndex (Penomoran)
        ->addColumn('action', function ($data) {
          $action = '';
          $action .= ' ' . get_button_edit(url('destination-city-of-branch/' . $data->id . '/edit'));
          $action .= ' ' . get_button_delete();
          return $action;
        });

      return $datatables->make(true);
    }
    return view('web.master.destination-city-of-branch.index');
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view('web.master.destination-city-of-branch.create');
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
      'city_name' => 'required|alpha|max:100',
    ]);

    $destinationCity              = new DestinationCityOfBranch;
    $destinationCity->kode_cabang = 12;
    $destinationCity->city_name   = $request->input('city_name');

    return $destinationCity->save();
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
    $data['destinationCity'] = DestinationCityOfBranch::findOrFail($id);

    return view('web.master.destination-city-of-branch.edit', $data);
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
      'city_name' => 'required|alpha|max:100',
    ]);

    $destinationCity = DestinationCityOfBranch::findOrFail($id);

    $destinationCity->city_name = $request->input('city_name');

    return $destinationCity->save();
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    return DestinationCityOfBranch::destroy($id);
  }

  public function getSelect2(Request $request)
  {
    $query = DestinationCityOfBranch::select(
      'id',
      DB::raw("city_name AS text"),
    )
      ->toBase()
    ;

    if ($request->input('tambah_ambil_sendiri')) {
      $ambil_sendiri = DB::table('tr_vehicle_type_detail')->selectRaw('"AS" as id, "Ambil Sendiri" AS `text` ');
      $query->union($ambil_sendiri);
    }

    $query->where('kode_cabang', auth()->user()->cabang->kode_cabang)
      ->orderBy('text');

    return get_select2_data($request, $query);
  }
}
