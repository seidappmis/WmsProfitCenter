<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\FreightCost;
use App\Models\MasterExpedition;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MasterExpeditionController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    if ($request->ajax()) {
      $query = MasterExpedition::all();

      $datatables = DataTables::of($query)
        ->addIndexColumn() //DT_RowIndex (Penomoran)
        ->editColumn('address', function ($data) {
          return limit_kalimat_wrap($data->address);
        })
        ->editColumn('status_active', '{{$status_active ? "Active" : "No Active"}}')
        ->addColumn('action', function ($data) {
          $action = '';
          $action .= ' ' . get_button_edit(url('master-expedition/' . $data->id . '/edit'));
          $action .= ' ' . get_button_delete();
          return $action;
        })
        ->rawColumns(['address', 'action']);

      return $datatables->make(true);
    }
    return view('web.master.master-expedition.index');
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view('web.master.master-expedition.create');
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
      'code'            => 'required|max:3|min:3',
      'expedition_name' => 'required|max:100',
      'sap_vendor_code' => 'unique:tr_expedition',
    ]);

    $masterExpedition                  = new MasterExpedition;
    $masterExpedition->code            = $request->input('code');
    $masterExpedition->expedition_name = $request->input('expedition_name');
    $masterExpedition->sap_vendor_code = $request->input('sap_vendor_code');
    $masterExpedition->address         = $request->input('address');
    $masterExpedition->npwp            = $request->input('npwp');
    $masterExpedition->contact_person  = $request->input('contact_person');
    $masterExpedition->phone_number_1  = $request->input('phone_number_1');
    $masterExpedition->phone_number_2  = $request->input('phone_number_2');
    $masterExpedition->fax_number      = $request->input('fax_number');
    $masterExpedition->bank            = $request->input('bank');
    $masterExpedition->currency        = $request->input('currency');
    $masterExpedition->status_active   = !empty($request->input('status_active'));

    return $masterExpedition->save();

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
    $data['masterExpedition'] = MasterExpedition::findorfail($id);
    return view('web.master.master-expedition.edit', $data);

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
      'code'            => 'required|max:3',
      'expedition_name' => 'required|max:100',

    ]);

    $masterExpedition                  = MasterExpedition::findorfail($id);
    $masterExpedition->code            = $request->input('code');
    $masterExpedition->expedition_name = $request->input('expedition_name');
    $masterExpedition->sap_vendor_code = $request->input('sap_vendor_code');
    $masterExpedition->address         = $request->input('address');
    $masterExpedition->npwp            = $request->input('npwp');
    $masterExpedition->contact_person  = $request->input('contact_person');
    $masterExpedition->phone_number_1  = $request->input('phone_number_1');
    $masterExpedition->phone_number_2  = $request->input('phone_number_2');
    $masterExpedition->fax_number      = $request->input('fax_number');
    $masterExpedition->bank            = $request->input('bank');
    $masterExpedition->currency        = $request->input('currency');
    $masterExpedition->status_active   = !empty($request->input('status_active'));

    return $masterExpedition->save();
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    return MasterExpedition::destroy($id);
  }

  public function getSelect2ActiveExpedition(Request $request)
  {
    $query = MasterExpedition::select(
      DB::raw("code AS id"),
      DB::raw("expedition_name AS text")
    )
      ->where('status_active', 1)
      ->toBase();

    return get_select2_data($request, $query);
  }

  public function getSelect2AllExpedition(Request $request)
  {
    $query = MasterExpedition::select(
      DB::raw("code AS id"),
      DB::raw("expedition_name AS text")
    )
      ->toBase();

    return get_select2_data($request, $query);
  }

  public function getSelect2ExpeditionDestinationCity(Request $request)
  {
    $query = FreightCost::select(
      DB::raw("log_freight_cost.city_code AS id"),
      DB::raw("city_name AS text")
    )
      ->toBase();

    if ($request->input('tambah_ambil_sendiri')) {
      $ambil_sendiri = DB::table('tr_vehicle_type_detail')->selectRaw('"AS" as id, "Ambil Sendiri" AS `text` ');
      $query->union($ambil_sendiri);
    }

    $query->leftjoin('log_destination_city', 'log_destination_city.city_code', '=', 'log_freight_cost.city_code')
      ->where('expedition_code', $request->input('expedition_code'))
      ->where('area', auth()->user()->area)
      ->groupBy('log_freight_cost.city_code')
      ->orderBy('text');

    return get_select2_data($request, $query);
  }
}
