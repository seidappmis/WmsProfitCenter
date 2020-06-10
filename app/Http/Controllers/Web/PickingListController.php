<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\ManualConcept;
use App\Models\PickinglistDetail;
use App\Models\PickinglistHeader;
use App\Models\DriverRegistered;
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

  public function transporterList(Request $request)
  {
    if ($request->ajax()) {
      $query = DriverRegistered::where('area', $request->input('area'))
        ->whereNull('datetime_out')
        ->get();

      $datatables = DataTables::of($query)
        ->addIndexColumn() //DT_RowIndex (Penomoran)
        ->addColumn('cbm_max', function ($data) {
          return $data->vehicle->cbm_max;
        })
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

  public function assignPicking($id){
    $data['driverRegistered'] = DriverRegistered::findOrFail($id);

    return view('web.picking.picking-list.assign-picking', $data);
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
    $pickinglistHeader->driver_register_id = $request->input('driver_register_id');
    $pickinglistHeader->driver_id          = $request->input('driver_id');
    $pickinglistHeader->driver_name        = $request->input('driver_name');
    $pickinglistHeader->vehicle_number     = $request->input('vehicle_number');
    $pickinglistHeader->expedition_code    = $request->input('expedition_code');
    $pickinglistHeader->expedition_name    = $request->input('expedition_name');
    $pickinglistHeader->area               = auth()->user()->area;
    $pickinglistHeader->gate_number        = $request->input('gate_number');
    $pickinglistHeader->pdo                = $request->input('pdo');
    $pickinglistHeader->destination_number = $request->input('destination_number');
    $pickinglistHeader->destination_name   = $request->input('destination_name');
    $pickinglistHeader->picking_urut_no    = $request->input('picking_urut_no');
    $pickinglistHeader->HQ                 = 1;
    $pickinglistHeader->kode_cabang        = $request->input('kode_cabang');
    $pickinglistHeader->vehicle_code_type  = $request->input('vehicle_code_type');
    $pickinglistHeader->city_code          = $request->input('city_code');
    $pickinglistHeader->city_name          = $request->input('city_name');
    $pickinglistHeader->storage_id         = $request->input('storage_id');
    $pickinglistHeader->storage_type       = $request->input('storage_name');
    $pickinglistHeader->start_date         = $request->input('start_date');
    $pickinglistHeader->start_by           = $request->input('start_by');
    $pickinglistHeader->finish_date        = $request->input('finish_date');
    $pickinglistHeader->finish_by          = $request->input('finish_by');
    $pickinglistHeader->assign_driver_date = $request->input('assign_driver_date');
    $pickinglistHeader->assign_driver_by   = $request->input('assign_driver_by');
    $pickinglistHeader->start_picking_date = $request->input('start_picking_date');

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

    foreach (json_decode($request->input('selected_list'), true) as $key => $value) {
      $pickingListDetail['id']             = $request->input('picking_id') . $key;
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

  public function edit($id)
  {
    $data['pickinglistHeader'] = PickinglistHeader::findOrFail($id);

    return view('web.picking.picking-list.edit', $data);
  }

}
