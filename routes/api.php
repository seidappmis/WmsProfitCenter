<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::get('picking-list/{picking_no}', function ($picking_no) {
  $pickingList = \App\Models\PickinglistHeader::where('picking_no', $picking_no)
    ->first();

  if (empty($pickingList)) {
    return sendError('Picking List Not Found !');
  }

  $data['picking_list'] = [
    'picking_no'   => $pickingList->picking_no,
    'picking_date' => $pickingList->picking_date,
  ];
  $data['details'] = $pickingList->details;

  return sendSuccess('Picing List Found.', $data);
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
  return $request->user();
});
