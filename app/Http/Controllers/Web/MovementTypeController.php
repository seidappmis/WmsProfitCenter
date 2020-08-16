<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Models\MovementTransactionType;

class MovementTypeController extends Controller
{
  public function getSelect2(Request $request)
  {
    $query = MovementTransactionType::select(
      DB::raw('movement_code AS id'),
      DB::raw("CONCAT('[', movement_code, '] - ', transactions) AS text")
    )->toBase()
    ->groupBy('movement_code');

    $query->orderBy('text');

    return get_select2_data($request, $query);
  }
}
