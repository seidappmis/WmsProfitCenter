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
      return sendError('Picking List Not Found !');
    }

    if (substr($request->input('kode_customer'), 0, 2) != $pickingList->kode_cabang) {
      return sendError('Picking List Not Found !');
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
    $data['details'] = $pickingList->details()
      ->select(
        'id',
        'header_id',
        'ean_code',
        'model',
        DB::raw('SUM(quantity) AS quantity'),
        DB::raw('SUM(cbm) AS cbm')
      )
      ->groupBy('ean_code')
      ->get();

    return sendSuccess('Picing List Found.', $data);
  }
}
