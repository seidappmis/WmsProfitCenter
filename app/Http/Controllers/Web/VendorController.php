<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VendorController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    if ($request->ajax()) {
      $query = Vendor::all();

      $datatables = DataTables::of($query)
        ->addIndexColumn() //DT_RowIndex (Penomoran)
        ->addColumn('action', function ($data) {
          $action = '';
          $action .= ' ' . get_button_edit(url('master-vendor/' . $data->vendor_code . '/edit'));
          $action .= ' ' . get_button_delete();
          return $action;
        })
        ;

      return $datatables->make(true);
    }
    return view('web.master.master-vendor.index');
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view('web.master.master-vendor.create');
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
      'vendor_code'          => 'required|unique:master_vendor|max:50',
      'vendor_name'          => 'required|max:100',
      'description'          => 'max:250',
      'vendor_address'       => 'max:100',
      'contact_person_name'  => 'max:50',
      'contact_person_phone' => 'max:20',
      'contact_person_email' => 'required|max:50',

    ]);

    $masterVendor                       = new Vendor;
    $masterVendor->vendor_code          = $request->input('vendor_code');
    $masterVendor->vendor_name          = $request->input('vendor_name');
    $masterVendor->description          = $request->input('description');
    $masterVendor->vendor_address       = $request->input('vendor_address');
    $masterVendor->contact_person_name  = $request->input('contact_person_name');
    $masterVendor->contact_person_phone = $request->input('contact_person_phone');
    $masterVendor->contact_person_email = $request->input('contact_person_email');

    return $masterVendor->save();
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
    $data['masterVendor'] = Vendor::findOrFail($id);

    return view('web.master.master-vendor.edit', $data);
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
      // 'vendor_code'     => 'required|unique:master_vendor|max:50',
      'vendor_name'          => 'required|max:100',
      'description'          => 'max:250',
      'vendor_address'       => 'max:100',
      'contact_person_name'  => 'max:50',
      'contact_person_phone' => 'max:20',
      'contact_person_email' => 'required|max:50',
    ]);

    $masterVendor = Vendor::findOrFail($id);
    // $masterVendor->vendor_code      = $request->input('vendor_code');
    $masterVendor->vendor_name          = $request->input('vendor_name');
    $masterVendor->description          = $request->input('description');
    $masterVendor->vendor_address       = $request->input('vendor_address');
    $masterVendor->contact_person_name  = $request->input('contact_person_name');
    $masterVendor->contact_person_phone = $request->input('contact_person_phone');
    $masterVendor->contact_person_email = $request->input('contact_person_email');

    return $masterVendor->save();
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    return Vendor::destroy($id);
  }

  public function getSelect2VendorName(Request $request)
  {
    $query = Vendor::select(
      DB::raw("vendor_name AS id"),
      DB::raw("vendor_name AS text")
    )->toBase();

    $query->orderBy('text');

    return get_select2_data($request, $query);
  }
}
