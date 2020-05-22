<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\DestinationCity;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DestinationCityController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    if ($request->ajax()) {
      $query = DestinationCity::all();

      $datatables = DataTables::of($query)
        ->addIndexColumn() //DT_RowIndex (Penomoran)
        ->addColumn('action', function ($data) {
          $action = '';
          $action .= ' ' . get_button_edit(url('destination-city/' . $data->city_code . '/edit'));
          $action .= ' ' . get_button_delete();
          return $action;
        });

      return $datatables->make(true);
    }
    return view('web.master.destination-city.index');
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view('web.master.destination-city.create');
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
      'city_code'  => 'required|unique:destination_cities|max:10',
      'city_name'  => 'required|max:100',
    ]);

    $destinationCity            = new DestinationCity;
    $destinationCity->city_code = $request->input('city_code');
    $destinationCity->city_name = $request->input('city_name');

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
    $data['destinationCity'] = DestinationCity::findOrFail($id);

    return view('web.master.destination-city.edit', $data);
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
      'city_code'  => 'required|max:10',
      'city_name'  => 'required|max:100',
    ]);

    $destinationCity            = DestinationCity::findOrFail($id);
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
    return DestinationCity::destroy($id);
  }

  public function getSelect2DestinationCity(Request $request)
    {
        $query = DestinationCity::select(
          DB::raw('city_code AS id'),
          DB::raw("city_name AS text")
        );

        return get_select2_data($request, $query);
    }
}
