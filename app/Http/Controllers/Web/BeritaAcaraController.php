<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\BeritaAcara;
use DataTables;
use DB;
use Illuminate\Http\Request;

class BeritaAcaraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = BeritaAcara::all();

            $datatables = DataTables::of($query)
                ->addIndexColumn() //DT_RowIndex (Penomoran)
                ->addColumn('action', function ($data) {
                    $action = '';
                    $action .= ' ' . get_button_view(url('berita-acara/' . $data->berita_acara_id));
                    $action .= ' ' . get_button_print();
                    return $action;
                });

            return $datatables->make(true);
        }
        return view('web.claim.berita-acara.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // No. Berita Acara : No.urut/BA-Kode cabang/Bulan/Tahun
        $berita_acara_id = '/BA-' . 'HQ' . '/' . date('m') . '/' . date('yy');

        $prefix_length = strlen($berita_acara_id);
        $max_no        = DB::select('SELECT MAX(SUBSTR(berita_acara_id, ?)) AS max_no FROM clm_berita_acara WHERE SUBSTR(berita_acara_id,1,?) = ? ', [$prefix_length + 2, $prefix_length, $berita_acara_id])[0]->max_no;
        $max_no        = str_pad($max_no + 1, 2, 0, STR_PAD_LEFT);

        $data = [
            'beritaAcaraID' => $max_no . $berita_acara_id,
            'dateOfReceipt' => date('d-m-yy'),
        ];

        return view('web.claim.berita-acara.create', $data);
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
