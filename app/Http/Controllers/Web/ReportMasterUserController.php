<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\User;
use DataTables;
use Illuminate\Http\Request;

class ReportMasterUserController extends Controller
{
  public function index(Request $request)
  {
    if ($request->ajax()) {
      $query = User::selectRaw('users.*, tr_user_roles.roles_name, log_cabang.long_description')
        ->leftjoin('tr_user_roles', 'tr_user_roles.roles_id', '=', 'users.roles_id')
        ->leftjoin('log_cabang', 'log_cabang.kode_customer', '=', 'users.kode_customer')
        ->where('area', $request->input('area'))
        ->get();

      $datatables = DataTables::of($query)
        ->editColumn('username', function ($data) {
          return $this->getUserTableData($data);
        })
        ->rawColumns(['username'])
      ;

      return $datatables->make(true);
    }

    return view('web.report.report-master-users.index');
  }

  protected function getUserTableData($data)
  {
    $table = '';
    $table .= '<table style="border-collapse: collapse; border: 1px solid black;">';

    $table .= '<tr style="border: 1px solid black;">';
    $table .= '<th style="text-align: center; border: 1px solid black;">USER ID</th>';
    $table .= '<th style="text-align: center; border: 1px solid black;">USER NAME</th>';
    $table .= '<th style="text-align: center; border: 1px solid black;">AREA</th>';
    $table .= '<th style="text-align: center; border: 1px solid black;">STATUS</th>';
    $table .= '<th style="text-align: center; border: 1px solid black;">LAST UPDATED</th>';
    $table .= '</tr>';

    $table .= '<tr style="border: 1px solid black;">';
    $table .= '<td style="border: 1px solid black;">' . $data->username . '</td>';
    $table .= '<td style="border: 1px solid black;">' . $data->first_name . ' ' . $data->last_name . '</td>';
    $table .= '<td style="border: 1px solid black;">' . $data->area . '</td>';
    $table .= '<td style="border: 1px solid black;">' . ($data->status ? 'Enabled' : 'Disabled') . '</td>';
    $table .= '<td style="border: 1px solid black;">' . $data->updated_at . '</td>';
    $table .= '</tr>';

    $table .= '</table>';

    $table .= '<table style="border-collapse: collapse; border: 1px solid black;">';

    $table .= '<tr style="border: 1px solid black;">';
    $table .= '<th style="text-align: center; border: 1px solid black;" colspan="2">MODUL</th>';
    $table .= '<th style="text-align: center; border: 1px solid black;">View</th>';
    $table .= '<th style="text-align: center; border: 1px solid black;">Edit</th>';
    $table .= '<th style="text-align: center; border: 1px solid black;">Delete</th>';
    $table .= '</tr>';

    $modules = \App\Models\UserRoleDetail::where('roles_id', $data->roles_id)
      ->leftjoin('tr_modules', 'tr_modules.id', '=', 'tr_user_roles_detail.modul_id')
      ->get()
      ->toArray();

    foreach ($modules as $key => $value) {
      $table .= '<tr>';
      $table .= '<td style="padding: 2px 10px; border: 1px solid black;">' . $value['group_name'] . '</td>';
      $table .= '<td style="padding: 2px 10px; border: 1px solid black;">' . $value['modul_name'] . '</td>';
      $table .= '<td style="padding: 2px 10px; border: 1px solid black;">' . ($value['view'] ? 'Yes' : 'No') . '</td>';
      $table .= '<td style="padding: 2px 10px; border: 1px solid black;">' . ($value['edit'] ? 'Yes' : 'No') . '</td>';
      $table .= '<td style="padding: 2px 10px; border: 1px solid black;">' . ($value['delete'] ? 'Yes' : 'No') . '</td>';
      $table .= '</tr>';
    }

    $table .= '</table>';

    return $table;
  }
}
