<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\IncomingManualHeader;
use DataTables;
use DB;
use Illuminate\Http\Request;

class IncomingImportOEMController extends Controller
{
  public function index(Request $request)
  {
    if ($request->ajax()) {
      $query = IncomingManualHeader::where('area', $request->input('area'))
        ->get();

      $datatables = DataTables::of($query)
        ->addIndexColumn() //DT_RowIndex (Penomoran)
        ->addColumn('status', function ($data) {
          return ($data->details->count() == 0) ? 'Items not found' : 'Total Items ' . $data->details->count();
        })
        ->addColumn('action', function ($data) {
          $action = '';
          $action .= ' ' . get_button_view(url('incoming-import-oem/' . $data->arrival_no));
          if (!$data->submit) {
            $action .= ' ' . get_button_edit('#', 'Submit to Inventory', 'btn-submit-to-inventory');
            $action .= ' ' . get_button_delete();
          }
          return $action;
        });

      return $datatables->make(true);
    }
    return view('web.incoming.incoming-import-oem.index');
  }

  public function create()
  {
    return view('web.incoming.incoming-import-oem.create');
  }

  public function submitToInventory($id)
  {
    $incomingManualHeader = IncomingManualHeader::findOrFail($id);

    $incomingManualHeader->submit      = 1;
    $incomingManualHeader->submit_date = date('Y-m-d H:i:s');
    $incomingManualHeader->submit_by   = auth()->user()->id;

    $incomingManualHeader->save();

    return $incomingManualHeader;
  }

  public function show(Request $request, $id)
  {
    $data['incomingManualHeader'] = IncomingManualHeader::findOrFail($id);

    if ($request->ajax()) {
      $query = $data['incomingManualHeader']
        ->details()
        ->get();

      $datatables = DataTables::of($query)
        ->addIndexColumn() //DT_RowIndex (Penomoran)
        ->addColumn('storage_location', function ($data) {
          return $data->storage->sto_type_desc;
        })
        ->addColumn('serial_numbers', function ($data) {
          return $data->storage->serial_numbers;
        })
        ->addColumn('action', function ($data) {
          $action = '';
          $action .= ' ' . get_button_edit(url('incoming-import-oem/' . $data->id));
          $action .= ' ' . get_button_delete();
          return $action;
        });

      return $datatables->make(true);
    }

    return view('web.incoming.incoming-import-oem.view', $data);
  }

  public function store(Request $request)
  {
    $request->validate([
      'po' => 'required',
    ]);

    $incomingManualHeader = new IncomingManualHeader;

    // Arrival_No => TIPE-WAREHOUSE-TANGGAL-Urutan
    $arrival_no = $request->input('inc_type') . '-WHKRW-' . date('ymd') . '-';

    $prefix_length = strlen($arrival_no);
    $max_no        = DB::select('SELECT MAX(SUBSTR(arrival_no, ?)) AS max_no FROM log_incoming_manual_header WHERE SUBSTR(arrival_no,1,?) = ? ', [$prefix_length + 2, $prefix_length, $arrival_no])[0]->max_no;
    $max_no        = str_pad($max_no + 1, 3, 0, STR_PAD_LEFT);

    $incomingManualHeader->arrival_no          = $arrival_no . $max_no;
    $incomingManualHeader->po                  = $request->input('po');
    $incomingManualHeader->invoice_no          = $request->input('invoice_no');
    $incomingManualHeader->no_gr_sap           = $request->input('no_gr_sap');
    $incomingManualHeader->document_date       = date('Y-m-d', strtotime($request->input('document_date')));
    $incomingManualHeader->vendor_name         = $request->input('vendor_name');
    $incomingManualHeader->actual_arrival_date = date('Y-m-d', strtotime($request->input('actual_arrival_date')));
    $incomingManualHeader->expedition_name     = $request->input('expedition_name');
    $incomingManualHeader->container_no        = $request->input('container_no');
    $incomingManualHeader->area                = $request->input('area');
    $incomingManualHeader->inc_type            = $request->input('inc_type');
    $incomingManualHeader->kode_cabang         = auth()->user()->cabang->kode_cabang;
    $incomingManualHeader->submit              = 0;
    // $incomingManualHeader->submit_date         = $request->input('submit_date');
    // $incomingManualHeader->submit_by           = $request->input('submit_by');

    $incomingManualHeader->save();

    return $incomingManualHeader;

  }

  public function update(Request $request, $id)
  {
    $request->validate([
      'po' => 'required',
    ]);

    $incomingManualHeader = IncomingManualHeader::find($id);

    $incomingManualHeader->po                  = $request->input('po');
    $incomingManualHeader->invoice_no          = $request->input('invoice_no');
    $incomingManualHeader->no_gr_sap           = $request->input('no_gr_sap');
    $incomingManualHeader->document_date       = date('Y-m-d', strtotime($request->input('document_date')));
    $incomingManualHeader->vendor_name         = $request->input('vendor_name');
    $incomingManualHeader->actual_arrival_date = date('Y-m-d', strtotime($request->input('actual_arrival_date')));
    $incomingManualHeader->expedition_name     = $request->input('expedition_name');
    $incomingManualHeader->container_no        = $request->input('container_no');
    $incomingManualHeader->area                = $request->input('area');
    $incomingManualHeader->inc_type            = $request->input('inc_type');
    $incomingManualHeader->kode_cabang         = auth()->user()->cabang->kode_cabang;
    $incomingManualHeader->submit              = 0;
    // $incomingManualHeader->submit_date         = $request->input('submit_date');
    // $incomingManualHeader->submit_by           = $request->input('submit_by');

    $incomingManualHeader->save();

    return $incomingManualHeader;

  }

  public function destroy($id)
  {
    try {
      DB::beginTransaction();

      $incomingManualHeader = IncomingManualHeader::findOrFail($id);
      $incomingManualHeader->serial_numbers()->delete(); // has Many Trough details
      $incomingManualHeader->details()->delete();
      $incomingManualHeader->delete();

      DB::commit();

      return true;
    } catch (Exception $e) {
      DB::rollBack();

      return false;
    }
    return IncomingManualHeader::destroy($id);
  }
}
