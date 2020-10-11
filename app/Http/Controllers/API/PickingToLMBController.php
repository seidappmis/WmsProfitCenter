<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\LMBDetail;
use App\Models\MasterModel;
use App\Models\PickinglistDetail;
use Illuminate\Http\Request;

class PickingToLMBController extends Controller
{
  public function storeScan(Request $request)
  {
    // return sendSuccess('Data return.', $request->input('data'));
    if (empty($request->input('data'))) {
      return sendError('No Serial Number Data.');
    }

    $serial_numbers                 = [];
    $scan_summaries                 = [];
    $model_not_exist_in_pickinglist = [];

    $rs_models               = [];
    $rs_picking_list_details = [];

    foreach (json_decode($request->input('data'), true) as $key => $postSerialNumber) {

      // return $postSerialNumber;

      if (!empty($postSerialNumber['pickingNo'])) {
        $serial_number = [
          'picking_id'    => $postSerialNumber['pickingNo'],
          'ean_code'      => $postSerialNumber['eanCode'],
          'serial_number' => $postSerialNumber['serialNumber'],
          'created_at'    => $postSerialNumber['inputDate'],
        ];

        // return $serial_number;

        if (empty($rs_models[$serial_number['ean_code']])) {
          $model = MasterModel::where('ean_code', $serial_number['ean_code'])->first();
          if (empty($model)) {
            return sendError('Model ' . $serial_number['ean_code'] . ' not found in master model !');
          }
          $rs_models[$serial_number['ean_code']] = $model;
        }

        if (empty($rs_picking_list_details[$serial_number['ean_code']])) {
          $picking_detail = PickinglistDetail::select('wms_pickinglist_detail.*')
            ->leftjoin('wms_pickinglist_header', 'wms_pickinglist_header.id', '=', 'wms_pickinglist_detail.header_id')
            ->where('ean_code', $serial_number['ean_code'])
            ->where('picking_no', $serial_number['picking_id'])
            ->first();

          if (empty($picking_detail)) {
            return sendError('EAN ' . $serial_number['ean_code'] . ' not found in picking_list !');
          }
          $rs_picking_list_details[$serial_number['ean_code']] = $picking_detail;
        }

        $serial_number['model']              = $rs_models[$serial_number['ean_code']]->model_name;
        $serial_number['delivery_no']        = $rs_picking_list_details[$serial_number['ean_code']]->delivery_no;
        $serial_number['invoice_no']         = $rs_picking_list_details[$serial_number['ean_code']]->invoice_no;
        $serial_number['kode_customer']      = $rs_picking_list_details[$serial_number['ean_code']]->kode_customer;
        $serial_number['code_sales']         = $rs_picking_list_details[$serial_number['ean_code']]->code_sales;
        $serial_number['city_code']          = $rs_picking_list_details[$serial_number['ean_code']]->header->city_code;
        $serial_number['city_name']          = $rs_picking_list_details[$serial_number['ean_code']]->header->city_name;
        $serial_number['driver_register_id'] = $rs_picking_list_details[$serial_number['ean_code']]->header->driver_register_id;

        $serial_number['cbm_unit'] = $rs_picking_list_details[$serial_number['ean_code']]->cbm / $rs_picking_list_details[$serial_number['ean_code']]->quantity;

        if (empty($scan_summaries[$serial_number['ean_code']])) {
          $scan_summaries[$serial_number['ean_code']] = [
            'model'             => $rs_models[$serial_number['ean_code']]->model_name,
            'quantity_scan'     => 0,
            'quantity_picking'  => $rs_picking_list_details[$serial_number['ean_code']]->quantity,
            'quantity_existing' => $rs_picking_list_details[$serial_number['ean_code']]->quantity,
          ];
        }

        if ($rs_picking_list_details[$serial_number['ean_code']]->quantity > $scan_summaries[$serial_number['ean_code']]['quantity_scan']) {
          $scan_summaries[$serial_number['ean_code']]['quantity_scan'] += 1;
          $scan_summaries[$serial_number['ean_code']]['quantity_existing'] -= 1;
        } else {
          // model ada di picking list tapi quantity melebihi quantity picking
          $model_not_exist_in_pickinglist[$serial_number['ean_code']]['picking_no'] = $serial_number['picking_id'];
          $model_not_exist_in_pickinglist[$serial_number['ean_code']]['model']      = $rs_models[$serial_number['ean_code']]->model_name;
          if (empty($model_not_exist_in_pickinglist[$serial_number['ean_code']]['total_sn'])) {
            $model_not_exist_in_pickinglist[$serial_number['ean_code']]['total_sn'] = 0;
          }
          $model_not_exist_in_pickinglist[$serial_number['ean_code']]['total_sn'] += 1;
        }

        $serial_numbers[] = $serial_number;
      }

    }

    // $result['serial_numbers']                 = $serial_numbers;
    // $result['scan_summaries']                 = $scan_summaries;
    // $result['model_not_exist_in_pickinglist'] = $model_not_exist_in_pickinglist;
    if (!empty($model_not_exist_in_pickinglist)) {
      return sendError('Model Not Exist in pickinglist.');
    }

    if (empty($serial_numbers)) {
      return sendError('No Serial Number Data.');
    }

    LMBDetail::insert($serial_numbers);

    return sendSuccess('Serial Number uploaded.', $serial_numbers);
  }

}
