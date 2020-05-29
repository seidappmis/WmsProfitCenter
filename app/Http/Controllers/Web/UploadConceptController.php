<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Concept;
use App\Models\MasterDestination;
use App\Models\MasterExpedition;
use Illuminate\Http\Request;

class UploadConceptController extends Controller
{
  public function index()
  {
    return view('web.outgoing.upload-concept.index');
  }

  public function uploadCsv(Request $request)
  {
    $request->validate([
      'file_concept' => 'required',
      'area'         => 'required',
    ]);

    $file = fopen($request->file('file_concept'), "r");

    $title          = true; // Untuk Penada Baris pertama adalah Judul
    $concepts       = [];
    $rs_destination = [];
    $rs_expedition  = [];

    $rs_key = [];

    while (!feof($file)) {
      $row = fgetcsv($file);
      if ($title) {
        $title = false;
        continue; // Skip baris judul
      }
      $concept = [
        'invoice_no'        => $row[0],
        'line_no'           => $row[1],
        'output_date'       => $row[2],
        'output_time'       => $row[3],

        'destination_name'  => $row[4],
        // 'destination_number' => $row[4], // Cari dari database

        'vehicle_code_type' => $row[5],
        'car_no'            => $row[6],
        'cont_no'           => $row[7],
        'checkin_date'      => $row[8],
        'checkin_time'      => $row[9],

        'expedition_name'   => $row[10],
        // 'expedition_id'     => $row[10], // cari dari database

        'delivery_no'       => $row[11],
        'delivery_items'    => $row[12],
        'model'             => $row[13],
        'quantity'          => $row[14],
        'cbm'               => $row[15],
        'ship_to'           => $row[16],
        'sold_to'           => $row[17],
        'ship_to_city'      => $row[18],
        'ship_to_district'  => $row[19],
        'ship_to_street'    => $row[20],
        'sold_to_city'      => $row[21],
        'sold_to_district'  => $row[22],
        'sold_to_street'    => $row[23],
        'remarks'           => $row[24],
        'sold_to_code'      => $row[25],
        'ship_to_code'      => $row[26],
        'expedition_code'   => $row[27],

        'area'              => $request->input('area'),
        'code_sales'        => 'DS',
      ];

      // Validasi Data Per Baris
      if (!empty($concept['invoice_no'])) {
        // kalau data ada isinya
        $rs_key[$concept['line_no']] = $concept['invoice_no'];

        // find destination bila belum ada di rs_destination
        // cari di database, bila sudah ada tidak perlu cari di database
        if (empty($rs_destination[$concept['destination_name']])) {
          $destination = MasterDestination::where('description', $concept['destination_name'])->first();
          if (empty($destination)) {
            $result['status']  = false;
            $result['message'] = 'Destination not found in master destination !';
            return $result;
          }

          $rs_destination[$concept['destination_name']] = $destination->destination_number;
        }

        // cari expedition
        if (empty($rs_expedition[$concept['expedition_code']])) {
          $expedition = MasterExpedition::where('sap_vendor_code', $concept['expedition_code'])->first();
          if (empty($expedition)) {
            $result['status']  = false;
            $result['message'] = 'EXPEDITION CODE ' . $concept['expedition_code'] . ' not found in SAP Vendor Code : master expedition !';
            return $result;
          }

          $rs_expedition[$concept['expedition_code']] = $expedition->id;
        }

        $concept['destination_number'] = $rs_destination[$concept['destination_name']];
        $concept['expedition_id']      = $rs_expedition[$concept['expedition_code']];

        $concepts[] = $concept;
      }
      // Akhir validasi data per baris
    }

    // VALIDASI ISI DI DATABASE
    // Cek apa data pernah diupload;
    $cek_concept = new Concept;
    foreach ($rs_key as $line_no => $invoice_no) {
      $cek_concept->orWhereColumn([
        ['invoice_no', '=', $invoice_no],
        ['line_no', '=', $line_no],
      ]);
    }

    if ($cek_concept->get()->count() > 0) {
      // kalau ada data yang sudah diupload return
      $result['status']  = false;
      $result['message'] = 'Data Already Upload';
      return $result;
    }
    // AKHIR VALIDASI ISI DATABASE

    return $concepts;

  }

  public function store(Request $request)
  {
    $data_concept = json_decode($request->input('data_concept'), true);

    foreach ($data_concept as $key => $value) {
      unset($value['destination_name']);

      $data_concept[$key] = $value;
    }

    Concept::insert($data_concept);

    return true;
  }
}
