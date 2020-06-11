<?php

namespace App\Http\Controllers\Web\StockTake;

use App\Http\Controllers\Controller;
use App\Models\StockTakeSchedule;
use DataTables;
use DB;
use Illuminate\Http\Request;

class STScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = StockTakeSchedule::all();

            $datatables = DataTables::of($query)
                ->addIndexColumn() //DT_RowIndex (Penomoran)
                ->addColumn('action', function ($data) {
                    $action = '';
                    $action .= ' ' . get_button_edit(url('stock-take-schedule/' . $data->sto_id . '/edit'));
                    $action .= ' ' . get_button_delete();
                    $action .= ' ' . get_button_view(url('stock-take-schedule/' . $data->sto_id ), 'View Detail');
                    $action .= ' ' . get_button_save('Finish');
                    return $action;
                });

            return $datatables->make(true);
        }
        return view('web.stock-take.stock-take-schedule.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('web.stock-take.stock-take-schedule.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
          'sto_id'                    => 'unique:log_stocktake_schedule|max:18',
          'area'                      => 'max:20',
          'branch'                    => 'max:20',
          'description'               => 'max:100',
          'schedule_start_date'       => 'nullable',
          'schedule_end_date'         => 'nullable',
        ]);

        $stockTakeSchedule = new StockTakeSchedule;

        // sto_id = Kode Area/short description cabang-STO-Tanggal-Urutan
        $kode = empty($request->input('area')) ? $request->input('kode_cabang') : $request->input('area');
        $sto_id = $kode . '-STO-' . date('ymd') . '-';

        $prefix_length = strlen($sto_id);
        $max_no        = DB::select('SELECT MAX(SUBSTR(sto_id, ?)) AS max_no FROM log_stocktake_schedule WHERE SUBSTR(sto_id,1,?) = ? ', [$prefix_length + 2, $prefix_length, $sto_id])[0]->max_no;
        $max_no        = str_pad($max_no + 1, 3, 0, STR_PAD_LEFT);

        $stockTakeSchedule->sto_id = empty($request->input('sto_id')) ? 'KRW-STO-2232-001' : $sto_id . $max_no;

        $stockTakeSchedule->area = empty($request->input('area')) ? ' ' : $request->input('area');
        $stockTakeSchedule->kode_cabang = $request->input('kode_cabang');
        $stockTakeSchedule->description = $request->input('description');
        $stockTakeSchedule->schedule_start_date = date('Y-m-d', strtotime($request->input('schedule_start_date')));
        $stockTakeSchedule->schedule_end_date = date('Y-m-d', strtotime($request->input('schedule_end_date')));
        $stockTakeSchedule->urut = $max_no;

        return $stockTakeSchedule->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('web.stock-take.stock-take-schedule.detail');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['stockTakeSchedule'] = StockTakeSchedule::findOrFail($id);

        return view('web.stock-take.stock-take-schedule.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return StockTakeSchedule::destroy($id);
    }
}
