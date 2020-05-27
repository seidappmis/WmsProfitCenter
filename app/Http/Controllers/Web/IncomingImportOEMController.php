<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\IncomingManualDetail;
use App\Models\IncomingManualHeader;
use App\Models\IncomingManualOtherSN;
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
          $action .= ' ' . get_button_delete();
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

  public function storeDetail(Request $request)
  {
    $request->validate([
      'arrival_no_header' => 'required',
    ]);

    $incomingManualDetail                    = new IncomingManualDetail;
    $incomingManualDetail->arrival_no_header = $request->input('arrival_no_header');
    $incomingManualDetail->model             = $request->input('model');
    $incomingManualDetail->description       = $request->input('description');
    $incomingManualDetail->qty               = $request->input('qty');
    $incomingManualDetail->cbm               = $request->input('cbm');
    $incomingManualDetail->total_cbm         = $request->input('total_cbm');
    $incomingManualDetail->no_gr_sap         = $request->input('no_gr_sap');
    $incomingManualDetail->kode_cabang       = auth()->user()->cabang->kode_cabang;
    $incomingManualDetail->storage_id        = $request->input('storage_id');

    try {
      DB::beginTransaction();

      $incomingManualDetail->save();

      // cek file csv serial number
      // bila tidak kosong ambil isinya
      if ($file_serial_number = $request->file('file-serial-number')) {
        // Baca file csv
        $file = fopen($file_serial_number, "r");

        $serial_numbers = [];

        $date = date('Y-m-d H:i:s');

        // Loop data sampai baris terakhir
        while (!feof($file)) {
          $row = fgetcsv($file);

          $serialnumber['manual_id']    = $incomingManualDetail->id;
          $serialnumber['serialnumber'] = $row[0];
          $serialnumber['created_at']   = $date;
          $serialnumber['created_by']   = auth()->user()->id;

          $serial_numbers[] = $serialnumber;
        }

        fclose($file);

        if (count($serial_numbers) != $request->input('qty')) {
          $result['status']  = false;
          $result['message'] = 'Error upload Serialnumber, Total Serialnumber different with Quantity !';
          return $result;
        }

        IncomingManualOtherSN::insert($serial_numbers);
      }

      DB::commit();

      return $incomingManualDetail;

    } catch (Exception $e) {
      DB::rollBack();
    }
  }

  public function destroy($id)
  {
    return IncomingManualHeader::destroy($id);
  }
}
