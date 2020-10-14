<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\LMBDetail;
use App\Models\MasterModel;
use App\Models\PickinglistDetail;
use Illuminate\Http\Request;
use DB;

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
    $delivery_exceptions     = [];

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
            $result['status']  = false;
            $result['message'] = 'Model ' . $serial_number['ean_code'] . ' not found in master model !';
            return $result;
          }
          $rs_models[$serial_number['ean_code']] = $model;
        }

        if (empty($rs_picking_list_details[$serial_number['ean_code']])) {
          $picking_detail = PickinglistDetail::select(
            'wms_pickinglist_detail.delivery_no',
            'wms_pickinglist_detail.invoice_no',
            'wms_pickinglist_detail.kode_customer',
            'wms_pickinglist_detail.code_sales',
            'wms_pickinglist_header.city_code',
            'wms_pickinglist_header.city_name',
            'wms_pickinglist_header.driver_register_id',
            // 'wms_pickinglist_detail.quantity',
            'wms_pickinglist_detail.cbm',
            DB::raw('(wms_pickinglist_detail.quantity - COUNT(wms_lmb_detail.serial_number)) AS quantity ')
          )
            ->leftjoin('wms_pickinglist_header', 'wms_pickinglist_header.id', '=', 'wms_pickinglist_detail.header_id')
            ->leftjoin('wms_lmb_detail', function ($join) {
              $join->on('wms_lmb_detail.picking_id', '=', 'wms_pickinglist_detail.header_id');
              $join->on('wms_lmb_detail.delivery_no', '=', 'wms_pickinglist_detail.delivery_no');
              $join->on('wms_lmb_detail.invoice_no', '=', 'wms_pickinglist_detail.invoice_no');
              $join->on('wms_lmb_detail.ean_code', '=', 'wms_pickinglist_detail.ean_code');
            })
            ->groupBy(
              'wms_pickinglist_detail.header_id',
              'wms_pickinglist_detail.invoice_no',
              'wms_pickinglist_detail.delivery_no',
              'wms_pickinglist_detail.delivery_items',
              'wms_pickinglist_detail.ean_code'
            )
            ->where('wms_pickinglist_detail.ean_code', $serial_number['ean_code'])
            ->where('wms_pickinglist_header.picking_no', $serial_number['picking_id'])
            ->orderBy('quantity', 'desc')
          ;

          if (!empty($delivery_exceptions[$serial_number['ean_code']])) {
            $picking_detail->whereNotIn('wms_pickinglist_detail.delivery_no', $delivery_exceptions[$serial_number['ean_code']]);
          }
          $picking_detail = $picking_detail->first();

          if (!empty($delivery_exceptions[$serial_number['ean_code']])) {
            $scan_summaries[$serial_number['ean_code']]['quantity_picking']  += $picking_detail->quantity;
            $scan_summaries[$serial_number['ean_code']]['quantity_existing'] += $picking_detail->quantity;
          }

          if (empty($picking_detail) || $picking_detail->quantity == 0) {
            return sendError('EAN ' . $serial_number['ean_code'] . ' not found in picking_list !');
          }

          $rs_picking_list_details[$serial_number['ean_code']] = $picking_detail;

        }

        $serial_number['model']              = $rs_models[$serial_number['ean_code']]->model_name;
        $serial_number['delivery_no']        = $rs_picking_list_details[$serial_number['ean_code']]->delivery_no;
        $serial_number['invoice_no']         = $rs_picking_list_details[$serial_number['ean_code']]->invoice_no;
        $serial_number['kode_customer']      = $rs_picking_list_details[$serial_number['ean_code']]->kode_customer;
        $serial_number['code_sales']         = $rs_picking_list_details[$serial_number['ean_code']]->code_sales;
        $serial_number['city_code']          = $rs_picking_list_details[$serial_number['ean_code']]->city_code;
        $serial_number['city_name']          = $rs_picking_list_details[$serial_number['ean_code']]->city_name;
        $serial_number['driver_register_id'] = $rs_picking_list_details[$serial_number['ean_code']]->driver_register_id;
        $serial_number['created_by']         = auth()->user()->id;

        $serial_number['cbm_unit'] = $rs_picking_list_details[$serial_number['ean_code']]->cbm / $rs_picking_list_details[$serial_number['ean_code']]->quantity;

        if (empty($scan_summaries[$serial_number['ean_code']])) {
          $scan_summaries[$serial_number['ean_code']] = [
            'model'             => $rs_models[$serial_number['ean_code']]->model_name,
            'quantity_scan'     => 0,
            'quantity_picking'  => $rs_picking_list_details[$serial_number['ean_code']]->quantity,
            'quantity_existing' => $rs_picking_list_details[$serial_number['ean_code']]->quantity,
          ];
        }

        if ($scan_summaries[$serial_number['ean_code']]['quantity_picking'] >= $scan_summaries[$serial_number['ean_code']]['quantity_scan']) {
          $scan_summaries[$serial_number['ean_code']]['quantity_scan'] += 1;
          $scan_summaries[$serial_number['ean_code']]['quantity_existing'] -= 1;

          if ($scan_summaries[$serial_number['ean_code']]['quantity_existing'] <= 0) {
            $delivery_exceptions[$serial_number['ean_code']][] = $rs_picking_list_details[$serial_number['ean_code']]->delivery_no;
            unset($rs_picking_list_details[$serial_number['ean_code']]);
          }
        } else {
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
