<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\FinishGoodHeader;
use App\Models\FinishGoodDetail;
use DataTables;
use DB;
use Illuminate\Http\Request;

class FinishGoodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('web.incoming.finish-good-production.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('web.incoming.finish-good-production.create');
    }

    public function submitToInventory($id)
    {
        $finishGoodHeader = FinishGoodHeader::findOrFail($id);

        $finishGoodHeader->submit      = 1;
        $finishGoodHeader->submit_date = date('Y-m-d H:i:s');
        $finishGoodHeader->submit_by   = auth()->user()->id;

        $finishGoodHeader->save();

        return $finishGoodHeader;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $finishGoodHeader = new FinishGoodHeader;

        // Receipt_No => ARV-WAREHOUSE-TANGGAL-Urutan
        $receipt_no = 'ARV' . '-WH' . 'KRW' . '-' . date('ymd') . '-';

        $prefix_length = strlen($receipt_no);
        $max_no        = DB::select('SELECT MAX(SUBSTR(receipt_no, ?)) AS max_no FROM log_finish_good_header WHERE SUBSTR(receipt_no,1,?) = ? ', [$prefix_length + 2, $prefix_length, $receipt_no])[0]->max_no;
        $max_no        = str_pad($max_no + 1, 3, 0, STR_PAD_LEFT);

        $warehouse = 'SHARP KARAWANG W/H';
        $supplier  = 'WM';
        $area      = 'KARAWANG';

        $finishGoodHeader->receipt_no    = $receipt_no . $max_no;
        $finishGoodHeader->warehouse     = $warehouse;
        $finishGoodHeader->supplier      = $supplier;
        $finishGoodHeader->area          = $area;
        $finishGoodHeader->kode_cabang   = auth()->user()->cabang->kode_cabang;
        $finishGoodHeader->submit        = 0;

        try {
           DB::beginTransaction();

           $finishGoodHeader->save();

           // Finish Good Detail
           if ($finishGoodHeader->save()) {
               $finishGoodDetail = new FinishGoodDetail;
               $finishGoodDetail->receipt_no_header = $finishGoodHeader->receipt_no;
               $finishGoodDetail->bar_ticket_header = 1;
               $finishGoodDetail->model = 1;
               $finishGoodDetail->quantity = 1;
               $finishGoodDetail->print_type = 1;
               $finishGoodDetail->ean_code = 1;
               $finishGoodDetail->kode_cabang = auth()->user()->cabang->kode_cabang;
               $finishGoodDetail->storage_id = 1;

               $finishGoodDetail->save();
           }

           DB::commit();

           return $finishGoodHeader;

        } catch (Exception $e) {
          DB::rollBack();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        // $data['finishGoodHeader'] = FinishGoodHeader::findOrFail($id);

        // if ($request->ajax()) {
        //   $query = $data['finishGoodHeader']
        //     ->details()
        //     ->get();

        //   $datatables = DataTables::of($query)
        //     ->addIndexColumn() //DT_RowIndex (Penomoran)
        //     ->addColumn('action', function ($data) {
        //       $action = '';
        //       //$action .= ' ' . get_button_edit(url('master-area/' . $data->area . '/edit'));
        //       //$action .= ' ' . get_button_delete();
        //       return $action;
        //     });

        //   return $datatables->make(true);
        // }
        // return view('web.incoming.finish-good-production.view', $data);
        return view('web.incoming.finish-good-production.view');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }
}
