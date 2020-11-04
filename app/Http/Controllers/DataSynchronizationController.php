<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;

class DataSynchronizationController extends Controller
{
  public function index(Request $request)
  {
    $this->updateConceptTruckFlow();
    // $this->updateDatabaseModules();
    // $this->updateDeliveryItemsLMB();
  }

  protected function updateConceptTruckFlow()
  {
    echo "Update Concept Truck Flow <br>";

    $conceptTruckFlow = \App\Models\ConceptTruckFlow::whereNull('created_start_date')->get();

    foreach ($conceptTruckFlow as $key => $value) {
      $lmbHeader = \App\Models\LMBHeader::find($value->concept_flow_header);
      if (!empty($lmbHeader)) {
        $detail_created_date       = $lmbHeader->detail_created_date();
        // print_r($detail_created_date);
        // return;
        $value->created_start_date = $detail_created_date->created_start_date;
        $value->created_end_date   = $detail_created_date->created_end_date;

        $value->save();
        echo 'Updating Concept Truck Flow ' . $value->concept_flow_header . '<br>';
      }
    }
  }

  protected function updateDatabaseModules()
  {
    echo "Add Update Serial Number <br>";
    \App\Models\Module::updateOrCreate(
      ['id' => 106],
      ['modul_name' => 'Update Serial Number', 'modul_link' => 'update-serial-no', 'group_name' => 'Picking', 'order_menu' => 4]
    );
    echo "Add Send To LMB <br>";
    \App\Models\Module::updateOrCreate(
      ['id' => 107],
      ['modul_name' => 'Send To LMB', 'modul_link' => 'send-to-lmb', 'group_name' => 'Picking', 'order_menu' => 5]
    );
  }

