<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\BeritaAcara;
use App\Models\BeritaAcaraDetail;
use DataTables;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

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
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'do_no'             => 'required',
                'model_name'        => 'required',
                'qty'               => 'required',
                'description'       => 'required',
                'photo'             => 'nullable|mimes:jpeg,jpg,png,gif',
                'keterangan'        => 'required',
            ]);

            // Check validation failure
            if ($validator->fails()) {
                return sendError($validator->messages()->first());
            }

            try {
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
                    $name = uniqid() . '.' . pathinfo($request->file('photo')->getClientOriginalName(), PATHINFO_EXTENSION);
                    $path = Storage::putFileAs('public/berita-acara-detail/photos', $request->file('photo'), $name);
                    $beritaAcaraDetail->photo_url  = 'berita-acara-detail/photos/' . $name;
                }

                $beritaAcaraDetail->keterangan      = $request->input('keterangan');
                DB::transaction(function () use (&$beritaAcaraDetail) {
                    $beritaAcaraDetail->save();
                });
                return sendSuccess('Data Successfully Created.', []);
            } catch (\Exception $e) {
                return sendError($e->getMessage());
            }
        }
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
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'do_no'             => 'required',
                'model_name'        => 'required',
                'qty'               => 'required',
                'description'       => 'required',
                'photo'             => 'nullable|mimes:jpeg,jpg,png,gif',
                'keterangan'        => 'required',
            ]);

            // Check validation failure
            if ($validator->fails()) {
                return sendError($validator->messages()->first());
            }

            try {
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
                    unlink(storage_path('app/public/' . $request->old_file));
                    $name = uniqid() . '.' . pathinfo($request->file('photo')->getClientOriginalName(), PATHINFO_EXTENSION);
                    $path = Storage::putFileAs('public/berita-acara-detail/photos', $request->file('photo'), $name);
                    $beritaAcaraDetail->photo_url  = 'berita-acara-detail/photos/' . $name;
                }

                $beritaAcaraDetail->keterangan      = $request->input('keterangan');
                DB::transaction(function () use (&$beritaAcaraDetail) {
                    $beritaAcaraDetail->save();
                });
                return sendSuccess('Data Successfully Updated.', []);
            } catch (\Exception $e) {
                return sendError($e->getMessage());
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($berita_acara_id, $berita_acara_detail_id)
    {
        try {
            $file = BeritaAcaraDetail::where('id', $berita_acara_detail_id)->first()->photo_url;

            DB::transaction(function () use (&$berita_acara_detail_id) {
                BeritaAcaraDetail::destroy($berita_acara_detail_id);
            });

            if (!empty($file)) {
                unlink(storage_path('app/public/' . $file));
            }

            return sendSuccess('Data Has Been Deleted.', []);
        } catch (\Exception $e) {
            return sendError($e->getMessage());
        }
    }
}
