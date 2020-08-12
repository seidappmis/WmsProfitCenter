<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\BeritaAcara;
use App\Models\ClaimNote;
use DataTables;
use DB;
use Illuminate\Http\Request;

class ClaimNoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('web.claim.claim-notes.index');
    }

    // DataTable Claim Note Carton Box Indez
    public function listCartonBox(Request $request)
    {
        if ($request->ajax()) {
            $query = ClaimNote::all();

            $datatables = DataTables::of($query)
                ->addIndexColumn() //DT_RowIndex (Penomoran)
                ->addColumn('action', function ($data) {
                    $action = '';
                    $action .= ' ' . get_button_view('#');
                    $action .= ' ' . get_button_print();
                    $action .= ' ' . get_button_delete();
                    return $action;
                });

            return $datatables->make(true);
        }
    }

    // DataTables Claim Note Unit Index
    public function listUnit(Request $request)
    {
        if ($request->ajax()) {
            $query = ClaimNote::all();

            $datatables = DataTables::of($query)
                ->addIndexColumn() //DT_RowIndex (Penomoran)
                ->addColumn('action', function ($data) {
                    $action = '';
                    $action .= ' ' . get_button_view('#');
                    $action .= ' ' . get_button_print();
                    $action .= ' ' . get_button_delete();
                    return $action;
                });

            return $datatables->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createCartonBox(Request $request)
    {
        if ($request->ajax()) {
            $query = BeritaAcara::select('clm_berita_acara.*', 'clm_berita_acara_detail.do_no', 'clm_berita_acara_detail.model_name', 'clm_berita_acara_detail.serial_number', 'clm_berita_acara_detail.qty', 'clm_berita_acara_detail.description', 'tr_expedition.expedition_name', 'tr_vehicle_expedition.destination')
                ->leftjoin('clm_berita_acara_detail', 'clm_berita_acara_detail.berita_acara_id', '=', 'clm_berita_acara.id')
                ->leftjoin('tr_expedition', 'tr_expedition.code', '=', 'clm_berita_acara.expedition_code')
                ->leftjoin('tr_vehicle_expedition', 'tr_vehicle_expedition.vehicle_number', '=', 'clm_berita_acara.vehicle_number');

            $datatables = DataTables::of($query)
                ->addIndexColumn() //DT_RowIndex (Penomoran)
                ->addColumn('location', function ($data) {
                    $location = $data->kode_cabang == null || 'HQ'? 'WH Return' : 'WH Branch';
                    return $location;
                })
                ->addColumn('total', function ($data) {
                    $total = 'total price test';
                    return $total;
                })
                ->addColumn('action', function ($data) {
                    $action = '';
                    $action .= ' ' . get_button_view('#', 'Select', 'btn-select');
                    return $action;
                });

            return $datatables->make(true);
        }
        return view('web.claim.claim-notes.create-carton-box');
    }

    public function createUnit(Request $request)
    {
        if ($request->ajax()) {
            $query = BeritaAcara::all();

            $datatables = DataTables::of($query)
                ->addIndexColumn() //DT_RowIndex (Penomoran)
                ->addColumn('action', function ($data) {
                    $action = '';
                    $action .= ' ' . get_button_view('#', 'Select');
                    return $action;
                });

            return $datatables->make(true);
        }
        return view('web.claim.claim-notes.create-unit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
