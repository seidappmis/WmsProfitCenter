<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\DriverRegistered;
use App\Models\ManualConcept;
use App\Models\PickinglistDetail;
use App\Models\PickinglistHeader;
use DataTables;
use DB;
use Illuminate\Http\Request;

class PickingListController extends Controller
{
  public function index(Request $request)
  {
    if ($request->ajax()) {
      $query = PickinglistHeader::where('area', auth()->user()->area)
        ->get();

      $datatables = DataTables::of($query)
        ->addIndexColumn() //DT_RowIndex (Penomoran)
        ->addColumn('do_status', function ($data) {
          return $data->details()->count() > 0 ? 'DO Already' : '<span class="red-text">DO not yet assign</span>';
        })
        ->addColumn('lmb', function ($data) {
          return '-';
        })
        ->addColumn('action', function ($data) {
          $action = '';
          $action .= ' ' . get_button_edit(url('picking-list/' . $data->id . '/edit'));
          $action .= ' ' . get_button_delete('Cancel');
          return $action;
        })
        ->rawColumns(['do_status', 'action']);

      return $datatables->make(true);
    }

    return view('web.picking.picking-list.index');
  }

  public function getNonAssignedPicking(Request $request)
  {
    if ($request->ajax()) {
      $query = PickinglistHeader::has('details')
        ->where('area', auth()->user()->area)
        ->whereNull('driver_register_id')
        ->get();

      $datatables = DataTables::of($query)
        ->addIndexColumn() //DT_RowIndex (Penomoran)
      ;
      return $datatables->make(true);
    }
  }

  public function getSelect2DriverByRegisterID(Request $request)
  {
    $query = DriverRegistered::select(
      DB::raw("tr_driver_registered.driver_id AS id"),
      DB::raw("tr_driver_registered.driver_name AS text"),
    )
      ->toBase()
      ->where('id', $request->input('driver_register_id'))
    ;

    return get_select2_data($request, $query);
  }

  public function getSelect2VehicleNumber(Request $request)
  {
    $query = DriverRegistered::select(
      DB::raw("tr_driver_registered.id AS driver_register_id"),
      DB::raw("tr_driver_registered.vehicle_number AS id"),
      DB::raw("tr_driver_registered.vehicle_number AS text"),
      DB::raw("tr_driver_registered.driver_id"),
      DB::raw("tr_driver_registered.driver_name")
    )
      ->toBase()
      ->leftjoin('wms_pickinglist_header', 'wms_pickinglist_header.driver_register_id', '=', 'tr_driver_registered.id')
      ->where('tr_driver_registered.area', auth()->user()->area)
      ->where('tr_driver_registered.vehicle_code_type', $request->input('vehicle_code_type'))
      ->where('tr_driver_registered.expedition_code', $request->input('expedition_code'))
      ->whereNull('wms_pickinglist_header.driver_register_id')
      ->whereNull('datetime_out')
    ;

    return get_select2_data($request, $query);
  }

  public function transporterList(Request $request)
  {
    if ($request->ajax()) {
      $query = DriverRegistered::select('tr_driver_registered.*', 'tr_vehicle_type_detail.cbm_max')
        ->toBase()->where('tr_driver_registered.area', $request->input('area'))
        ->leftjoin('tr_vehicle_type_detail', 'tr_vehicle_type_detail.vehicle_code_type', '=', 'tr_driver_registered.vehicle_code_type')
        ->leftjoin('wms_pickinglist_header', 'wms_pickinglist_header.driver_register_id', '=', 'tr_driver_registered.id')
        ->whereNull('wms_pickinglist_header.driver_register_id')
        ->whereNull('datetime_out')
        ->get();

      $datatables = DataTables::of($query)
        ->addIndexColumn() //DT_RowIndex (Penomoran)
        ->addColumn('action', function ($data) {
          $action = '';
          $action .= ' ' . get_button_view(url('picking-list/transporter/' . $data->id), 'Assign Picking');
          $action .= ' ' . get_button_edit(url('picking-list/transporter/' . $data->id . '/edit'));
          $action .= ' ' . get_button_delete('Is Leave');
          return $action;
        });

      return $datatables->make(true);
    }
  }

  public function assignPicking($id)
  {
    $data['driverRegistered'] = DriverRegistered::findOrFail($id);

    return view('web.picking.picking-list.assign-picking', $data);
  }

  public function storeAssignPicking(Request $request, $id)
  {
    $driverRegistered = DriverRegistered::findOrFail($id);

    foreach (json_decode($request->input('data_picking'), true) as $key => $value) {
      $picking = PickinglistHeader::find($value['id']);

      $picking->driver_register_id = $id;
      $picking->driver_id          = $driverRegistered->driver_id;
      $picking->driver_name        = $driverRegistered->driver_name;
      $picking->vehicle_number     = $driverRegistered->vehicle_number;
      $picking->expedition_code    = $driverRegistered->expedition_code;
      $picking->expedition_name    = $driverRegistered->expedition_name;
      $picking->gate_number        = $request->input('gate_number');
      $picking->destination_number = $request->input('destination_number');
      $picking->destination_name   = $request->input('destination_name');
      $picking->city_code          = $request->input('city_code');
      $picking->city_name          = $request->input('city_name');

      $picking->save();

    }
  }

  public function create()
  {
    return view('web.picking.picking-list.create');
  }

