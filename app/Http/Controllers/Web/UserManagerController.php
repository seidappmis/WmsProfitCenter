<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\User;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserManagerController extends Controller
{
  public function index(Request $request)
  {
    if ($request->ajax()) {
      $query = User::selectRaw('users.*, tr_user_roles.roles_name, log_cabang.long_description')
      ->leftjoin('tr_user_roles', 'tr_user_roles.roles_id', '=', 'users.roles_id')
      ->leftjoin('log_cabang', 'log_cabang.kode_customer', '=', 'users.kode_customer')
      ->get();

      $datatables = DataTables::of($query)
        ->addIndexColumn() //DT_RowIndex (Penomoran)
        ->editColumn('status', '{{$status ? "YES" : "NO"}}')
        ->addColumn('action', function ($data) {
          $action = '';
          $action .= ' ' . get_button_edit(url('user-manager/' . $data->id . '/edit'));
          $action .= ' ' . get_button_delete();
          return $action;
        });

      return $datatables->make(true);
    }
    return view('web.settings.user-manager.index');
  }

  public function create()
  {
    return view('web.settings.user-manager.create');
  }

  public function store(Request $request)
  {
    $request->validate([
      'username'         => ['required'],
      'password'         => ['required', 'string', 'min:6'],
      'confirm_password' => ['required', 'string', 'min:6', 'same:password'],
    ]);

    $user                = new User;
    $user->username      = $request->input('username');
    $user->first_name    = $request->input('first_name');
    $user->last_name     = $request->input('last_name');
    $user->password      = Hash::make($request->input('password'));
    $user->status        = !empty($request->input('status'));
    $user->area          = $request->input('area');
    $user->kode_customer = $request->input('kode_customer');
    $user->created_by    = $request->input('created_by');

    return $user->save();
  }

  public function edit($id)
  {
    $data['user'] = User::findOrFail($id);

    return view('web.settings.user-manager.edit', $data);
  }

  public function update(Request $request, $id)
  {
    $request->validate([
      'username'         => ['required'],
      'confirm_password' => ['same:password'],
    ]);

    $user             = User::findOrFail($id);
    $user->username   = $request->input('username');
    $user->first_name = $request->input('first_name');
    $user->last_name  = $request->input('last_name');
    if (!empty($request->input('password'))) {
      $user->password = Hash::make($request->input('password'));
    }
    $user->status        = !empty($request->input('status'));
    $user->area          = $request->input('area');
    $user->kode_customer = $request->input('kode_customer');
    $user->created_by    = $request->input('created_by');

    return $user->save();
  }

  public function destroy($id)
  {
    return User::destroy($id);
  }

}
