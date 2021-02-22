<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;

class PickinglistController extends Controller
{
  public function getPickingList(Request $request, $picking_no)
  {
    $pickingList = \App\Models\PickinglistHeader::where('picking_no', $picking_no)
    // ->where('kode_cabang', substr($request->input('kode_customer'), 0, 2))
      ->first();

    // return sendError('kode_customer' . $request->input('kode_customer'));

    if (empty($pickingList)) {
      return sendError('Picking List Not Found !', $request->all());
    }

    if (substr($request->input('kode_customer'), 0, 2) != $pickingList->kode_cabang) {
      return sendError('Picking List Not Found !', $request->all());
    }

    // if (!auth()->user()->cabang->hq && $pickingList->kode_cabang != auth()->user()->cabang->kode_cabang) {
    //   return sendError('Picking List Not Found !');
    // }

    // if (auth()->user()->cabang->hq && auth()->user()->area != $pickingList->area) {
    //   return sendError('Picking List Not Found !');
    // }

    // return $pickingList;

    $data['picking_list'] = [
      'id'           => $pickingList->id,
      'picking_no'   => $pickingList->picking_no,
      'picking_date' => $pickingList->picking_date,
    ];
    $temp_details = $pickingList->details()
      ->select(
        'wms_pickinglist_detail.id',
        'wms_pickinglist_detail.header_id',
        'wms_pickinglist_detail.ean_code',
        'wms_pickinglist_detail.model',
        'wms_pickinglist_detail.quantity',
        'wms_pickinglist_detail.cbm',
        DB::raw('COUNT(wms_lmb_detail.serial_number) AS quantity_in_lmb')
      )
      ->leftjoin('wms_lmb_detail', function ($join) {
        $join->on('wms_lmb_detail.picking_id', '=', 'wms_pickinglist_detail.header_id');
        $join->on('wms_lmb_detail.delivery_no', '=', 'wms_pickinglist_detail.delivery_no');
        $join->on('wms_lmb_detail.invoice_no', '=', 'wms_pickinglist_detail.invoice_no');
        $join->on('wms_lmb_detail.ean_code', '=', 'wms_pickinglist_detail.ean_code');
        $join->on('wms_lmb_detail.delivery_items', '=', 'wms_pickinglist_detail.delivery_items');
      })
      ->groupBy(
        'wms_pickinglist_detail.header_id',
        'wms_pickinglist_detail.invoice_no',
        'wms_pickinglist_detail.delivery_no',
        'wms_pickinglist_detail.delivery_items',
        'wms_pickinglist_detail.ean_code'
      )
      ->orderBy('wms_pickinglist_detail.model')
      ->get();

    $details = [];
    foreach ($temp_details as $key => $value) {
      if ($value->quantity > $value->quantity_in_lmb) {
        if (empty($details[$value->ean_code])) {
          $details[$value->ean_code] = $value;
        } else {
          $details[$value->ean_code]->quantity += ($value->quantity - $value->quantity_in_lmb);
          $details[$value->ean_code]->cbm += $value->cbm;
        }
      }
    }

    $data['details'] = array_values($details);

    return sendSuccess('Picing List Found.', $data);
  }
}