  public function store(Request $request)
  {
    $pickinglistHeader = new PickinglistHeader;

    // picking no => kodecabang tanggal(Ymd) urut 3 digit
    $prefix = auth()->user()->cabang->kode_cabang . date('Ymd');

    $prefix_length = strlen($prefix);
    $max_no        = DB::select('SELECT MAX(SUBSTR(picking_no, ?)) AS max_no FROM wms_pickinglist_header WHERE SUBSTR(picking_no,1,?) = ? ', [$prefix_length + 2, $prefix_length, $prefix])[0]->max_no;
    $max_no        = str_pad($max_no + 1, 3, 0, STR_PAD_LEFT);

    $picking_no = $prefix . $max_no;

    $pickinglistHeader->id                 = $picking_no;
    $pickinglistHeader->picking_date       = date('Y-m-d H:i:s', strtotime($request->input('picking_date')));
    $pickinglistHeader->picking_no         = $picking_no;
    $pickinglistHeader->area               = auth()->user()->area;
    $pickinglistHeader->gate_number        = $request->input('gate_number');
    $pickinglistHeader->pdo                = $request->input('pdo');
    $pickinglistHeader->destination_number = $request->input('destination_number');
    $pickinglistHeader->destination_name   = $request->input('destination_name');
    $pickinglistHeader->picking_urut_no    = $request->input('picking_urut_no');
    $pickinglistHeader->HQ                 = 1;
    $pickinglistHeader->kode_cabang        = $request->input('kode_cabang');
    $pickinglistHeader->storage_id         = $request->input('storage_id');
    $pickinglistHeader->storage_type       = $request->input('storage_name');
    $pickinglistHeader->city_code          = $request->input('city_code');
    $pickinglistHeader->city_name          = $request->input('city_name');
    $pickinglistHeader->start_date         = $request->input('start_date');
    $pickinglistHeader->start_by           = $request->input('start_by');
    $pickinglistHeader->finish_date        = $request->input('finish_date');
    $pickinglistHeader->finish_by          = $request->input('finish_by');
    $pickinglistHeader->assign_driver_date = $request->input('assign_driver_date');
    $pickinglistHeader->assign_driver_by   = $request->input('assign_driver_by');
    $pickinglistHeader->start_picking_date = $request->input('start_picking_date');

    if ($pickinglistHeader->city_code != "AS") {
      $pickinglistHeader->expedition_code    = $request->input('expedition_code');
      $pickinglistHeader->expedition_name    = $request->input('expedition_name');
      $pickinglistHeader->vehicle_code_type  = $request->input('vehicle_code_type');
      $pickinglistHeader->driver_register_id = $request->input('driver_register_id');
      $pickinglistHeader->vehicle_number     = $request->input('vehicle_number');
      $pickinglistHeader->driver_id          = $request->input('driver_id');
      $pickinglistHeader->driver_name        = $request->input('driver_name');
    }

    $pickinglistHeader->save();

    return $pickinglistHeader;
  }

  public function show(Request $request, $id)
  {
    if ($request->ajax()) {
      $query = PickinglistHeader::findOrFail($id)->details()
        ->get();

      $datatables = DataTables::of($query)
        ->addIndexColumn() //DT_RowIndex (Penomoran)
        ->addColumn('quantity_in_lmb', function ($data) {
          return '-';
        })
        ->addColumn('action', function ($data) {
          $action = '';
          $action .= ' ' . get_button_delete('Delete');
          return $action;
        })
        ->rawColumns(['do_status', 'action']);

      return $datatables->make(true);
    }
  }

  public function doOrShipmentData(Request $request)
  {
    $query = ManualConcept::whereRaw('(invoice_no like "%' . $request->input('do_or_shipment') . '%" OR delivery_no like "%' . $request->input('do_or_shipment') . '%")');

    foreach (json_decode($request->input('selected_list'), true) as $key => $value) {
      $query->whereRaw('CONCAT(invoice_no, delivery_no, delivery_items) != ?', [$value]);
    }

    $datatables = DataTables::of($query)
      ->addIndexColumn() //DT_RowIndex (Penomoran)
      ->addColumn('action', function ($data) {
        $action = '';
        $action .= ' ' . get_button_save('Pick', 'btn-pick');
        $action .= ' ' . get_button_save('Split', 'btn-split');
        return $action;
      });

    return $datatables->make(true);
  }

  public function submitDO(Request $request)
  {
    $request->validate([
      'picking_id' => 'required',
    ]);

    $rs_pickinglistDetail = [];

    $base_id = auth()->user()->id . date('YMdHis');

    foreach (json_decode($request->input('selected_list'), true) as $key => $value) {
      $pickingListDetail['id']             = $base_id . $key;
      $pickingListDetail['header_id']      = $request->input('picking_id');
      $pickingListDetail['invoice_no']     = $value['invoice_no'];
      $pickingListDetail['line_no']        = 1;
      $pickingListDetail['delivery_no']    = $value['delivery_no'];
      $pickingListDetail['delivery_items'] = $value['delivery_items'];
      $pickingListDetail['model']          = $value['model'];
      $pickingListDetail['quantity']       = $value['quantity'];
      $pickingListDetail['cbm']            = $value['cbm'];
      $pickingListDetail['ean_code']       = $value['ean_code'];
      $pickingListDetail['code_sales']     = $value['code_sales'];
      $pickingListDetail['remarks']        = $value['remarks'];
      $pickingListDetail['kode_customer']  = $value['kode_customer'];

      $rs_pickinglistDetail[] = $pickingListDetail;
    }

    PickinglistDetail::insert($rs_pickinglistDetail);

    return true;
  }

  public function destroy($id)
  {
    PickinglistDetail::where('header_id', $id)->delete();
    return PickinglistHeader::destroy($id);
  }

  public function edit($id)
  {
    $data['pickinglistHeader'] = PickinglistHeader::findOrFail($id);

    return view('web.picking.picking-list.edit', $data);
  }

  public function editTransporter($id)
  {
    $data['driverRegistered'] = DriverRegistered::findOrFail($id);

    return view('web.picking.picking-list.edit_transporter', $data);
  }

}
