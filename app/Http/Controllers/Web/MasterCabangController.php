<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\MasterCabang;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MasterCabangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = MasterCabang::all();

            $datatables = DataTables::of($query)
                ->addIndexColumn() //DT_RowIndex (Penomoran)
                ->addColumn('action', function ($data) {
                    $action = '';
                    $action .= ' ' . get_button_edit(url('master-cabang/' . $data->kode_customer . '/edit'));
                    $action .= ' ' . get_button_delete();
                    return $action;
                });

            return $datatables->make(true);
        }
        return view('web.settings.master-cabang.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('web.settings.master-cabang.create');
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
            'kode_customer'  => 'required|unique:log_cabang|max:8',
            'kode_cabang'    => 'required|max:2',
            'sdes'  => 'max:3',
            'ldes'  => 'max:100',
            'region'  => 'max:100',
            'tycode'  => 'max:2',
            'start_wms'  => 'max:20'
        ]);

        $masterCabang                = new MasterCabang;
        $masterCabang->kode_customer = $request->input('kode_customer');
        $masterCabang->kode_cabang   = $request->input('kode_cabang');
        $masterCabang->short_description   = $request->input('sdes');
        $masterCabang->long_description   = $request->input('ldes');
        $masterCabang->hq            = !empty($request->input('hq'));
        $masterCabang->region        = $request->input('region');
        $masterCabang->type          = $request->input('tycode');
        $masterCabang->start_wms     = $request->input('start_wms');

        return $masterCabang->save();
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
        $data['masterCabang'] = MasterCabang::findOrFail($id);

        return view('web.settings.master-cabang.edit', $data);
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
        $request->validate([
            'kode_customer'  => 'required|max:8',
            'kode_cabang'    => 'required|max:2',
            'sdes'  => 'max:3',
            'ldes'  => 'max:100',
            'region'  => 'max:100',
            'tycode'  => 'max:2',
            'start_wms'  => 'max:20',
        ]);

        $masterCabang                = MasterCabang::findOrFail($id);
        $masterCabang->kode_customer = $request->input('kode_customer');
        $masterCabang->kode_cabang   = $request->input('kode_cabang');
        $masterCabang->short_description   = $request->input('sdes');
        $masterCabang->long_description   = $request->input('ldes');
        $masterCabang->hq   = !empty($request->input('hq'));
        $masterCabang->region   = $request->input('region');
        $masterCabang->type   = $request->input('tycode');
        $masterCabang->start_wms     = $request->input('start_wms');

        return $masterCabang->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return MasterCabang::destroy($id);
    }

    public function getSelect2Region(Request $request)
    {
        $query = \App\Models\Region::select(
          DB::raw('region AS id'),
          DB::raw("region AS text")
        );

        return get_select2_data($request, $query);
    }

    public function getSelect2Cabang(Request $request)
    {
        $query = MasterCabang::select(
          DB::raw('kode_customer AS id'),
          DB::raw("CONCAT(short_description, '-', long_description) AS text")
        );

        return get_select2_data($request, $query);
    }

}
