<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\BranchDriver;
use DataTables;
use DB;
use Illuminate\Http\Request;

class BranchMasterDriverController extends Controller
{

  public function index(Request $request)
  {
    if ($request->ajax()) {
      $query = BranchDriver::select(
        'wms_branch_driver.*',
        DB::raw('wms_branch_expedition.expedition_name')
      )
        ->leftjoin('wms_branch_expedition', 'wms_branch_expedition.code', '=', 'wms_branch_driver.expedition_code')
      ;

      $datatables = DataTables::of($query)
        ->addIndexColumn() //DT_RowIndex (Penomoran)
        ->addColumn('action', function ($data) {
          $action = '';
          $action .= ' ' . get_button_edit(url('branch-master-driver/' . $data->driver_id . '/edit'));
          $action .= ' ' . get_button_delete();
          return $action;
        });

      return $datatables->make(true);
    }
    return view('web.master.branch-master-driver.index');
  }

  public function create()
  {

    return view('web.master.branch-master-driver.create');
  }

  public function store(Request $request)
  {
    $request->validate([
      'driving_lisence_no' => 'required',
      'photo_name'         => 'image',
    ]);

    $branchDriver = new BranchDriver;

    $branchDriver->expedition_code = $request->input('expedition_code');

    // DRIVER ID = Expedition Code - YY - nomor
    $prefix = $branchDriver->expedition_code . '-' . date('y');

    $prefix_length = strlen($prefix);
    $max_no        = DB::select('SELECT MAX(SUBSTR(driver_id, ?)) AS max_no FROM wms_branch_driver WHERE SUBSTR(driver_id,1,?) = ? ', [$prefix_length + 2, $prefix_length, $prefix])[0]->max_no;
    $max_no        = str_pad($max_no + 1, 3, 0, STR_PAD_LEFT);

    $driver_id = $prefix . '-' . $max_no;

    $photo_name = '';
    if (!empty($request->file('photo_name'))) {
      $photo_name = $branchDriver->expedition_code . date('y') . $max_no . '.' . $request->file('photo_name')->extension();
      $path       = $request->file('photo_name')->storeAs(
        'Photo', $photo_name
      );
      $branchDriver->photo_name = $photo_name;
    }

    $branchDriver->driver_id            = $driver_id;
    $branchDriver->driver_name          = $request->input('driver_name');
    $branchDriver->driving_lisence_type = $request->input('driving_lisence_type');
    $branchDriver->driving_lisence_no   = $request->input('driving_lisence_no');
    $branchDriver->ktp_no               = $request->input('ktp_no');
    $branchDriver->phone1               = $request->input('phone1');
    $branchDriver->phone2               = $request->input('phone2');
    $branchDriver->remarks1             = $request->input('remarks1');
    $branchDriver->remarks2             = $request->input('remarks2');
    $branchDriver->remarks3             = $request->input('remarks3');
    $branchDriver->active_status        = $request->input('active_status');
    $branchDriver->kode_cabang          = $request->input('kode_cabang');
    $branchDriver->active_status        = !empty($request->input('active_status'));

    $branchDriver->save();

    return $branchDriver;
  }

  public function edit($id)
  {
    $data['branchDriver'] = BranchDriver::findOrFail($id);

    return view('web.master.branch-master-driver.edit', $data);
  }

  public function update(Request $request, $id)
  {
    $branchDriver = BranchDriver::findOrFail($id);

    $request->validate([
      'driving_lisence_no' => 'required',
      // 'photo_name'         => 'image',
    ]);

    // $branchDriver->expedition_code = $request->input('expedition_code');

    if (!empty($request->file('photo_name'))) {
      $photo_name = str_replace('-', '', $branchDriver->driver_id) . '.' . $request->file('photo_name')->extension();
      $path       = $request->file('photo_name')->storeAs(
        'public/Photo', $photo_name
      );
      $branchDriver->photo_name = $photo_name;
    }

    $branchDriver->driver_name          = $request->input('driver_name');
    $branchDriver->driving_lisence_type = $request->input('driving_lisence_type');
    $branchDriver->driving_lisence_no   = $request->input('driving_lisence_no');
    $branchDriver->ktp_no               = $request->input('ktp_no');
    $branchDriver->phone1               = $request->input('phone1');
    $branchDriver->phone2               = $request->input('phone2');
    $branchDriver->remarks1             = $request->input('remarks1');
    $branchDriver->remarks2             = $request->input('remarks2');
    $branchDriver->remarks3             = $request->input('remarks3');
    $branchDriver->active_status        = $request->input('active_status');
    $branchDriver->kode_cabang          = $request->input('kode_cabang');
    $branchDriver->active_status        = !empty($request->input('active_status'));

    $branchDriver->save();

    return $branchDriver;
  }

  public function destroy($id)
  {
    return BranchDriver::destroy($id);
  }

  public function getSelect2ActiveExpedition(Request $request)
  {
    $query = BranchDriver::select(
      DB::raw("code AS id"),
      DB::raw("CONCAT(code, '-', expedition_name) AS text")
    )
      ->where('status_active', 1)
      ->toBase();

    return get_select2_data($request, $query);
  }
}