  protected function updateDeliveryItemsLMB()
  {
    echo "Checking LMB Data ... <br>";
    $temp_lmb_details = \App\Models\LMBDetail::whereNull('delivery_items')
      ->orderBy('picking_id', 'asc')
      ->orderBy('invoice_no', 'asc')
      ->orderBy('delivery_no', 'asc')
      ->get();

    $rs_picking_lmb = [];

    foreach ($temp_lmb_details as $key => $value) {
      $rs_picking_lmb[$value->picking_id][] = $value;
    }

    foreach ($rs_picking_lmb as $key => $lmb_details) {
      $serial_numbers                 = [];
      $scan_summaries                 = [];
      $model_not_exist_in_pickinglist = [];

      $rs_models               = [];
      $rs_picking_list_details = [];
      $delivery_exceptions     = [];

      foreach ($lmb_details as $key => $lmb_detail) {

        if (empty($rs_picking_list_details[$lmb_detail->ean_code])) {
          $picking_detail = \App\Models\PickinglistDetail::select(
            'wms_pickinglist_detail.delivery_no',
            'wms_pickinglist_detail.invoice_no',
            'wms_pickinglist_detail.kode_customer',
            'wms_pickinglist_detail.code_sales',
            'wms_pickinglist_header.city_code',
            'wms_pickinglist_header.city_name',
            'wms_pickinglist_header.driver_register_id',
            // 'wms_pickinglist_detail.quantity',
            'wms_pickinglist_detail.cbm',
            DB::raw('GROUP_CONCAT(wms_pickinglist_detail.delivery_items SEPARATOR ",") as rs_delivery_items'),
            DB::raw('GROUP_CONCAT(wms_pickinglist_detail.quantity SEPARATOR ",") as rs_quantity'),
            DB::raw('(SUM(wms_pickinglist_detail.quantity)) AS quantity ')
          )
            ->leftjoin('wms_pickinglist_header', 'wms_pickinglist_header.id', '=', 'wms_pickinglist_detail.header_id')
            ->groupBy(
              'wms_pickinglist_detail.header_id',
              'wms_pickinglist_detail.invoice_no',
              'wms_pickinglist_detail.delivery_no',
              // 'wms_pickinglist_detail.delivery_items',
              'wms_pickinglist_detail.ean_code'
            )
            ->where('wms_pickinglist_detail.ean_code', $lmb_detail->ean_code)
            ->where('wms_pickinglist_detail.invoice_no', $lmb_detail->invoice_no)
            ->where('wms_pickinglist_detail.delivery_no', $lmb_detail->delivery_no)
            ->where('wms_pickinglist_header.picking_no', $lmb_detail->picking_id)
            ->orderBy('quantity', 'desc')
          ;

          // if (!empty($delivery_exceptions[$lmb_detail->ean_code])) {
          //   $picking_detail->whereNotIn('wms_pickinglist_detail.delivery_no', $delivery_exceptions[$lmb_detail->ean_code]);
          // }

          $picking_detail = $picking_detail->first();

          if (empty($picking_detail) || $picking_detail->quantity == 0) {
            echo 'EAN ' . $lmb_detail->ean_code . ' not found in picking_list !  Invoice No ' . $lmb_detail->invoice_no . ' Delivery No ' . $lmb_detail->delivery_no . ' set Delivery Items to ' . $lmb_detail->delivery_items . '<br>';
            // echo "<pre>";
            // print_r($scan_summaries[$lmb_detail->ean_code]);
            // exit;
          }

          // if ($lmb_detail->picking_id == '8120201021002') {
          //   echo "<pre>";
          //   print_r($picking_detail->toArray());
          //   print_r($lmb_details);
          //   exit;
          //   # code...
          // }

          if (!empty($delivery_exceptions[$lmb_detail->ean_code])) {
            $scan_summaries[$lmb_detail->ean_code]['quantity_picking'] += $picking_detail->quantity;
            $scan_summaries[$lmb_detail->ean_code]['quantity_existing'] += $picking_detail->quantity;
          }

          $picking_detail->rs_delivery_items = explode(',', $picking_detail->rs_delivery_items);
          $picking_detail->rs_quantity       = explode(',', $picking_detail->rs_quantity);

          $rs_picking_list_details[$lmb_detail->ean_code] = $picking_detail;

        }

        $lmb_detail->delivery_items = $rs_picking_list_details[$lmb_detail->ean_code]->rs_delivery_items[0];

        if (empty($scan_summaries[$lmb_detail->ean_code])) {
          $scan_summaries[$lmb_detail->ean_code] = [
            'model'             => $lmb_detail->model,
            'quantity_scan'     => 0,
            'quantity_picking'  => $rs_picking_list_details[$lmb_detail->ean_code]->quantity,
            'quantity_existing' => $rs_picking_list_details[$lmb_detail->ean_code]->quantity,
          ];
        }

        if ($scan_summaries[$lmb_detail->ean_code]['quantity_picking'] >= $scan_summaries[$lmb_detail->ean_code]['quantity_scan']) {
          $scan_summaries[$lmb_detail->ean_code]['quantity_scan'] += 1;
          $scan_summaries[$lmb_detail->ean_code]['quantity_existing'] -= 1;

          $quantity = $rs_picking_list_details[$lmb_detail->ean_code]->rs_quantity;
          $quantity[0] -= 1;
          $rs_picking_list_details[$lmb_detail->ean_code]->rs_quantity = $quantity;

          if ($rs_picking_list_details[$lmb_detail->ean_code]->rs_quantity[0] <= 0) {
            $rs_quantity = $rs_picking_list_details[$lmb_detail->ean_code]->rs_quantity;
            unset($rs_quantity[0]);
            $rs_picking_list_details[$lmb_detail->ean_code]->rs_quantity = array_values($rs_quantity);

            $rs_delivery_items = $rs_picking_list_details[$lmb_detail->ean_code]->rs_delivery_items;
            unset($rs_delivery_items[0]);
            $rs_picking_list_details[$lmb_detail->ean_code]->rs_delivery_items = array_values($rs_delivery_items);
          }

          if ($scan_summaries[$lmb_detail->ean_code]['quantity_existing'] <= 0) {
            $delivery_exceptions[$lmb_detail->ean_code][] = $rs_picking_list_details[$lmb_detail->ean_code]->delivery_no;
            unset($rs_picking_list_details[$lmb_detail->ean_code]);
          }
        } else {
          $model_not_exist_in_pickinglist[$lmb_detail->ean_code]['picking_no'] = $lmb_detail->picking_id;
          $model_not_exist_in_pickinglist[$lmb_detail->ean_code]['model']      = $lmb_detail->model;
          if (empty($model_not_exist_in_pickinglist[$lmb_detail->ean_code]['total_sn'])) {
            $model_not_exist_in_pickinglist[$lmb_detail->ean_code]['total_sn'] = 0;
          }
          $model_not_exist_in_pickinglist[$lmb_detail->ean_code]['total_sn'] += 1;
        }

        $lmb_detail->save();
        echo 'Fixing data Invoice No ' . $lmb_detail->invoice_no . ' Delivery No ' . $lmb_detail->delivery_no . ' EAN ' . $lmb_detail->ean_code . ' set Delivery Items to ' . $lmb_detail->delivery_items . '.<br>';

      }
    }

    echo "Delivery items lmb synchronized. <i>(" . date('Y-m-d H:i:s') . ")</i><br>";
  }

}
