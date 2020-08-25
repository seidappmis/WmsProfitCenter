<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Concept;
use App\Models\DriverRegistered;
use App\Models\InventoryStorage;
use App\Models\ManualConcept;
use App\Models\MasterModel;
use App\Models\PickinglistDetail;
use App\Models\PickinglistHeader;
use DataTables;
use DB;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class PickingListController extends Controller
{
  public function index(Request $request)
  {
    if ($request->ajax()) {
      $query = PickinglistHeader::where('area', auth()->user()->area)
        ->where('kode_cabang', auth()->user()->cabang->kode_cabang)
        ->get();

      $datatables = DataTables::of($query)
        ->addIndexColumn() //DT_RowIndex (Penomoran)
        ->editColumn('driver_name', function ($data) {
          $driver_name = '';
          if (!empty($data->vehicle_number)) {
            $driver_name .= $data->vehicle_number . '<br>';
          } else {
            $driver_name .= '<span class="red-text">No Vehicle<br>Number</span>';
          }

          $driver_name .= $data->driver_name;

          if ($data->city_code == 'AS') {
            $driver_name = $data->city_name;
          }

          return $driver_name;
        })
        ->addColumn('do_status', function ($data) {
          return $data->details()->count() > 0 ? 'DO Already' : '<span class="red-text">DO not yet assign</span>';
        })
        ->addColumn('lmb', function ($data) {
          $lmb = $data->lmb_details->count() > 0 ? "Loading Process" : '-';
          if (!empty($data->lmb_header) && $data->lmb_header->send_manifest) {
            $lmb = 'LMB Send Manifest';
          }
          return $lmb;
        })
        ->addColumn('action', function ($data) {
          $action = '';
          if ($data->lmb_details->count() == 0) {
            $action .= ' ' . get_button_edit(url('picking-list/' . $data->id . '/edit'));
            $action .= ' ' . get_button_delete('Cancel');
          } else {
            $action .= ' ' . get_button_view(url('picking-list/' . $data->id));
          }
          return $action;
        })
        ->rawColumns(['driver_name', 'do_status', 'action']);

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
      $query = DriverRegistered::transporterWaitingConcept($request)
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
      $picking->vehicle_code_type  = $driverRegistered->vehicle_code_type;
      $picking->vehicle_number     = $driverRegistered->vehicle_number;
      $picking->gate_number        = $request->input('gate_number');
      $picking->destination_number = $driverRegistered->destination_number;
      $picking->destination_name   = $driverRegistered->destination_name;
      $picking->city_code          = $request->input('city_code');
      $picking->city_name          = $request->input('city_name');
      $picking->assign_driver_date = date('Y-m-d H:i:s');
      $picking->assign_driver_by   = auth()->user()->username;

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
    $pickinglistHeader->picking_date       = date('Y-m-d H:i:s');
    $pickinglistHeader->picking_no         = $picking_no;
    $pickinglistHeader->area               = auth()->user()->area;
    $pickinglistHeader->gate_number        = !empty($request->input('gate_number')) ? $request->input('gate_number') : 0;
    $pickinglistHeader->pdo                = $request->input('pdo');
    $pickinglistHeader->destination_number = $request->input('destination_number');
    $pickinglistHeader->destination_name   = $request->input('destination_name');
    $pickinglistHeader->picking_urut_no    = $request->input('picking_urut_no');
    $pickinglistHeader->HQ                 = auth()->user()->cabang->hq;
    $pickinglistHeader->kode_cabang        = auth()->user()->cabang->kode_cabang;
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
      $pickinglistHeader->driver_register_id = $request->input('driver_register_id');
      $pickinglistHeader->expedition_code    = $request->input('expedition_code');
      $pickinglistHeader->expedition_name    = $request->input('expedition_name');
      $pickinglistHeader->vehicle_code_type  = $request->input('vehicle_code_type');
      $pickinglistHeader->vehicle_number     = $request->input('vehicle_number');
      $pickinglistHeader->driver_id          = $request->input('driver_id');
      $pickinglistHeader->driver_name        = $request->input('driver_name');
    } else {
      $pickinglistHeader->expedition_code = 'AS';
      $pickinglistHeader->expedition_name = 'Ambil Sendiri';

    }

    if ($pickinglistHeader->city_code == "AS" || !auth()->user()->cabang->hq) {
      $pickinglistHeader->driver_register_id = Uuid::uuid4();
    }

    $pickinglistHeader->save();

    return sendSuccess('Create New Pickinglist no ' . $pickinglistHeader->picking_no . ' success', $pickinglistHeader);
  }

  public function splitConcept(Request $request)
  {
    $total_quantity_split = 0;

    $maxConcept = Concept::select(
      DB::raw('MAX(line_no) AS max_line_no'),
      DB::raw('MAX(delivery_items) AS max_delivery_items')
    )
      ->where('invoice_no', $request->input('invoice_no'))
      ->first();

    $max_line_no        = $maxConcept->max_line_no;
    $max_delivery_items = $maxConcept->max_delivery_items;

    $concept = Concept::where('invoice_no', $request->input('invoice_no'))
      ->where('line_no', $request->input('line_no'))->first();

    $rs_split_concept = [];
    $dateTime         = date('Y-m-d H:i:s');

    foreach ($request->input('quantity_split') as $key => $value) {
      $total_quantity_split += $value;

      $split_concept = $concept->toArray();
      $max_line_no++;
      $max_delivery_items += 10;

      $split_concept['line_no']        = $max_line_no;
      $split_concept['delivery_items'] = $max_delivery_items;
      $split_concept['cbm']            = ($split_concept['cbm'] / $concept->quantity * $value);
      $split_concept['quantity']       = $value;
      $split_concept['split_by']       = auth()->user()->username;
      $split_concept['split_date']     = $dateTime;

      $rs_split_concept[] = $split_concept;

    }

    if ($total_quantity_split != $request->input('quantity')) {
      return sendError('Error : Total Quantity is different from Parent Quantity !');
    }

    try {
      DB::beginTransaction();
      Concept::where('invoice_no', $request->input('invoice_no'))
        ->where('line_no', $request->input('line_no'))->delete();
      Concept::insert($rs_split_concept);
      DB::commit();

      return sendSuccess('Concept has been split', $concept);
    } catch (Throwable $e) {
      DB::rollBack();
    }

    return $rs_split_concept;

  }

  public function show(Request $request, $id)
  {
    $data['pickinglistHeader'] = PickinglistHeader::findOrFail($id);

    if ($request->ajax()) {
      $query = $data['pickinglistHeader']->detailWithLMB()
        ->get();

      $datatables = DataTables::of($query)
        ->addIndexColumn() //DT_RowIndex (Penomoran)
      // ->addColumn('quantity_in_lmb', function ($data) {
      //   return '-';
      // })
        ->addColumn('action', function ($data) {
          $action = '';
          if ($data->quantity_in_lmb == 0) {
            $action .= ' ' . get_button_delete('Delete');
          }
          return $action;
        })
        ->rawColumns(['do_status', 'action']);

      return $datatables->make(true);
    }

    return view('web.picking.picking-list.view', $data);
  }

  public function doOrShipmentData(Request $request)
  {
    $request->validate([
      'picking_id' => 'required',
    ]);

    $pickinglistHeader = PickinglistHeader::findOrFail($request->input('picking_id'));

    if (auth()->user()->cabang->hq && $pickinglistHeader->city_code != "AS") {
      // HQ ambil dari Concept
      $query = Concept::select('tr_concept.*')
        ->leftjoin('wms_pickinglist_detail', function ($join) {
          $join->on('wms_pickinglist_detail.invoice_no', '=', 'tr_concept.invoice_no');
          $join->on('wms_pickinglist_detail.delivery_no', '=', 'tr_concept.delivery_no');
        })
        ->whereNull('wms_pickinglist_detail.id') // Ambil yang belum masuk picking list
      // ->whereRaw('(tr_concept.invoice_no = "' . $request->input('do_or_shipment') . '" OR tr_concept.delivery_no = "' . $request->input('do_or_shipment') . '")');
      // ->whereRaw('(tr_concept.invoice_no like "%' . $request->input('do_or_shipment') . '%" OR tr_concept.delivery_no like "%' . $request->input('do_or_shipment') . '%")')
      ;

      if ($request->input('filter_type') == 'shipment') {
        $query->where('tr_concept.invoice_no', $request->input('do_or_shipment'));
      } else {
        $query->where('tr_concept.delivery_no', $request->input('do_or_shipment'));
      }

      foreach (json_decode($request->input('selected_list'), true) as $key => $value) {
        $query->whereRaw('CONCAT(tr_concept.invoice_no, tr_concept.delivery_no, tr_concept.delivery_items) != ?', [$value]);
      }

    } else {
      // Cabang Ambil Dari Upload DO for Picking
      $query = ManualConcept::select(
        'wms_manual_concept.*',
        DB::raw('"" AS line_no')
      )
        ->leftjoin('wms_pickinglist_detail', function ($join) {
          $join->on('wms_pickinglist_detail.invoice_no', '=', 'wms_manual_concept.invoice_no');
          $join->on('wms_pickinglist_detail.delivery_no', '=', 'wms_manual_concept.delivery_no');
        })
        ->whereNull('wms_pickinglist_detail.id') // Ambil yang belum masuk picking list
      // ->whereRaw('(invoice_no like "%' . $request->input('do_or_shipment') . '%" OR delivery_no like "%' . $request->input('do_or_shipment') . '%")')
      ;

      if ($request->input('filter_type') == 'shipment') {
        $query->where('wms_manual_concept.invoice_no', $request->input('do_or_shipment'));
      } else {
        $query->where('wms_manual_concept.delivery_no', $request->input('do_or_shipment'));
      }

      foreach (json_decode($request->input('selected_list'), true) as $key => $value) {
        $query->whereRaw('CONCAT(wms_manual_concept.invoice_no, wms_manual_concept.delivery_no, wms_manual_concept.delivery_items) != ?', [$value]);
      }

    }

    // return $query->get();

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

    $pickinglistHeader = PickinglistHeader::findOrFail($request->input('picking_id'));
    // echo $pickinglistHeader->storage_id;
    // exit;

    $rs_pickinglistDetail = [];

    $base_id              = auth()->user()->id . date('YMdHis');
    $rs_models            = [];
    $rs_inventory_storage = [];

    foreach (json_decode($request->input('selected_list'), true) as $key => $value) {
      if (empty($value['ean_code'])) {
        if (empty($rs_models[$value['model']])) {
          $model = MasterModel::where('model_name', $value['model'])->first();
          if (empty($model)) {
            return sendError('Model ' . $value['model'] . ' not found in master model !');
          }
          $rs_models[$value['model']] = $model;
        }
      }

      $pickingListDetail['id']             = $base_id . $key;
      $pickingListDetail['header_id']      = $request->input('picking_id');
      $pickingListDetail['invoice_no']     = $value['invoice_no'];
      $pickingListDetail['line_no']        = 1;
      $pickingListDetail['delivery_no']    = $value['delivery_no'];
      $pickingListDetail['delivery_items'] = $value['delivery_items'];
      $pickingListDetail['model']          = $value['model'];
      $pickingListDetail['quantity']       = $value['quantity'];
      $pickingListDetail['cbm']            = $value['cbm'];
      $pickingListDetail['ean_code']       = empty($value['ean_code']) ? $rs_models[$value['model']]->ean_code : $value['ean_code'];
      $pickingListDetail['code_sales']     = $value['code_sales'];
      $pickingListDetail['remarks']        = $value['remarks'];
      $pickingListDetail['kode_customer']  = empty($value['kode_customer']) ? $value['ship_to_code'] : $value['kode_customer'];

      // Check Inventory Storage
      if (empty($rs_inventory_storage[$pickingListDetail['ean_code']])) {
        $inventoryStorage = InventoryStorage::where('ean_code', $pickingListDetail['ean_code'])
          ->where('storage_id', $pickinglistHeader->storage_id)
          ->first();

        if (empty($inventoryStorage)) {
          return sendError('Model ' . $value['model'] . ' not exist in storage !');
        }
        $rs_inventory_storage[$pickingListDetail['ean_code']] = $inventoryStorage;
      }

      $rs_inventory_storage[$pickingListDetail['ean_code']]->quantity_total -= $pickingListDetail['quantity'];

      if ($rs_inventory_storage[$pickingListDetail['ean_code']]->quantity_total < 0) {
        return sendError('Quantity of model ' . $value['model'] . ' is defisit !');
      }

      $rs_pickinglistDetail[] = $pickingListDetail;
    }

    PickinglistDetail::insert($rs_pickinglistDetail);

    return sendSuccess('Items Submited to picking list.', $rs_pickinglistDetail);
  }

  public function destroy($id)
  {
    PickinglistDetail::where('header_id', $id)->delete();
    return PickinglistHeader::destroy($id);
  }

  public function destroyDetail($id)
  {
    return PickinglistDetail::destroy($id);
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

  public function export(Request $request, $id)
  {
    $data['pickinglistHeader'] = PickinglistHeader::findOrFail($id);

    $view_print = view('web.picking.picking-list._print', $data);
    $title      = 'picking_list';

    if ($request->input('filetype') == 'html') {

      // request HTML View
      return $view_print;

    } elseif ($request->input('filetype') == 'xls') {

      // Request FILE EXCEL
      $reader      = new \PhpOffice\PhpSpreadsheet\Reader\Html();
      $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

      $spreadsheet = $reader->loadFromString($view_print, $spreadsheet);

      // Set warna background putih
      $spreadsheet->getDefaultStyle()->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('ffffff');
      // Set Font
      $spreadsheet->getDefaultStyle()->getFont()->setName('courier New');

      // Atur lebar kolom
      $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(20);
      $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);

      $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment; filename="' . $title . '.xls"');

      $writer->save("php://output");

    } else if ($request->input('filetype') == 'pdf') {

      // REQUEST PDF
      $mpdf = new \Mpdf\Mpdf(['tempDir' => '/tmp']);

      $mpdf->WriteHTML($view_print, \Mpdf\HTMLParserMode::HTML_BODY);

      $mpdf->Output($title . '.pdf', "D");

    } else {
      // Parameter filetype tidak valid / tidak ditemukan return 404
      return redirect(404);
    }
  }

}
