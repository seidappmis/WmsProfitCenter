<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\BeritaAcara;
use App\Models\BeritaAcaraDetail;
use DataTables;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BeritaAcaraDetailController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $berita_acara_id)
    {
        $request->validate([
          'berita_acara_id'   => 'max:20',
          'do_no'             => 'nullable',
          'model_name'        => 'nullable',
          'qty'               => 'nullable',
          'description'       => 'nullable',
          'photo'             => 'nullable',
          'keterangan'        => 'nullable',
        ]);

        $beritaAcaraDetail                  = new BeritaAcaraDetail;
        $beritaAcaraDetail->berita_acara_id = $berita_acara_id;
        $beritaAcaraDetail->berita_acara_no = $request->input('berita_acara_no');
        $beritaAcaraDetail->do_no           = $request->input('do_no');
        $beritaAcaraDetail->model_name      = $request->input('model_name');
        $beritaAcaraDetail->serial_number   = $request->input('serial_number');
        $beritaAcaraDetail->qty             = $request->input('qty');
        $beritaAcaraDetail->description     = $request->input('description');

        // cek photo upload
        if ($request->hasFile('photo')) {
            $path = Storage::putFileAs('berita-acara-detail/photos', $request->file('photo'), 'photo');
            $beritaAcaraDetail->photo_url   = $path;
        }
        
        $beritaAcaraDetail->keterangan      = $request->input('keterangan');

        return $beritaAcaraDetail->save();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($berita_acara_id, $berita_acara_detail_id)
    {
        $data = [
          'beritaAcara'       => BeritaAcara::find($berita_acara_id),
          'beritaAcaraDetail' => BeritaAcaraDetail::find($berita_acara_detail_id),
        ];

        return view('web.claim.berita-acara.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $berita_acara_id, $berita_acara_detail_id)
    {
        $request->validate([
          'berita_acara_id'   => 'max:20',
          'do_no'             => 'nullable',
          'model_name'        => 'nullable',
          'qty'               => 'nullable',
          'description'       => 'nullable',
          'photo'             => 'nullable',
          'keterangan'        => 'nullable',
        ]);

        $beritaAcaraDetail                  = BeritaAcaraDetail::find($berita_acara_detail_id);
        $beritaAcaraDetail->berita_acara_id = $berita_acara_id;
        $beritaAcaraDetail->berita_acara_no = $request->input('berita_acara_no');
        $beritaAcaraDetail->do_no           = $request->input('do_no');
        $beritaAcaraDetail->model_name      = $request->input('model_name');
        $beritaAcaraDetail->serial_number   = $request->input('serial_number');
        $beritaAcaraDetail->qty             = $request->input('qty');
        $beritaAcaraDetail->description     = $request->input('description');

        // cek photo upload
        if ($request->hasFile('photo')) {
            $path = Storage::putFileAs('berita-acara-detail/photos', $request->file('photo'), 'photo');
            $beritaAcaraDetail->photo_url   = $path;
        }
        
        $beritaAcaraDetail->keterangan      = $request->input('keterangan');

        return $beritaAcaraDetail->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($berita_acara_id, $berita_acara_detail_id)
    {
        return BeritaAcaraDetail::destroy($berita_acara_detail_id);
    }
}
