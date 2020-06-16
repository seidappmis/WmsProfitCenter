<?php

namespace App\Http\Controllers\Web\StockTake;

use App\Http\Controllers\Controller;
use App\Models\StockTakeSchedule;
use App\Models\StockTakeScheduleDetail;
use DB;
use Illuminate\Http\Request;

class STScheduleDetailController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($sto_id, $id)
    {
        $data = [
	      'stockTakeSchedule'  => StockTakeSchedule::find($sto_id),
	      'stockTakeScheduleDetail' => StockTakeScheduleDetail::find($id),
	    ];

        return view('web.stock-take.stock-take-schedule.edit-detail_form', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $sto_id, $id)
    {
        $request->validate([
	      'qty' => 'required',
	    ]);

	    $stockTakeScheduleDetail 				= StockTakeScheduleDetail::find($id);
	    $stockTakeScheduleDetail->sto_id        = $sto_id;
	    $stockTakeScheduleDetail->material_no   = $request->input('material_no');
	    $stockTakeScheduleDetail->qty           = $request->input('qty');

	    return $stockTakeScheduleDetail->save();
    }
}
