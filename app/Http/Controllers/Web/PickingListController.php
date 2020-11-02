<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Concept;
use App\Models\ConceptFlowDetail;
use App\Models\ConceptFlowHeader;
use App\Models\ConceptTruckFlow;
use App\Models\DriverRegistered;
use App\Models\InventoryStorage;
use App\Models\LMBDetail;
use App\Models\LMBHeader;
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
      $query = PickinglistHeader::select(
        'wms_pickinglist_header.id',
        'wms_pickinglist_header.picking_date',
        'wms_pickinglist_header.vehicle_number',
        'wms_pickinglist_header.driver_name',
        'wms_pickinglist_header.city_name',
        'wms_pickinglist_header.expedition_name',
        'wms_pickinglist_header.storage_type',
        DB::raw('GROUP_CONCAT(picking_no SEPARATOR ",<br>") as picking_no')
      )
        ->groupBy('wms_pickinglist_header.driver_register_id')
      ;

      if (!auth()->user()->cabang->hq) {
        $query->where('wms_pickinglist_header.kode_cabang', auth()->user()->cabang->kode_cabang);
      } else {
        $query->where('wms_pickinglist_header.area', $request->input('area'));
      }
      // if (auth()->user()->area != "All") {
      // } else {
      //   $query->where('wms_pickinglist_header.hq', 1);

      // }

      // Tampilkan data yang belum ada manifest bila tidak di search
      $query->leftjoin('wms_lmb_header', 'wms_lmb_header.driver_register_id', '=', 'wms_pickinglist_header.driver_register_id');
      if (empty($request->input('search')['value'])) {
        $query->whereRaw('(wms_lmb_header.driver_register_id IS NULL OR wms_lmb_header.send_manifest = 0)');
      }

      // if (auth()->user()->cabang->hq) {
      //   // Tampilkan data yang belum ada manifest bila tidak di search
      //   $query->leftjoin('log_manifest_header', 'log_manifest_header.driver_register_id', '=', 'wms_pickinglist_header.driver_register_id');
      //   if (empty($request->input('search')['value'])) {
      //     $query->whereNull('log_manifest_header.driver_register_id');
      //   }
      // } else {
      //   // Tampilkan data yang belum ada manifest bila tidak di search
      //   $query->leftjoin('wms_branch_manifest_header', 'wms_branch_manifest_header.driver_register_id', '=', 'wms_pickinglist_header.driver_register_id');
      //   if (empty($request->input('search')['value'])) {
      //     $query->whereNull('wms_branch_manifest_header.driver_register_id');
      //   }
      // }

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
        ->rawColumns(['driver_name', 'do_status', 'picking_no', 'action']);

      return $datatables->make(true);
    }

    return view('web.picking.picking-list.index');
  }

  public function getNonAssignedPicking(Request $request)
  {
    if ($request->ajax()) {
      $query = PickinglistHeader::select('wms_pickinglist_header.*')
        ->has('details')
        ->leftjoin('tr_driver_registered', 'tr_driver_registered.id', '=', 'wms_pickinglist_header.driver_register_id')
        ->where('wms_pickinglist_header.area', auth()->user()->area)
        ->where('wms_pickinglist_header.expedition_code', '!=', 'AS')
        ->whereNull('tr_driver_registered.id')
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
      DB::raw("tr_driver_registered.driver_name AS text")
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
      ->leftjoin('log_manifest_header', 'log_manifest_header.r_driver_register_id', '=', 'tr_driver_registered.id')
      ->whereNull('log_manifest_header.driver_register_id')
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
        ->editColumn('driver_id', function ($data) {
          return $data->driver_id . '<br>' . $data->driver_name;
        })
        ->addColumn('action', function ($data) {
          $action = '';
          $action .= ' ' . get_button_view(url('picking-list/transporter/' . $data->id), 'Assign Picking');
          $action .= ' ' . get_button_edit(url('picking-list/transporter/' . $data->id . '/edit'));
          $action .= ' ' . get_button_delete('Is Leave');
          return $action;
        })
        ->rawColumns(['driver_id', 'action']);

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

    if (empty(json_decode($request->input('data_picking'), true))) {
      return sendError("Please Select Picking list");
    }

    try {
      DB::beginTransaction();
      $driverRegistered->wk_step_number = 4;
      $driverRegistered->save();

      // Add concept flow header
      $idConceptFlowHeader = $driverRegistered->id;

      $conceptFlowHeader                     = new ConceptFlowHeader;
      $conceptFlowHeader->id                 = $idConceptFlowHeader;
      $conceptFlowHeader->workflow_id        = 4;
      $conceptFlowHeader->vehicle_code_type  = $driverRegistered->vehicle_code_type;
      $conceptFlowHeader->driver_id          = $driverRegistered->driver_id;
      $conceptFlowHeader->driver_name        = $driverRegistered->driver_name;
      $conceptFlowHeader->expedition_id      = $driverRegistered->expedition->id;
      $conceptFlowHeader->expedition_name    = $driverRegistered->expedition_name;
      $conceptFlowHeader->cbm_truck          = $driverRegistered->vehicle->cbm_max;
      $conceptFlowHeader->cbm_concept        = $driverRegistered->cbm_concept;
      $conceptFlowHeader->area               = $driverRegistered->area;
      $conceptFlowHeader->driver_register_id = $driverRegistered->id;
      $conceptFlowHeader->created_at         = date('Y-m-d H:i:s');
      $conceptFlowHeader->created_by         = auth()->user()->id;
      $conceptFlowHeader->save();

      // concept truck flow
      $conceptTruckFlow                      = new ConceptTruckFlow;
      $conceptTruckFlow->id                  = $idConceptFlowHeader;
      $conceptTruckFlow->concept_flow_header = $idConceptFlowHeader;
      $conceptTruckFlow->gate_number         = $request->input('gate_number');
      $conceptTruckFlow->created_gate_date   = date('Y-m-d H:i:s');
      $conceptTruckFlow->created_gate_by     = auth()->user()->username;
      $conceptTruckFlow->area                = $driverRegistered->area;
      $conceptTruckFlow->save();

      $rs_picking = [];
      foreach (json_decode($request->input('data_picking'), true) as $key => $value) {
        $picking = PickinglistHeader::findOrFail($value['id']);

        $previousDriverRegisterID = $picking->driver_register_id;

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

        $rs_picking[] = $picking;

        // ADD CONCEPT FLOW DETAIL
        foreach ($picking->details as $key => $value) {
          $conceptFlowDetail = new ConceptFlowDetail;

          $conceptFlowDetail->id_header      = $idConceptFlowHeader;
          $conceptFlowDetail->invoice_no     = $value->invoice_no;
          $conceptFlowDetail->line_no        = $value->line_no;
          $conceptFlowDetail->quantity       = $value->quantity;
          $conceptFlowDetail->cbm_max        = $value->cbm;
          $conceptFlowDetail->concept_type   = "STANDAR";
          $conceptFlowDetail->delivery_no    = $value->delivery_no;
          $conceptFlowDetail->delivery_items = $value->delivery_items;

          $conceptFlowDetail->save();

        }

        $lmb = LMBHeader::find($value['id']);
        if (!empty($lmb)) {

          $lmb->driver_register_id = $id;
          $lmb->driver_id          = $driverRegistered->driver_id;
          $lmb->driver_name        = $driverRegistered->driver_name;
          $lmb->vehicle_number     = $driverRegistered->vehicle_number;
          $lmb->expedition_code    = $driverRegistered->expedition_code;
          $lmb->expedition_name    = $driverRegistered->expedition_name;

          $lmb->save();

        }

        LMBDetail::where('driver_register_id', $previousDriverRegisterID)->update(['driver_register_id' => $id]);

      }

      DB::commit();

      return sendSuccess('assign success', $rs_picking);
    } catch (Exception $e) {
      DB::rollBack();
    }
  }

  public function create()
  {
    return view('web.picking.picking-list.create');
  }

  public function store(Request $request)
  {
    $pickinglistHeader = new PickinglistHeader;

    try {
      DB::beginTransaction();
      // picking no => kodecabang tanggal(Ymd) urut 3 digit
      $prefix = auth()->user()->cabang->kode_cabang . date('Ymd');

      $prefix_length   = strlen($prefix);
      $max_no          = DB::select('SELECT MAX(SUBSTR(picking_no, ?)) AS max_no FROM wms_pickinglist_header WHERE SUBSTR(picking_no,1,?) = ? ', [$prefix_length + 2, $prefix_length, $prefix])[0]->max_no;
      $picking_urut_no = $max_no + 1;
      $max_no          = str_pad($max_no + 1, 3, 0, STR_PAD_LEFT);

      $picking_no = $prefix . $max_no;

      $pickinglistHeader->id                 = $picking_no;
      $pickinglistHeader->picking_date       = date('Y-m-d H:i:s');
      $pickinglistHeader->picking_no         = $picking_no;
      $pickinglistHeader->area               = auth()->user()->area;
      $pickinglistHeader->gate_number        = !empty($request->input('gate_number')) ? $request->input('gate_number') : 0;
      $pickinglistHeader->pdo                = $request->input('pdo');
      $pickinglistHeader->destination_number = $request->input('destination_number');
      $pickinglistHeader->destination_name   = $request->input('destination_name');
      $pickinglistHeader->picking_urut_no    = $picking_urut_no;
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
        $expedition_name = !empty($request->input('expedition_name_manual')) ? $request->input('expedition_name_manual') : $request->input('expedition_name');

        if (!auth()->user()->cabang->hq && $request->input('expedition_name') != "ONE TIME") {
          $expedition_name = $request->input('expedition_name');
        } elseif (!auth()->user()->cabang->hq && $request->input('expedition_name') == "ONE TIME") {
          $expedition_name = $request->input('expedition_name_manual');
        }
        $vehicle_number = !empty($request->input('vehicle_number_manual')) ? $request->input('vehicle_number_manual') : $request->input('vehicle_number');
        $driver_name    = !empty($request->input('driver_name_manual')) ? $request->input('driver_name_manual') : $request->input('driver_name');

        if (!auth()->user()->cabang->hq) {
          if (empty($vehicle_number)) {
            return sendError('Please select or insert vehicle no');
          }
          if (empty($driver_name)) {
            return sendError('Please select or insert driver name');
          }
        }

        if (empty($expedition_name)) {
          return sendError('Please input expedition name');
        }

        // $pickinglistHeader->driver_register_id = Uuid::uuid4();
        $pickinglistHeader->driver_register_id = !empty($request->input('driver_register_id')) ? $request->input('driver_register_id') : Uuid::uuid4();
        if (!empty($request->input('driver_register_id'))) {
          $driverRegistered = DriverRegistered::findOrFail($request->input('driver_register_id'));

          // Add concept flow header
          $idConceptFlowHeader                   = $driverRegistered->id;
          $conceptFlowHeader                     = new ConceptFlowHeader;
          $conceptFlowHeader->id                 = $idConceptFlowHeader;
          $conceptFlowHeader->workflow_id        = 4;
          $conceptFlowHeader->workflow_date      = date('Y-m-d H:i:s');
          $conceptFlowHeader->vehicle_code_type  = $driverRegistered->vehicle_code_type;
          $conceptFlowHeader->driver_id          = $driverRegistered->driver_id;
          $conceptFlowHeader->driver_name        = $driverRegistered->driver_name;
          $conceptFlowHeader->expedition_id      = $driverRegistered->expedition->id;
          $conceptFlowHeader->expedition_name    = $driverRegistered->expedition_name;
          $conceptFlowHeader->cbm_truck          = $driverRegistered->vehicle->cbm_max;
          $conceptFlowHeader->cbm_concept        = 0;
          $conceptFlowHeader->driver_register_id = $driverRegistered->id;
          $conceptFlowHeader->created_at         = date('Y-m-d H:i:s');
          $conceptFlowHeader->created_by         = auth()->user()->id;
          $conceptFlowHeader->area               = auth()->user()->area;
          $conceptFlowHeader->save();

          // concept truck flow
          $conceptTruckFlow                      = new ConceptTruckFlow;
          $conceptTruckFlow->id                  = $idConceptFlowHeader;
          $conceptTruckFlow->concept_flow_header = $idConceptFlowHeader;
          $conceptTruckFlow->gate_number         = $pickinglistHeader->gate_number;
          $conceptTruckFlow->created_gate_date   = date('Y-m-d H:i:s');
          $conceptTruckFlow->created_gate_by     = auth()->user()->username;
          $conceptTruckFlow->area                = $driverRegistered->area;
          $conceptTruckFlow->save();

        }

        $pickinglistHeader->expedition_code   = $request->input('expedition_code');
        $pickinglistHeader->expedition_name   = $expedition_name;
        $pickinglistHeader->vehicle_code_type = $request->input('vehicle_code_type');
        $pickinglistHeader->vehicle_number    = $vehicle_number;
        $pickinglistHeader->driver_id         = $request->input('driver_id');
        $pickinglistHeader->driver_name       = $driver_name;
      } else {
        $pickinglistHeader->expedition_code = 'AS';
        $pickinglistHeader->expedition_name = 'Ambil Sendiri';
      }

      if ($pickinglistHeader->city_code == "AS" || !auth()->user()->cabang->hq) {
        $pickinglistHeader->driver_register_id = Uuid::uuid4();
      }

      $pickinglistHeader->save();

      DB::commit();

      return sendSuccess('Create New Pickinglist no ' . $pickinglistHeader->picking_no . ' success', $pickinglistHeader);
    } catch (Exception $e) {
      DB::rollBack();

    }
  }

  public function splitConcept(Request $request)
  {
    $total_quantity_split = 0;

    if (auth()->user()->cabang->hq) {
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
    } else {
      $maxConcept = ManualConcept::select(
        // DB::raw('MAX(line_no) AS max_line_no'),
        DB::raw('MAX(delivery_items) AS max_delivery_items')
      )
        ->where('invoice_no', $request->input('invoice_no'))
        ->where('delivery_no', $request->input('delivery_no'))
        ->first();

      // $max_line_no        = $maxConcept->max_line_no;
      $max_delivery_items = $maxConcept->max_delivery_items;

      $concept = ManualConcept::where('invoice_no', $request->input('invoice_no'))
        ->where('delivery_no', $request->input('delivery_no'))
        ->first();
    }

    $rs_split_concept = [];
    $dateTime         = date('Y-m-d H:i:s');

    foreach ($request->input('quantity_split') as $key => $value) {
      $total_quantity_split += $value;

      $split_concept = $concept->toArray();
      $max_delivery_items += 10;

      if (auth()->user()->cabang->hq) {
        $max_line_no++;
        $split_concept['line_no'] = $max_line_no;
      }

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
      if (auth()->user()->cabang->hq) {
        Concept::where('invoice_no', $request->input('invoice_no'))
          ->where('line_no', $request->input('line_no'))->delete();
        Concept::insert($rs_split_concept);
      } else {
        ManualConcept::where('invoice_no', $request->input('invoice_no'))
          ->where('delivery_no', $request->input('delivery_no'))
          ->where('delivery_items', $request->input('delivery_items'))
          ->delete();
        ManualConcept::insert($rs_split_concept);
      }
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

      $total_cbm = PickinglistHeader::findOrFail($id)->details()->selectRaw('SUM(cbm) AS total_cbm')->first()->total_cbm;

      return $datatables
        ->with('total_cbm', $total_cbm)
        ->make(true);
    }

    return view('web.picking.picking-list.view', $data);
  }

  public function sendToLMB(Request $request, $id)
  {
    $pickingHeader = PickinglistHeader::findOrFail($id);

    $rs_lmb_detail = [];
    $rs_max_no     = [];
    foreach ($pickingHeader->details as $key => $value) {
      $prefix = $value->model;

      if (empty($rs_max_no[$value->ean_code])) {
        $prefix_length = strlen($prefix);
        $max_no        = DB::select('SELECT MAX(SUBSTR(serial_number, ?)) AS max_no FROM wms_lmb_detail WHERE SUBSTR(serial_number,1,?) = ? ', [$prefix_length + 2, $prefix_length, $prefix])[0]->max_no;
        if (empty($max_no)) {
          $max_no = 0;
        }
        $rs_max_no[$value->ean_code] = $max_no + 1;
      }

      for ($i = 0; $i < $value->quantity; $i++) {
        $detail['picking_id']         = $pickingHeader->id;
        $detail['ean_code']           = $value->ean_code;
        $detail['serial_number']      = $value->model . str_pad($rs_max_no[$value->ean_code]++, 3, 0, STR_PAD_LEFT);
        $detail['created_at']         = date('Y-m-d H:i:s');
        $detail['model']              = $value->model;
        $detail['delivery_no']        = $value->delivery_no;
        $detail['invoice_no']         = $value->invoice_no;
        $detail['delivery_items']     = $value->delivery_items;
        $detail['kode_customer']      = $value->kode_customer;
        $detail['code_sales']         = $value->code_sales;
        $detail['city_code']          = $pickingHeader->city_code;
        $detail['city_name']          = $pickingHeader->city_name;
        $detail['driver_register_id'] = $pickingHeader->driver_register_id;
        $detail['cbm_unit']           = $value->cbm / $value->quantity;

        $rs_lmb_detail[] = $detail;
      }
    }

    try {

      if (!empty($rs_lmb_detail)) {
        LMBDetail::insert($rs_lmb_detail);
      }
      return sendSuccess('Picking List sent to lmb', $rs_lmb_detail);
    } catch (Exception $e) {

    }

  }

  public function doOrShipmentData(Request $request)
  {
    $request->validate([
      'picking_id' => 'required',
    ]);

    $pickinglistHeader = PickinglistHeader::findOrFail($request->input('picking_id'));

    // if (auth()->user()->cabang->hq && $pickinglistHeader->city_code != "AS") {
    if (auth()->user()->cabang->hq) {
      // HQ ambil dari Concept
      $query = Concept::select(
        'tr_concept.*',
        DB::raw('MAX(wmcT.line_no) AS max_line_no'),
        DB::raw('MAX(wmcT.delivery_items) AS max_delivery_items')
      )
        ->leftjoin('wms_pickinglist_detail', function ($join) {
          $join->on('wms_pickinglist_detail.invoice_no', '=', 'tr_concept.invoice_no');
          $join->on('wms_pickinglist_detail.delivery_no', '=', 'tr_concept.delivery_no');
          $join->on('wms_pickinglist_detail.delivery_items', '=', 'tr_concept.delivery_items');
        })
        ->leftjoin(DB::raw('tr_concept AS wmcT'), function ($join) {
          $join->on('wmcT.invoice_no', '=', 'tr_concept.invoice_no');
          // $join->on('wmcT.delivery_no', '=', 'tr_concept.delivery_no');
        })
        ->whereNull('wms_pickinglist_detail.id') // Ambil yang belum masuk picking list
      // ->whereRaw('(tr_concept.invoice_no = "' . $request->input('do_or_shipment') . '" OR tr_concept.delivery_no = "' . $request->input('do_or_shipment') . '")');
      // ->whereRaw('(tr_concept.invoice_no like "%' . $request->input('do_or_shipment') . '%" OR tr_concept.delivery_no like "%' . $request->input('do_or_shipment') . '%")')
        ->groupBy('invoice_no', 'delivery_no', 'delivery_items')
      ;

      if (empty($request->input('do_or_shipment'))) {
        $query->whereRaw('1=2');
      }

      if ($request->input('filter_type') == 'shipment') {
        $query->where('tr_concept.invoice_no', 'like', '%' . $request->input('do_or_shipment') . '%');
      } else {
        $query->where('tr_concept.delivery_no', 'like', '%' . $request->input('do_or_shipment') . '%');
      }

      foreach (json_decode($request->input('selected_list'), true) as $key => $value) {
        $query->whereRaw('CONCAT(tr_concept.invoice_no, tr_concept.delivery_no, tr_concept.delivery_items) != ?', [$value]);
      }

    } else {
      // Cabang Ambil Dari Upload DO for Picking
      $query = ManualConcept::select(
        'wms_manual_concept.*',
        DB::raw('0 AS line_no'),
        DB::raw('MAX(wmcT.delivery_items) AS max_delivery_items')
      )
        ->leftjoin('wms_pickinglist_detail', function ($join) {
          $join->on('wms_pickinglist_detail.invoice_no', '=', 'wms_manual_concept.invoice_no');
          $join->on('wms_pickinglist_detail.delivery_no', '=', 'wms_manual_concept.delivery_no');
          $join->on('wms_pickinglist_detail.delivery_items', '=', 'wms_manual_concept.delivery_items');
        })
        ->leftjoin(DB::raw('wms_manual_concept AS wmcT'), function ($join) {
          $join->on('wmcT.invoice_no', '=', 'wms_manual_concept.invoice_no');
          $join->on('wmcT.delivery_no', '=', 'wms_manual_concept.delivery_no');
        })
        ->whereNull('wms_pickinglist_detail.id') // Ambil yang belum masuk picking list
        ->groupBy('invoice_no', 'delivery_no', 'delivery_items')
      // ->whereRaw('(invoice_no like "%' . $request->input('do_or_shipment') . '%" OR delivery_no like "%' . $request->input('do_or_shipment') . '%")')
      ;

      if ($request->input('filter_type') == 'shipment') {
        $query->where('wms_manual_concept.invoice_no', 'like', '%' . $request->input('do_or_shipment') . '%');
      } else {
        $query->where('wms_manual_concept.delivery_no', 'like', '%' . $request->input('do_or_shipment') . '%');
      }

      if (empty($request->input('do_or_shipment'))) {
        $query->whereRaw('1=2');
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
      $pickingListDetail['line_no']        = auth()->user()->cabang->hq ? $value['line_no'] : 0;
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

        // Dikurangi item terbooking, picking list yang belum send manifest;
        $holdPickingDetail = PickinglistDetail::select(
          'wms_pickinglist_detail.ean_code',
          DB::raw('SUM(wms_pickinglist_detail.quantity) AS total_qty'),
          'wms_lmb_header.send_manifest'
        )
          ->leftjoin('wms_pickinglist_header', 'wms_pickinglist_header.id', '=', 'wms_pickinglist_detail.header_id')
          ->leftjoin('wms_lmb_header', 'wms_pickinglist_header.driver_register_id', '=', 'wms_lmb_header.driver_register_id')
          ->whereNull('wms_lmb_header.send_manifest')
          ->where('wms_pickinglist_detail.ean_code', $pickingListDetail['ean_code'])
          ->where('wms_pickinglist_header.storage_id', $pickinglistHeader->storage_id)
          ->groupBy('wms_pickinglist_detail.ean_code')
          ->first();

        $qty_hold = !empty($holdPickingDetail->total_qty) ? $holdPickingDetail->total_qty : 0;

        $inventoryStorage->quantity_total -= $qty_hold;
        $rs_inventory_storage[$pickingListDetail['ean_code']] = $inventoryStorage;
      }

      $rs_inventory_storage[$pickingListDetail['ean_code']]->quantity_total -= $pickingListDetail['quantity'];

      if ($rs_inventory_storage[$pickingListDetail['ean_code']]->quantity_total < 0) {
        return sendError('Quantity of model ' . $value['model'] . ' is defisit !');
      }

      $rs_pickinglistDetail[] = $pickingListDetail;
    }

    try {
      DB::beginTransaction();
      // ADD CONCEPT FLOW DETAIL
      $conceptFlowHeader = ConceptFlowHeader::where('driver_register_id', $pickinglistHeader->driver_register_id)->first();

      if (!empty($conceptFlowHeader->id)) {
        foreach ($rs_pickinglistDetail as $key => $value) {
          $conceptFlowDetail = new ConceptFlowDetail;

          $conceptFlowDetail->id_header      = $conceptFlowHeader->id;
          $conceptFlowDetail->invoice_no     = $value['invoice_no'];
          $conceptFlowDetail->line_no        = $value['line_no'];
          $conceptFlowDetail->quantity       = $value['quantity'];
          $conceptFlowDetail->cbm_max        = $value['cbm'];
          $conceptFlowDetail->concept_type   = "STANDAR";
          $conceptFlowDetail->delivery_no    = $value['delivery_no'];
          $conceptFlowDetail->delivery_items = $value['delivery_items'];

          $conceptFlowDetail->save();

        }
      }

      PickinglistDetail::insert($rs_pickinglistDetail);
      DB::commit();

      return sendSuccess('Items Submited to picking list.', $rs_pickinglistDetail);
    } catch (Exception $e) {
      DB::rollBack();
    }

  }

  public function destroy($id)
  {
    try {
      DB::beginTransaction();
      $pickingHeader = PickinglistHeader::findOrFail($id);
      PickinglistDetail::where('header_id', $id)->delete();
      $conceptFlowHeader = ConceptFlowHeader::where('driver_register_id', $pickingHeader->driver_register_id)->first();

      if (!empty($conceptFlowHeader)) {
        ConceptTruckFlow::where('concept_flow_header', $conceptFlowHeader->id)->delete();
        ConceptFlowDetail::where('id_header', $conceptFlowHeader->id)->delete();

        $conceptFlowHeader->delete();
      }

      $pickingHeader->delete();

      DB::commit();
      return sendSuccess('Picking List Deleted', $pickingHeader);

    } catch (Exception $e) {
      DB::rollBack();
    }
  }

  public function destroyDetail($id)
  {
    try {
      DB::beginTransaction();
      $pickingDetail = PickinglistDetail::findOrFail($id);

      ConceptFlowDetail::where('invoice_no', $pickingDetail->invoice_no)
        ->where('line_no', $pickingDetail->line_no)
        ->where('delivery_no', $pickingDetail->delivery_no)
        ->where('delivery_items', $pickingDetail->delivery_items)
        ->delete();

      $pickingDetail->delete();

      DB::commit();
      return sendSuccess('Item Deleted', $pickingDetail);
    } catch (Exception $e) {
      DB::rollback();
    }
  }

  public function destroySelectedDetails(Request $request)
  {
    $data_picking_list_details = json_decode($request->input('data_picking_list_details'), true);

    try {
      DB::beginTransaction();

      foreach ($data_picking_list_details as $key => $value) {
        $pickingDetail = PickinglistDetail::findOrFail($value['id']);

        ConceptFlowDetail::where('invoice_no', $pickingDetail->invoice_no)
          ->where('line_no', $pickingDetail->line_no)
          ->where('delivery_no', $pickingDetail->delivery_no)
          ->where('delivery_items', $pickingDetail->delivery_items)
          ->delete();

        $pickingDetail->delete();
      }

      DB::commit();
      return sendSuccess('Item Deleted', $data_picking_list_details);
    } catch (Exception $e) {
      DB::rollback();
    }
  }

  public function edit($id)
  {
    $data['pickinglistHeader'] = PickinglistHeader::findOrFail($id);
    $data['rsPickinglist']     = PickinglistHeader::where('driver_register_id', $data['pickinglistHeader']->driver_register_id)->get();

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
    $data['details']           = $data['pickinglistHeader']
      ->details()
      ->select(
        'id',
        'header_id',
        'ean_code',
        'model',
        DB::raw('SUM(quantity) AS quantity'),
        DB::raw('SUM(cbm) AS cbm')
      )
      ->groupBy('ean_code')
      ->orderBy('model')
      ->get()
    ;
    $data['excel'] = '';
    $view_print    = view('web.picking.picking-list._print', $data);

    if ($request->input('filetype') == 'xls') {
      $data['excel'] = 1;
      // print_r($data['details']->toArray());
      // return;
      $view_print = view('web.picking.picking-list._excel', $data);

    }
    $title = 'picking_list';

    if ($request->input('filetype') == 'html') {

      // request HTML View
      return $view_print;

    } elseif ($request->input('filetype') == 'xls') {

      // return $view_print;
      // Request FILE EXCEL
      $reader      = new \PhpOffice\PhpSpreadsheet\Reader\Html();
      $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

      $spreadsheet = $reader->loadFromString($view_print, $spreadsheet);

      $spreadsheet->getActiveSheet()->getPageMargins()->setTop(0.2);
      $spreadsheet->getActiveSheet()->getPageMargins()->setRight(0.2);
      $spreadsheet->getActiveSheet()->getPageMargins()->setLeft(0.2);
      $spreadsheet->getActiveSheet()->getPageMargins()->setBottom(0.2);
      $spreadsheet->getActiveSheet()->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
      // Set warna background putih
      $spreadsheet->getDefaultStyle()->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('ffffff');
      // Set Font
      $spreadsheet->getDefaultStyle()->getFont()->setName('courier New');

      // Atur lebar kolom
      $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(16);
      $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(10);
      $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(5);
      $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(16);
      $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(16);
      $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(10);
      $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(10);

      $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment; filename="' . $title . '.xls"');

      $writer->save("php://output");

    } else if ($request->input('filetype') == 'pdf') {

      // REQUEST PDF
      $mpdf = new \Mpdf\Mpdf(['tempDir' => '/tmp',
        'margin_left'                     => 7,
        'margin_right'                    => 12,
        'margin_top'                      => 5,
        'margin_bottom'                   => 5,
        'format'                          => 'A4',
      ]);
      $mpdf->shrink_tables_to_fit = 1;
      $mpdf->WriteHTML($view_print);

      $mpdf->Output($title . '.pdf', "D");
      // $mpdf->Output();

    } else {
      // Parameter filetype tidak valid / tidak ditemukan return 404
      return redirect(404);
    }
  }

  public function exportConcept(Request $request, $picking_id)
  {
    $data['pickinglistHeader'] = PickinglistHeader::findOrFail($picking_id);
    $data['details']           = $data['pickinglistHeader']->getConceptData();

    $data['excel'] = '';
    $view_print    = view('web.picking.picking-list._print_concept', $data);

    // if ($request->input('filetype') == 'xls') {
    //   $data['excel'] = 1;
    //   // print_r($data['details']->toArray());
    //   // return;
    //   $view_print = view('web.picking.picking-list._excel_concept', $data);

    // }
    $title = 'Pickinglist Concept';

    if ($request->input('filetype') == 'html') {

      // request HTML View
      return $view_print;

    } elseif ($request->input('filetype') == 'xls') {

      // return $view_print;
      // Request FILE EXCEL
      $reader      = new \PhpOffice\PhpSpreadsheet\Reader\Html();
      $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

      $spreadsheet = $reader->loadFromString($view_print, $spreadsheet);

      $spreadsheet->getActiveSheet()->getPageMargins()->setTop(0.2);
      $spreadsheet->getActiveSheet()->getPageMargins()->setRight(0.2);
      $spreadsheet->getActiveSheet()->getPageMargins()->setLeft(0.2);
      $spreadsheet->getActiveSheet()->getPageMargins()->setBottom(0.2);
      $spreadsheet->getActiveSheet()->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
      // Set warna background putih
      $spreadsheet->getDefaultStyle()->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('ffffff');
      // Set Font
      $spreadsheet->getDefaultStyle()->getFont()->setName('courier New');

      // Atur lebar kolom
      $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(16);
      $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(10);
      $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(5);
      $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(16);
      $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(16);
      $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(10);
      $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(10);

      $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment; filename="' . $title . '.xls"');

      $writer->save("php://output");

    } else if ($request->input('filetype') == 'pdf') {

      // REQUEST PDF
      $mpdf = new \Mpdf\Mpdf(['tempDir' => '/tmp',
        'margin_left'                     => 7,
        'margin_right'                    => 12,
        'margin_top'                      => 5,
        'margin_bottom'                   => 50,
        'format'                          => 'A4',
      ]);
      $mpdf->shrink_tables_to_fit = 1;
      $mpdf->WriteHTML($view_print);

      $mpdf->Output($title . '.pdf', "D");
      // $mpdf->Output();
      // $mpdf->Output();

    } else {
      // Parameter filetype tidak valid / tidak ditemukan return 404
      return redirect(404);
    }
  }

}
