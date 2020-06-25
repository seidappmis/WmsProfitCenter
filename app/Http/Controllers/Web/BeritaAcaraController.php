<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\BeritaAcara;
use DataTables;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
                    $action .= ' ' . get_button_view(url('berita-acara/' . $data->id . '/view'));
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
        $request->validate([
          'berita_acara_id'   => 'unique:clm_berita_acara|max:20',
          'expedition_code'   => 'required',
          'driver_name'       => 'required',
          'vehicle_number'    => 'required',
        ]);

        $beritaAcara                  = new BeritaAcara;
        $beritaAcara->berita_acara_id = $request->input('berita_acara_id');
        $beritaAcara->date_of_receipt = $request->input('date_of_receipt');
        $beritaAcara->expedition_code = $request->input('expedition_code');
        $beritaAcara->driver_name     = $request->input('driver_name');
        $beritaAcara->vehicle_number  = $request->input('vehicle_number');

        // File DO Manifest
        $path = Storage::putFileAs('do-manifest/files', $request->file('file-do-manifest'), 'file');
        $beritaAcara->do_manifest      = $path;

        // File Internal DO
        $path = Storage::putFileAs('internal-do/files', $request->file('file-internal-do'), 'file');
        $beritaAcara->internal_do      = $path;

        // File LMB
        $path = Storage::putFileAs('lmb/files', $request->file('file-lmb'), 'file');
        $beritaAcara->lmb              = $path;

        return $beritaAcara->save();
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
