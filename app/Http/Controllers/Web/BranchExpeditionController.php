<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\BranchExpedition;
use DataTables;
use DB;
use Illuminate\Http\Request;

class BranchExpeditionController extends Controller
{

  public function index(Request $request)
  {
    if ($request->ajax()) {
      $query = BranchExpedition::where('kode_cabang', auth()->user()->cabang->kode_cabang);

      $datatables = DataTables::of($query)
        ->addIndexColumn() //DT_RowIndex (Penomoran)
        ->editColumn('status_active', '{{$status_active ? "ACTIVE" : "NO ACTIVE"}}')
        ->addColumn('action', function ($data) {
          $action = '';
          $action .= ' ' . get_button_edit(url('master-branch-expedition/' . $data->id . '/edit'));
          $action .= ' ' . get_button_delete();
          return $action;
        });

      return $datatables->make(true);
    }
    return view('web.master.master-branch-expedition.index');
  }

  public function create()
  {

    return view('web.master.master-branch-expedition.create');
  }

  public function store(Request $request)
  {
    $request->validate([
      'expedition_name' => 'required',
      'initial'         => 'required',
    ]);

    $branchExpedition              = new BranchExpedition;
    $branchExpedition->kode_cabang = $request->input('kode_cabang');

    $branchExpedition->initial         = $request->input('initial');
    $branchExpedition->expedition_name = $request->input('expedition_name');
    $branchExpedition->npwp            = $request->input('npwp');

    $branchExpedition->code = $branchExpedition->initial . $branchExpedition->kode_cabang;
    // $branchExpedition->code            = $request->input('code');
    $branchExpedition->address         = $request->input('address');
    $branchExpedition->sap_vendor_code = $request->input('sap_vendor_code');
    $branchExpedition->contact_person  = $request->input('contact_person');
    $branchExpedition->phone_number_1  = $request->input('phone_number_1');
    $branchExpedition->phone_number_2  = $request->input('phone_number_2');
    $branchExpedition->fax_number      = $request->input('fax_number');
    $branchExpedition->bank            = $request->input('bank');
    $branchExpedition->currency        = $request->input('currency');
    $branchExpedition->remark1         = $request->input('remark1');
    $branchExpedition->remark2         = $request->input('remark2');
    // $branchExpedition->remark3         = $request->input('remark3');
    $branchExpedition->status_active = !empty($request->input('status_active'));

    $branchExpedition->save();

    return $branchExpedition;
  }

  public function edit($id)
  {
    $data['branchExpedition'] = BranchExpedition::findOrFail($id);

    return view('web.master.master-branch-expedition.edit', $data);
  }

  public function update(Request $request, $id)
  {
    $request->validate([
      'expedition_name' => 'required',
      'initial'         => 'required',
    ]);

    $branchExpedition              = BranchExpedition::findOrFail($id);
    $branchExpedition->kode_cabang = $request->input('kode_cabang');

    $branchExpedition->initial         = $request->input('initial');
    $branchExpedition->expedition_name = $request->input('expedition_name');
    $branchExpedition->npwp            = $request->input('npwp');

    $branchExpedition->code = $branchExpedition->initial . $branchExpedition->kode_cabang;
    // $branchExpedition->code            = $request->input('code');
    $branchExpedition->address         = $request->input('address');
    $branchExpedition->sap_vendor_code = $request->input('sap_vendor_code');
    $branchExpedition->contact_person  = $request->input('contact_person');
    $branchExpedition->phone_number_1  = $request->input('phone_number_1');
    $branchExpedition->phone_number_2  = $request->input('phone_number_2');
    $branchExpedition->fax_number      = $request->input('fax_number');
    $branchExpedition->bank            = $request->input('bank');
    $branchExpedition->currency        = $request->input('currency');
    $branchExpedition->remark1         = $request->input('remark1');
    $branchExpedition->remark2         = $request->input('remark2');
    // $branchExpedition->remark3         = $request->input('remark3');
    $branchExpedition->status_active = !empty($request->input('status_active'));

    $branchExpedition->save();

    return $branchExpedition;
  }

  public function destroy($id)
  {
    return BranchExpedition::destroy($id);
  }

  public function getSelect2ActiveExpedition(Request $request)
  {
    $query = BranchExpedition::select(
      DB::raw("code AS id"),
      DB::raw("expedition_name AS text")
    )
      ->where('status_active', 1)
      ->where('kode_cabang', auth()->user()->cabang->kode_cabang)
      ->toBase();

    if ($request->input('onetime')) {
      $onetime = DB::table('wms_branch_expedition')->selectRaw('"ON1" as id, "ONE TIME" AS `text` ');
      $query->union($onetime);
    }

    return get_select2_data($request, $query);
  }

  public function getSelect2AllExpedition(Request $request)
  {
    $query = BranchExpedition::select(
      DB::raw("code AS id"),
      DB::raw("expedition_name AS text")
    )
      ->where('kode_cabang', auth()->user()->cabang->kode_cabang)
      ->toBase();

    return get_select2_data($request, $query);
  }
}
