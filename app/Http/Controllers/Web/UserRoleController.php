<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Models\UserRole;
use DataTables;
use DB;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class UserRoleController extends Controller
{
  public function index(Request $request)
  {
    if ($request->ajax()) {
      $query = UserRole::all();

      $datatables = DataTables::of($query)
        ->addIndexColumn() //DT_RowIndex (Penomoran)
        ->addColumn('action', function ($data) {
          $action = '';
          $action .= ' ' . get_button_edit(url('user-roles/' . $data->roles_id . '/edit'));
          $action .= ' ' . get_button_delete();
          return $action;
        });

      return $datatables->make(true);
    }
    return view('web.settings.user-roles.index');
  }

  public function create()
  {
    $data['modules'] = $this->getModules();
    return view('web.settings.user-roles.create', $data);
  }

  public function store(Request $request)
  {
    $request->validate([
      'roles_name' => ['required'],
    ]);

    $userRole             = new UserRole;
    $userRole->roles_id   = Uuid::uuid4()->toString();
    $userRole->roles_name = $request->input('roles_name');
    return $userRole->save();
  }

  public function edit($id)
  {
    $data['userRole'] = UserRole::findOrFail($id);
    $data['modules'] = $this->getModules();
    $role_details = [];
    foreach ($data['userRole']->details as $key => $value) {
      $role_details[$value->modul_id] = $value;
    }
    $data['role_details'] = $role_details;
    // echo "<pre>";
    // print_r($data['role_details']);
    // exit;
    return view('web.settings.user-roles.edit', $data);
  }

  public function update(Request $request, $id)
  {
    $request->validate([
      'roles_name' => ['required'],
    ]);

    $userRole             = UserRole::findOrFail($id);
    $userRole->roles_name = $request->input('roles_name');
    return $userRole->save();
  }

  public function destroy($id)
  {
    return UserRole::destroy($id);
  }

  public function getSelect2Roles(Request $request)
  {
    $query = UserRole::select(
      DB::raw('roles_id AS id'),
      DB::raw("roles_name AS text")
    );

    return get_select2_data($request, $query);
  }

  protected function getModules()
  {
    $modules    = Module::orderBy('group_name')->get();
    $rs_modules = [];

    foreach ($modules as $key => $value) {
      $rs_modules[$value->group_name][] = $value;
    }

    return $rs_modules;
  }
}
