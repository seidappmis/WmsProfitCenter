<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\MasterArea;
use DataTables;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\DB;

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
                    $action .= ' ' . get_button_edit(url('master-cabang/' . $data->code_cabang . '/edit'));
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
            'code_customer'  => 'max:8',
            'code_cabang'    => 'required|unique:master_cabang|max:2',
            'sdes'  => 'required|max:3',
            'ldes'  => 'required|max:100',
            'region'  => 'required|max:100',
            'tycode'  => 'required|max:2',
        ]);

        $masterCabang                = new MasterCabang;
        $masterCabang->code_customer = $request->input('code_customer');
        $masterCabang->code_cabang   = $request->input('code_cabang');
        $masterCabang->sdes   = $request->input('sdes');
        $masterCabang->ldes   = $request->input('ldes');
        $masterCabang->region   = $request->input('region');
        $masterCabang->tycode   = $request->input('tycode');

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
            'code_customer'  => 'max:8',
            'code_cabang'    => 'required|unique:master_cabang|max:2',
            'sdes'  => 'required|max:3',
            'ldes'  => 'required|max:100',
            'region'  => 'required|max:100',
            'tycode'  => 'required|max:2',
        ]);

        $masterCabang                = MasterCabang;
        $masterCabang->code_customer = $request->input('code_customer');
        $masterCabang->code_cabang   = $request->input('code_cabang');
        $masterCabang->sdes   = $request->input('sdes');
        $masterCabang->ldes   = $request->input('ldes');
        $masterCabang->region   = $request->input('region');
        $masterCabang->tycode   = $request->input('tycode');

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

    /**
     * Show the application dataAjax.
     *
     * @return \Illuminate\Http\Response
     */
}
