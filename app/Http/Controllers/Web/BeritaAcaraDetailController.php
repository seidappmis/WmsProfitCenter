<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\BeritaAcara;
use App\Models\BeritaAcaraDetail;
use DataTables;
use DB;
use Illuminate\Http\Request;

class BeritaAcaraDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $berita_acara_id)
    {
        if ($request->ajax()) {
          $query = BeritaAcara::find($berita_acara_id)->details;

          $datatables = DataTables::of($query)
            ->addIndexColumn() //DT_RowIndex (Penomoran)
            ->addColumn('action', function ($data) {
              $action = '';
              $action .= ' ' . get_button_edit(url('berita-acara/' . $data->berita_acara_id . '/view/' . $data->id . '/edit'));
              $action .= ' ' . get_button_delete();
              return $action;
            });

          return $datatables->make(true);
        }

        $data = [
          'beritaAcara' => BeritaAcara::find($berita_acara_id),
        ];

        return view('web.claim.berita-acara.view', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
