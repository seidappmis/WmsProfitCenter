<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\StockTakeInput1;
use DataTables;
use Illuminate\Http\Request;

class StockTakeInput1Controller extends Controller
{
  public function index(Request $request)
  {
    if ($request->ajax()) {
      $query = StockTakeInput1::
        where('sto_id', $request->input('sto_id'))
        ->whereNotNull('input_date')
      ;

      $datatables = DataTables::of($query)
        ->addIndexColumn() //DT_RowIndex (Penomoran)
        ->addColumn('action', function ($data) {
          $action = '';
          $action .= ' ' . get_button_edit('#input-wrapper');
          $action .= ' ' . get_button_delete();
          return $action;
        });

      return $datatables->make(true);
    }

    return view('web.stock-take.stock-take-input-1.index');
  }

  public function store(Request $request)
  {
    $request->validate([
      'id' => 'required',
    ]);

    $stockTakeInput = StockTakeInput1::findOrFail($request->input('id'));

    $stockTakeInput->quantity   = $request->input('quantity');
    $stockTakeInput->input_by   = auth()->user()->id;
    $stockTakeInput->input_date = date('Y-m-d H:i:s');

    $stockTakeInput->save();

    return sendSuccess('Input Success', $stockTakeInput);
  }

  public function destroy($id)
  {
    $stockTakeInput = StockTakeInput1::findOrFail($id);

    $stockTakeInput->quantity   = null;
    $stockTakeInput->input_by   = null;
    $stockTakeInput->input_date = null;

    $stockTakeInput->save();

    return $stockTakeInput;
  }
}
