<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\LMBDetail;
use App\Models\MasterModel;
use App\Models\PickinglistDetail;
use DB;
use Illuminate\Http\Request;

class PickingToLMBController extends Controller
{
  public function storeScan(Request $request)
  {
    // return sendSuccess('Data return.', json_decode($request->input('data'), true));
    if (empty($request->input('data'))) {
      return sendError('No Serial Number Data.', $request->all());
    }

    $serial_numbers                 = [];
    $scan_summaries                 = [];
    $model_not_exist_in_pickinglist = [];

    $rs_models               = [];
    $rs_picking_list_details = [];
    $delivery_exceptions     = [];

    DB::statement('SET SESSION group_concat_max_len = 1000000');
    
    foreach (json_decode($request->input('data'), true) as $key => $postSerialNumber) {

      // return $postSerialNumber;

      if (!empty($postSerialNumber['pickingNo']) && !empty($postSerialNumber['serialNumber'])) {
        $serial_number = [
			'picking_id'		=> $postSerialNumber['pickingNo'],
			//'picking_detail_id'	=> $postSerialNumber['pickinglist_detail_id'],
			'ean_code'			=> $postSerialNumber['eanCode'],
			'serial_number'		=> $postSerialNumber['serialNumber'],
			'created_at'		=> $postSerialNumber['inputDate'],
			'created_by'		=> auth()->user()->id,
        ];

		if (key_exists('pickinglist_detail_id', $postSerialNumber)){
			$serial_number['picking_detail_id'] = $postSerialNumber['pickinglist_detail_id'];
		}

        if (empty($postSerialNumber['serialNumber'])) {
          return sendError('Serial Number empty.');
        }

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
            'wms_pickinglist_detail.id',
            // 'wms_pickinglist_detail.delivery_no',
            // 'wms_pickinglist_detail.invoice_no',
            // 'wms_pickinglist_detail.kode_customer',
            // 'wms_pickinglist_detail.code_sales',
            'wms_pickinglist_header.city_code',
            'wms_pickinglist_header.city_name',
            'wms_pickinglist_header.driver_register_id',
            'wms_pickinglist_detail.ean_code',
            // 'wms_pickinglist_detail.quantity',
            // 'wms_pickinglist_detail.cbm',
            // DB::raw('GROUP_CONCAT(wms_pickinglist_detail.delivery_items SEPARATOR ",") as rs_delivery_items'),
            // DB::raw('GROUP_CONCAT(wms_pickinglist_detail.quantity SEPARATOR ",") as rs_quantity'),
            // DB::raw('(wms_pickinglist_detail.cbm / wms_pickinglist_detail.quantity) AS cbm_unit'),
            DB::raw('GROUP_CONCAT(DISTINCT CONCAT(wms_pickinglist_detail.invoice_no, ":", wms_pickinglist_detail.delivery_no, ":" , wms_pickinglist_detail.delivery_items, ":", wms_pickinglist_detail.quantity, ":", wms_pickinglist_detail.kode_customer, ":", wms_pickinglist_detail.code_sales, ":", (wms_pickinglist_detail.cbm / wms_pickinglist_detail.quantity)) ORDER BY wms_pickinglist_detail.invoice_no, wms_pickinglist_detail.delivery_no, wms_pickinglist_detail.delivery_items SEPARATOR ",") as rs_in_dn_di_qty_cc_cs_cbmu'),
            // DB::raw('COUNT(DISTINCT wms_lmb_detail.serial_number) AS quantity_lmb')
            DB::raw('0 AS quantity_lmb')
            // DB::raw('(SUM(wms_pickinglist_detail.quantity) - COUNT(wms_lmb_detail.serial_number)) AS quantity ')
          )
            ->leftjoin('wms_pickinglist_header', 'wms_pickinglist_header.id', '=', 'wms_pickinglist_detail.header_id')
            ->leftjoin('wms_lmb_detail', function ($join) {
              $join->on('wms_lmb_detail.picking_id', '=', 'wms_pickinglist_detail.header_id');
              // $join->on('wms_lmb_detail.delivery_no', '=', 'wms_pickinglist_detail.delivery_no');
              // $join->on('wms_lmb_detail.invoice_no', '=', 'wms_pickinglist_detail.invoice_no');
              $join->on('wms_lmb_detail.ean_code', '=', 'wms_pickinglist_detail.ean_code');
            })
            ->groupBy(
              'wms_pickinglist_detail.header_id',
              // 'wms_pickinglist_detail.invoice_no',
              // 'wms_pickinglist_detail.delivery_no',
              // 'wms_pickinglist_detail.delivery_items',
              'wms_pickinglist_detail.ean_code'
            )
            ->where(DB::raw('CAST(wms_pickinglist_detail.ean_code AS UNSIGNED)'), $serial_number['ean_code'])
            ->where('wms_pickinglist_header.picking_no', $serial_number['picking_id'])
            ->whereNull('wms_pickinglist_header.deleted_at')
            ->orderBy('quantity', 'desc');

          $picking_detail = $picking_detail->first();

          // return $picking_detail;
          $rs_invoice_no     = [];
          $rs_delivery_no    = [];
          $rs_delivery_items = [];
          $rs_quantity       = [];
          $rs_kode_customer  = [];
          $rs_code_sales     = [];
          $rs_cbm_unit       = [];
          $quantity          = 0;

          if (empty($picking_detail->rs_in_dn_di_qty_cc_cs_cbmu)) {
            $model_not_exist_in_pickinglist[$serial_number['ean_code']]['picking_no'] = $serial_number['picking_id'];
            $model_not_exist_in_pickinglist[$serial_number['ean_code']]['model']      = $rs_models[$serial_number['ean_code']]->model_name;
            if (empty($model_not_exist_in_pickinglist[$serial_number['ean_code']]['total_sn'])) {
              $model_not_exist_in_pickinglist[$serial_number['ean_code']]['total_sn'] = 0;
            }
            $model_not_exist_in_pickinglist[$serial_number['ean_code']]['total_sn'] += 1;
            continue;
          }

          foreach (explode(',', $picking_detail->rs_in_dn_di_qty_cc_cs_cbmu) as $key => $value) {
            $tempDQ = explode(':', $value);
            if ($picking_detail->quantity_lmb <= $tempDQ[3]) {
              $tempDQ[3] -= $picking_detail->quantity_lmb;
              $picking_detail->quantity_lmb = 0;

              if ($tempDQ[3] > 0) {
                $rs_invoice_no[]     = $tempDQ[0];
                $rs_delivery_no[]    = $tempDQ[1];
                $rs_delivery_items[] = $tempDQ[2];
                $rs_quantity[]       = $tempDQ[3];
                $rs_kode_customer[]  = $tempDQ[4];
                $rs_code_sales[]     = $tempDQ[5];
                $rs_cbm_unit[]       = $tempDQ[6];
                $quantity += $tempDQ[3];
              }
            } else {
              $picking_detail->quantity_lmb -= $tempDQ[3];
            }
          }

          // return $rs_invoice_no;

          $picking_detail->quantity = $quantity - $picking_detail->quantity_lmb;

          if (empty($picking_detail)) {
            return sendError('EAN ' . $serial_number['ean_code'] . ' not found in picking_list !');
          } elseif ($picking_detail->quantity == 0) {
            return sendError('Picking list or EAN ' . $serial_number['ean_code'] . ' already uploaded !');
          }

          // Cek apa EAN CODE ada karakter enter nya
          if ($serial_number['ean_code'] != $picking_detail->ean_code) {
            PickinglistDetail::where('id', $picking_detail->id)
              ->update(['ean_code' => $serial_number['ean_code']]);
            ManualConcept::where('ean_code', $picking_detail->ean_code)
              ->update(['ean_code' => $serial_number['ean_code']]);
          }

          if (!empty($delivery_exceptions[$serial_number['ean_code']])) {
            $scan_summaries[$serial_number['ean_code']]['quantity_picking'] += $picking_detail->quantity;
            $scan_summaries[$serial_number['ean_code']]['quantity_existing'] += $picking_detail->quantity;
          }

          $picking_detail->rs_invoice_no     = $rs_invoice_no;
          $picking_detail->rs_delivery_no    = $rs_delivery_no;
          $picking_detail->rs_delivery_items = $rs_delivery_items;
          $picking_detail->rs_quantity       = $rs_quantity;
          $picking_detail->rs_kode_customer  = $rs_kode_customer;
          $picking_detail->rs_code_sales     = $rs_code_sales;
          $picking_detail->rs_cbm_unit       = $rs_cbm_unit;

          $rs_picking_list_details[$serial_number['ean_code']] = $picking_detail;
        }

		//CEK: Ada SN sama dalam satu branch
		$lmbPickingDetail = $rs_picking_list_details[$serial_number['ean_code']];
		if (!empty($lmbPickingDetail->kode_cabang)) {
			$cek_double = LMBDetail::join('wms_lmb_header', 'wms_lmb_header.driver_register_id', 'wms_lmb_detail.driver_register_id')
				->where('wms_lmb_detail.serial_number', $serial_number['serial_number'])
				->where('wms_lmb_detail.ean_code', $serial_number['ean_code'])
				->where('wms_lmb_header.kode_cabang', $lmbPickingDetail->kode_cabang);
			if ($cek_double->count() > 0){
				return sendError('Duplicate SN `'. $serial_number['serial_number'] .'` in same Branch.');
			}
		}
		
		if (!key_exists('picking_detail_id', $serial_number)) {
			$serial_number['picking_detail_id'] = $rs_picking_list_details[$serial_number['ean_code']]->id;
		}
		
        $serial_number['model'] = $rs_models[$serial_number['ean_code']]->model_name;
        // $serial_number['delivery_no']        = $rs_picking_list_details[$serial_number['ean_code']]->delivery_no;
        // $serial_number['invoice_no']         = $rs_picking_list_details[$serial_number['ean_code']]->invoice_no;
        // $serial_number['kode_customer']      = $rs_picking_list_details[$serial_number['ean_code']]->kode_customer;
        // $serial_number['code_sales']         = $rs_picking_list_details[$serial_number['ean_code']]->code_sales;
        $serial_number['city_code']          = $rs_picking_list_details[$serial_number['ean_code']]->city_code;
        $serial_number['city_name']          = $rs_picking_list_details[$serial_number['ean_code']]->city_name;
        $serial_number['driver_register_id'] = $rs_picking_list_details[$serial_number['ean_code']]->driver_register_id;
        $serial_number['created_by']         = auth()->user()->id;

        // $serial_number['cbm_unit'] = $rs_picking_list_details[$serial_number['ean_code']]->cbm / $rs_picking_list_details[$serial_number['ean_code']]->quantity;
        // $serial_number['cbm_unit'] = $rs_picking_list_details[$serial_number['ean_code']]->cbm_unit;

        if (empty($scan_summaries[$serial_number['ean_code']])) {
          $scan_summaries[$serial_number['ean_code']] = [
            'model'             => $rs_models[$serial_number['ean_code']]->model_name,
            'quantity_scan'     => 0,
            'quantity_picking'  => $rs_picking_list_details[$serial_number['ean_code']]->quantity,
            'quantity_existing' => $rs_picking_list_details[$serial_number['ean_code']]->quantity,
          ];
        }

        // return $scan_summaries;

        if (
			$scan_summaries[$serial_number['ean_code']]['quantity_picking'] >= $scan_summaries[$serial_number['ean_code']]['quantity_scan'] 
			&& !empty($rs_picking_list_details[$serial_number['ean_code']]->rs_delivery_items[0])
		) {
          $serial_number['delivery_items'] = $rs_picking_list_details[$serial_number['ean_code']]->rs_delivery_items[0];
          $serial_number['delivery_no']    = $rs_picking_list_details[$serial_number['ean_code']]->rs_delivery_no[0];
          $serial_number['invoice_no']     = $rs_picking_list_details[$serial_number['ean_code']]->rs_invoice_no[0];
          $serial_number['kode_customer']  = $rs_picking_list_details[$serial_number['ean_code']]->rs_kode_customer[0];
          $serial_number['code_sales']     = $rs_picking_list_details[$serial_number['ean_code']]->rs_code_sales[0];
          $serial_number['cbm_unit']       = $rs_picking_list_details[$serial_number['ean_code']]->rs_cbm_unit[0];

          $scan_summaries[$serial_number['ean_code']]['quantity_scan'] += 1;
          $scan_summaries[$serial_number['ean_code']]['quantity_existing'] -= 1;

          $quantity = $rs_picking_list_details[$serial_number['ean_code']]->rs_quantity;
          $quantity[0] -= 1;
          $rs_picking_list_details[$serial_number['ean_code']]->rs_quantity = $quantity;

          if ($rs_picking_list_details[$serial_number['ean_code']]->rs_quantity[0] <= 0) {
            $rs_quantity = $rs_picking_list_details[$serial_number['ean_code']]->rs_quantity;
            unset($rs_quantity[0]);
            $rs_picking_list_details[$serial_number['ean_code']]->rs_quantity = array_values($rs_quantity);

            $rs_delivery_items = $rs_picking_list_details[$serial_number['ean_code']]->rs_delivery_items;
            unset($rs_delivery_items[0]);
            $rs_picking_list_details[$serial_number['ean_code']]->rs_delivery_items = array_values($rs_delivery_items);

            $rs_delivery_no = $rs_picking_list_details[$serial_number['ean_code']]->rs_delivery_no;
            unset($rs_delivery_no[0]);
            $rs_picking_list_details[$serial_number['ean_code']]->rs_delivery_no = array_values($rs_delivery_no);

            $rs_invoice_no = $rs_picking_list_details[$serial_number['ean_code']]->rs_invoice_no;
            unset($rs_invoice_no[0]);
            $rs_picking_list_details[$serial_number['ean_code']]->rs_invoice_no = array_values($rs_invoice_no);

            $rs_kode_customer = $rs_picking_list_details[$serial_number['ean_code']]->rs_kode_customer;
            unset($rs_kode_customer[0]);
            $rs_picking_list_details[$serial_number['ean_code']]->rs_kode_customer = array_values($rs_kode_customer);

            $rs_code_sales = $rs_picking_list_details[$serial_number['ean_code']]->rs_code_sales;
            unset($rs_code_sales[0]);
            $rs_picking_list_details[$serial_number['ean_code']]->rs_code_sales = array_values($rs_code_sales);

            $rs_cbm_unit = $rs_picking_list_details[$serial_number['ean_code']]->rs_cbm_unit;
            unset($rs_cbm_unit[0]);
            $rs_picking_list_details[$serial_number['ean_code']]->rs_cbm_unit = array_values($rs_cbm_unit);
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
      return sendError('Model Not Exist in pickinglist.', $model_not_exist_in_pickinglist);
    }

    if (empty($serial_numbers)) {
      return sendError('No Serial Number Data.');
    }

    try {
      DB::beginTransaction();
      LMBDetail::insert($serial_numbers);
      DB::commit();
      return sendSuccess('Serial Number uploaded.', $serial_numbers);
    } catch (\Exception $e) {
      DB::rollBack();
      return sendError('Serial Number Already uploaded!', $e);
      // return sendError('Serial Number Already uploaded!', json_decode($request->input('data'), true));
    }
  }
}
