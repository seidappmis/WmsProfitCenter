<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PickingToLMBController extends Controller
{
  public function storeScan(Request $request)
  {
    $data_serial_numbers = json_decode($request->input('data_serial_numbers'), true);

    if (empty($data_serial_numbers)) {
      return sendError('Data Empty.');
    }
    foreach ($data_serial_numbers as $key => $value) {
      $data_serial_numbers[$key] = $value;
    }

    LMBDetail::insert($data_serial_numbers);

    return sendSuccess('Picking submited', $data_serial_numbers);
  }

}
