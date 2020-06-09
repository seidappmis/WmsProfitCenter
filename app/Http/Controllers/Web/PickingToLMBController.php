<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\LMBDetail;
use App\Models\LMBHeader;
use App\Models\PickinglistHeader;
use DataTables;
use DB;
use Illuminate\Http\Request;

class PickingToLMBController extends Controller
{
  public function index(Request $request)
  {
    if ($request->ajax()) {
      $query = LMBHeader::all();

      $datatables = DataTables::of($query)
        ->addIndexColumn() //DT_RowIndex (Penomoran)
        ->addColumn('picking_no', function ($data) {
          return $data->picking->picking_no;
        })
        ->addColumn('action', function ($data) {
          $action = '';
          $action .= ' ' . get_button_view(url('picking-to-lmb/' . $data->driver_register_id), 'View Detail');
          if (!$data->send_manifest) {
            $action .= ' ' . get_button_delete('Cancel');
          }
          return $action;
        })
        ->rawColumns(['do_status', 'action']);

      return $datatables->make(true);
    }
    return view('web.picking.picking-to-lmb.index');
  }

  public function show($id)
  {
    $data['lmbHeader'] = LMBHeader::findOrFail($id);

    return view('web.picking.picking-to-lmb.view', $data);
  }

  public function store(Request $request)
  {
    $request->validate([
      'picking_no'   => 'required',
      'seal_no'      => 'required',
      'container_no' => 'required',
    ]);

    $picking = PickinglistHeader::where('picking_no', $request->input('picking_no'))->first();

    $lmbHeader                           = new LMBHeader;
    $lmbHeader->driver_register_id       = '2020-05-29 04:59:19';
    $lmbHeader->lmb_date                 = date('Y-m-d');
    $lmbHeader->do_reservation_no        = '';
    $lmbHeader->pdo                      = '';
    $lmbHeader->expedition_code          = $picking->expedition_code;
    $lmbHeader->expedition_name          = $picking->expedition_name;
    $lmbHeader->driver_id                = $picking->driver_id;
    $lmbHeader->driver_name              = $picking->driver_name;
    $lmbHeader->vehicle_number           = $picking->vehicle_number;
    $lmbHeader->destination_number       = $picking->destination_number;
    $lmbHeader->destination_name         = $picking->destination_name;
    $lmbHeader->kode_cabang              = $picking->kode_cabang;
    $lmbHeader->short_description_cabang = $picking->short_description_cabang;
    $lmbHeader->seal_no                  = $request->input('seal_no');
    $lmbHeader->container_no             = $request->input('container_no');
    $lmbHeader->send_manifest            = 0;
    // $lmbHeader->start_date               = '';
    // $lmbHeader->finish_date              = '';
    // $lmbHeader->finish_by                = '';

    $lmbHeader->save();

    return $lmbHeader;

  }

  public function sendManifest($id)
  {
    $lmbHeader = LMBHeader::findOrFail($id);

    $lmbHeader->send_manifest = 1;

    $lmbHeader->save();

    return $lmbHeader;
  }

  public function upload(Request $request)
  {
    $request->validate([
      'file_scan' => 'required',
    ]);

    $file = fopen($request->file('file_scan'), "r");

    $title          = true; // Untuk Penada Baris pertama adalah Judul
    $serial_numbers = [];
    $scan_summaries = [];

    $rs_key = [];

    while (!feof($file)) {
      $row = fgetcsv($file);
      if ($title) {
        $title = false;
        continue; // Skip baris judul
      }
      $serial_number = [
        'picking_id'    => $row[0],
        'ean_code'      => $row[1],
        'serial_number' => $row[2],
      ];

      // Validasi Data Per Baris
      if (!empty($serial_number['picking_id'])) {
        // kalau data ada isinya
        $serial_number['model']       = 'LC-24LE170I';
        $serial_number['delivery_no'] = 'LC-24LE170I';

        if (empty($scan_summaries[$serial_number['ean_code']])) {
          $scan_summaries[$serial_number['ean_code']] = [
            'model'             => 'XXX',
            'quantity_scan'     => 0,
            'quantity_picking'  => 0,
            'quantity_existing' => 0,
          ];
        }

        $scan_summaries[$serial_number['ean_code']]['quantity_scan'] += 1;

        $serial_numbers[] = $serial_number;
      }
      // Akhir validasi data per baris
    }

    $result['serial_numbers'] = $serial_numbers;
    $result['scan_summaries'] = $scan_summaries;

    return $result;
  }

  public function storeScan(Request $request)
  {
    $data_serial_numbers = json_decode($request->input('data_serial_numbers'), true);

    foreach ($data_serial_numbers as $key => $value) {
      $data_serial_numbers[$key] = $value;
    }

    LMBDetail::insert($data_serial_numbers);

    return true;
  }

  public function pickingListIndex(Request $request)
  {
    $query = PickinglistHeader::noLMBPickingList()->get();

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
        $action .= ' ' . get_button_edit(url('picking-to-lmb/picking-list/' . $data->id), 'Create');
        return $action;
      })
      ->rawColumns(['do_status', 'action']);

    return $datatables->make(true);
  }

  public function pickingListCreate(Request $request, $id)
  {
    $data['picking'] = PickinglistHeader::findOrFail($id);

    if ($request->ajax()) {
      $query = LMBDetail::where('picking_id', $id)
        ->get();

      $datatables = DataTables::of($query)
        ->addIndexColumn() //DT_RowIndex (Penomoran)
        ->addColumn('action', function ($data) {
          $action = '';
          $action .= ' ' . get_button_delete();
          return $action;
        })
      ;

      return $datatables->make(true);
    }

    return view('web.picking.picking-to-lmb.create', $data);
  }
}
