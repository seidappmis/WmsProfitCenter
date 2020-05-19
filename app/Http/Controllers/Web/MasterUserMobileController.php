<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\UserScanner;
use DataTables;
use Illuminate\Http\Request;

class MasterUserMobileController extends Controller
{
  public function index(Request $request)
  {
    if ($request->ajax()) {
      $query = UserScanner::all();

      $datatables = DataTables::of($query)
        ->addIndexColumn() //DT_RowIndex (Penomoran)
        ->editColumn('roles', '{{$roles == 1 ? "Admin" : "User"}}')
        ->editColumn('status_active', '{{$status_active ? "True" : "False"}}')
        ->addColumn('action', function ($data) {
          $action = '';
          $action .= ' ' . get_button_edit(url('master-user-mobile/' . $data->userid . '/edit'));
          $action .= ' ' . get_button_delete();
          return $action;
        });

      return $datatables->make(true);
    }
    return view('web.settings.master-user-mobile.index');
  }

  public function create()
  {

    return view('web.settings.master-user-mobile.create');
  }

  public function store(Request $request)
  {
    $request->validate([
      'userid' => 'unique:wms_user_scanner|max:45',
      'roles'  => 'required',
    ]);

    $userMobile                = new UserScanner;
    $userMobile->userid        = $request->input('userid');
    $userMobile->roles         = $request->input('roles');
    $userMobile->status_active = !empty($request->input('status_active'));

    $userMobile->save();

    return $userMobile;
  }

  public function edit($id)
  {
    $data['userMobile'] = UserScanner::findOrFail($id);

    return view('web.settings.master-user-mobile.edit', $data);
  }

  public function update(Request $request, $id)
  {
    $request->validate([
      'userid' => 'max:45',
      'roles'  => 'required',
    ]);

    $userMobile                = UserScanner::findOrFail($id);
    $userMobile->roles         = $request->input('roles');
    $userMobile->status_active = !empty($request->input('status_active'));

    $userMobile->save();

    return $userMobile;
  }

  public function destroy($id)
  {
    return UserScanner::destroy($id);
  }
}
