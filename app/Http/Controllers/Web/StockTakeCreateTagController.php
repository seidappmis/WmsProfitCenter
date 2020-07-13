<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\StockTakeInput1;
use App\Models\StockTakeInput2;
use DB;
use Illuminate\Http\Request;

class StockTakeCreateTagController extends Controller
{
  public function index()
  {
    return view('web.stock-take.stock-take-create-tag.index');
  }

  public function store(Request $request)
  {
    $request->validate([
      'sto_id'              => 'required',
      'file-stock-take-tag' => 'required',
    ]);

    $file_stocktake_create_tag = $request->file('file-stock-take-tag');

    $file  = fopen($file_stocktake_create_tag, "r");
    $title = true;

    $date             = date('Y-m-d H:i:s');
    $stocktake_inputs = [];

    // Loop data sampai baris terakhir
    while (!feof($file)) {
      $row = fgetcsv($file);
      if ($title) {
        $title = false;
        continue; // Skip baris judul
      }

      $stockTakeInput['sto_id']      = $request->input('sto_id');
      $stockTakeInput['no_tag']      = $row[0];
      $stockTakeInput['model']       = $row[0];
      $stockTakeInput['location']    = $row[1];
      $stockTakeInput['upload_date'] = $date;
      $stockTakeInput['upload_by']   = auth()->user()->id;

      if (!empty($stockTakeInput['no_tag'])) {
        $stocktake_inputs[] = $stockTakeInput;
      }
    }

    fclose($file);

    return DB::transaction(function () use ($stocktake_inputs) {
      StockTakeInput1::insert($stocktake_inputs);
      StockTakeInput2::insert($stocktake_inputs);
      return 1;
    });

  }

  public function getSelect2NoTag1(Request $request)
  {
    $query = StockTakeInput1::select(
      DB::raw('id AS id'),
      DB::raw("no_tag AS text"),
      'log_stocktake_input1.*'
    )->whereNull('input_date');

    return get_select2_data($request, $query);
  }

  public function getSelect2NoTag2(Request $request)
  {
    $query = StockTakeInput2::select(
      DB::raw('id AS id'),
      DB::raw("no_tag AS text"),
      'log_stocktake_input2.*'
    )->whereNull('input_date');

    return get_select2_data($request, $query);
  }

}
