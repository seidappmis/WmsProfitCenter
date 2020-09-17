<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Models\UserRole;
use App\Models\UserRoleDetail;
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
      'roles_name' => 'unique:tr_user_roles|required',
    ]);

    $userRole             = new UserRole;
    $userRole->roles_id   = Uuid::uuid4()->toString();
    $userRole->roles_name = $request->input('roles_name');

    $userroles_detail = [];
    if (!empty($request->input('view'))) {
      foreach ($request->input('view') as $key => $value) {
        $userroles_detail[$key]['modul_id'] = $key;
        $userroles_detail[$key]['roles_id'] = $userRole->roles_id;
        $userroles_detail[$key]['view']     = 1;
      }
    }

    if (!empty($request->input('edit'))) {
      foreach ($request->input('edit') as $key => $value) {
        $userroles_detail[$key]['modul_id'] = $key;
        $userroles_detail[$key]['roles_id'] = $userRole->roles_id;
        $userroles_detail[$key]['edit']     = 1;
      }
    }

    if (!empty($request->input('delete'))) {
      foreach ($request->input('delete') as $key => $value) {
        $userroles_detail[$key]['modul_id'] = $key;
        $userroles_detail[$key]['roles_id'] = $userRole->roles_id;
        $userroles_detail[$key]['delete']   = 1;
      }
    }

    foreach ($userroles_detail as $key => $value) {
      $userroles_detail[$key]['view']   = empty($userroles_detail[$key]['view']) ? 0 : $userroles_detail[$key]['view'];
      $userroles_detail[$key]['edit']   = empty($userroles_detail[$key]['edit']) ? 0 : $userroles_detail[$key]['edit'];
      $userroles_detail[$key]['delete'] = empty($userroles_detail[$key]['delete']) ? 0 : $userroles_detail[$key]['delete'];
    }

    DB::beginTransaction();

    $userRole->save();
    UserRoleDetail::where('roles_id', $userRole->roles_id)->delete();
    UserRoleDetail::insert($userroles_detail);

    DB::commit();

    return sendSuccess('Role Created', $userRole);
  }

  public function edit($id)
  {
    $data['userRole'] = UserRole::findOrFail($id);
    $data['modules']  = $this->getModules();
    $role_details     = [];
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

    $userroles_detail = [];
    if (!empty($request->input('view'))) {
      foreach ($request->input('view') as $key => $value) {
        $userroles_detail[$key]['modul_id'] = $key;
        $userroles_detail[$key]['roles_id'] = $userRole->roles_id;
        $userroles_detail[$key]['view']     = 1;
      }
    }

    if (!empty($request->input('edit'))) {
      foreach ($request->input('edit') as $key => $value) {
        $userroles_detail[$key]['modul_id'] = $key;
        $userroles_detail[$key]['roles_id'] = $userRole->roles_id;
        $userroles_detail[$key]['edit']     = 1;
      }
    }

    if (!empty($request->input('delete'))) {
      foreach ($request->input('delete') as $key => $value) {
        $userroles_detail[$key]['modul_id'] = $key;
        $userroles_detail[$key]['roles_id'] = $userRole->roles_id;
        $userroles_detail[$key]['delete']   = 1;
      }
    }

    foreach ($userroles_detail as $key => $value) {
      $userroles_detail[$key]['view']   = empty($userroles_detail[$key]['view']) ? 0 : $userroles_detail[$key]['view'];
      $userroles_detail[$key]['edit']   = empty($userroles_detail[$key]['edit']) ? 0 : $userroles_detail[$key]['edit'];
      $userroles_detail[$key]['delete'] = empty($userroles_detail[$key]['delete']) ? 0 : $userroles_detail[$key]['delete'];
    }

    DB::beginTransaction();

    $userRole->save();
    UserRoleDetail::where('roles_id', $userRole->roles_id)->delete();
    UserRoleDetail::insert($userroles_detail);

    DB::commit();

    return sendSuccess('Role Updated', $userRole);
  }

  public function destroy($id)
  {
    DB::beginTransaction();
    $userRole = UserRole::findOrFail($id);
    UserRoleDetail::where('roles_id', $userRole->roles_id)->delete();
    $userRole->delete();
    DB::commit();

    return sendSuccess("Role deleted.", $userRole);
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
