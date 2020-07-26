<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\IncomingManualDetail;
use App\Models\IncomingManualOtherSN;
use DB;
use Illuminate\Http\Request;

class IncomingImportOEMDetailController extends Controller
{
  public function store(Request $request)
  {
    $request->validate([
      'arrival_no_header' => 'required',
    ]);

    if (!empty($request->input('id'))) {
      $incomingManualDetail = IncomingManualDetail::findOrFail($request->input('id'));
    } else {
      $incomingManualDetail                    = new IncomingManualDetail;
    }

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
          return sendError('Error upload Serialnumber, Total Serialnumber different with Quantity !');
        }

        IncomingManualOtherSN::insert($serial_numbers);
      }

      DB::commit();

      $message = !empty($request->input('id')) ? 'Data Update Successfully!' : 'Data Created Successfully!';

      return sendSuccess($message, $incomingManualDetail);

    } catch (Exception $e) {
      DB::rollBack();
    }
  }

  public function destroy($incoming_manual_id, $detail_id)
  {
    try {
      DB::beginTransaction();

      $incomingManualDetail = IncomingManualDetail::findOrFail($detail_id);
      $incomingManualDetail->serial_numbers()->delete();
      $incomingManualDetail->delete();

      DB::commit();

      return true;
    } catch (Exception $e) {
      DB::rollBack();

      return false;
    }
  }

}
