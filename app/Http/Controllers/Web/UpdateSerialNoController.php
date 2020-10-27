<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\LMBDetail;
use App\Models\MasterModel;
use App\Models\PickinglistDetail;
use DB;
use Illuminate\Http\Request;

class UpdateSerialNoController extends Controller
{
  public function index(Request $request)
  {
    return view('web.picking.update-serial-no.index');
  }

  public function upload(Request $request)
  {
    $request->validate([
      'file_scan' => 'required',
    ]);

    $file = fopen($request->file('file_scan'), "r");

    $serial_numbers = [];

    $rs_models               = [];
    $rs_picking_list_details = [];
    $rs_lmb_details          = [];

    try {
      DB::beginTransaction();
      while (!feof($file)) {
        $row = fgetcsv($file);

        // Validasi Data Per Baris
        if (!empty($row[0])) {
          $serial_number = [
            'picking_id'    => $row[0],
            'ean_code'      => $row[1],
            'serial_number' => $row[2],
            'created_at'    => $row[3],
          ];

          if (empty($rs_models[$serial_number['ean_code']])) {
            $model = MasterModel::where('ean_code', $serial_number['ean_code'])->first();
            if (empty($model)) {
              $result['status']  = false;
              $result['message'] = 'Model ' . $serial_number['ean_code'] . ' not found in master model !';
              return $result;
            }
            $rs_models[$serial_number['ean_code']] = $model;
          }

          if (empty($rs_picking_list_details[$serial_number['picking_id'] . $serial_number['ean_code']])) {
            $picking_detail = PickinglistDetail::select(
              '*',
              DB::raw('SUM(quantity) AS total_quantity')
            )
              ->where('header_id', $serial_number['picking_id'])
              ->where('ean_code', $serial_number['ean_code'])
              ->groupBy(
                'header_id', 'invoice_no', 'delivery_no'
              )
              ->first();

            if (empty($picking_detail)) {
              return sendError('EAN ' . $serial_number['ean_code'] . ' not found in picking_list !');
            }

            $rs_picking_list_details[$serial_number['picking_id'] . $serial_number['ean_code']] = $picking_detail;
          }

          if (empty($rs_lmb_details[$serial_number['picking_id'] . $serial_number['ean_code']])) {
            $lmb_details = LMBDetail::where('picking_id', $serial_number['picking_id'])
              ->where('ean_code', $serial_number['ean_code'])
              ->orderBy('serial_number')
              ->get();

            $rs_lmb_details[$serial_number['picking_id'] . $serial_number['ean_code']] = $lmb_details->toArray();
          }

          $lmb_detail = array_pop($rs_lmb_details[$serial_number['picking_id'] . $serial_number['ean_code']]);

          LMBDetail::where('serial_number', $lmb_detail['serial_number'])
            ->where('delivery_no', $lmb_detail['delivery_no'])
            ->where('model', $lmb_detail['model'])
            ->update([
              'serial_number' => $serial_number['serial_number'],
              'updated_by'    => auth()->user()->id,
              'updated_at'    => date('Y-m-d H:i:s'),
            ])
          ;

          if (empty($rs_picking_list_details[$serial_number['picking_id'] . $serial_number['ean_code']]->scan_quantity)) {
            $rs_picking_list_details[$serial_number['picking_id'] . $serial_number['ean_code']]->scan_quantity = 1;
          } else {
            $rs_picking_list_details[$serial_number['picking_id'] . $serial_number['ean_code']]->scan_quantity += 1;
          }

          if ($rs_picking_list_details[$serial_number['picking_id'] . $serial_number['ean_code']]->scan_quantity > $rs_picking_list_details[$serial_number['picking_id'] . $serial_number['ean_code']]->total_quantity) {
            DB::rollBack();
            return sendError('Quantity Upload for ean code ' . $lmb_detail['ean_code'] . ' more than quantity in pickinglist.');
          }

          $serial_numbers[] = $serial_number;
        }
      }
      DB::commit();
      return sendSuccess('Data Upload success! Serial No Updated.', $serial_numbers);
    } catch (\Illuminate\Database\QueryException $ex) {
      DB::rollBack();
      return sendError('Serial Number exists!');
    }

  }
}
