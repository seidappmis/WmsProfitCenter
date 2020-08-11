<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\BeritaAcara;
use DataTables;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PDF;

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
                    $action .= ' ' . get_button_view(url('berita-acara/' . $data->id));
                    $action .= ' ' . get_button_print();
                    $action .= ' ' . get_button_delete();
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
        $berita_acara_no = '/BA-' . 'HQ' . '/' . date('m') . '/' . date('yy');

        $prefix_length = strlen($berita_acara_no);
        $max_no        = DB::select('SELECT MAX(SUBSTR(berita_acara_no, ?)) AS max_no FROM clm_berita_acara WHERE SUBSTR(berita_acara_no,1,?) = ? ', [$prefix_length + 2, $prefix_length, $berita_acara_no])[0]->max_no;
        $max_no        = str_pad($max_no + 1, 2, 0, STR_PAD_LEFT);

        $data = [
            'beritaAcaraNo' => $max_no . $berita_acara_no,
            'dateOfReceipt' => date('d-m-yy'),
        ];

        return view('web.claim.berita-acara.create', $data);
    }

    /**
     * Print preview.
     *
     * @return \Illuminate\Http\Response
     */
    public function printView($id)
    {
        // Data from database
        $data['beritaAcara'] = BeritaAcara::findOrFail($id);

        $config = [
            'format' => 'A4-L', // Landscape
        ];

        $pdf = PDF::loadview('web.claim.berita-acara.print',$data,[],$config);

        return $pdf->stream();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $data['beritaAcara'] = BeritaAcara::findOrFail($id);

        if ($request->ajax()) {
          $query = $data['beritaAcara']
            ->details()
            ->get();

          $datatables = DataTables::of($query)
            ->addIndexColumn() //DT_RowIndex (Penomoran)
            ->addColumn('action', function ($data) {
              $action = '';
              $action .= ' ' . get_button_edit(url('berita-acara/' . $data->id));
              $action .= ' ' . get_button_delete();
              return $action;
            });

          return $datatables->make(true);
        }

        return view('web.claim.berita-acara.view', $data);
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
          'berita_acara_no'   => 'max:20',
          'expedition_code'   => 'required',
          'driver_name'       => 'required',
          'vehicle_number'    => 'required',
          'file-do-manifest'  => 'nullable',
          'file-internal-do'  => 'nullable',
          'file-lmb'          => 'nullable',
        ]);

        $beritaAcara                  = new BeritaAcara;
        $beritaAcara->berita_acara_no = $request->input('berita_acara_no');
        $beritaAcara->date_of_receipt = date('Y-m-d', strtotime($request->input('date_of_receipt')));
        $beritaAcara->expedition_code = $request->input('expedition_code');
        $beritaAcara->driver_name     = $request->input('driver_name');
        $beritaAcara->vehicle_number  = $request->input('vehicle_number');

        // File DO Manifest
        if ($request->hasFile('file-do-manifest')) {
            $name = $request->file('file-do-manifest')->getClientOriginalName();
            $path = Storage::putFileAs('do-manifest/files', $request->file('file-do-manifest'), $name);
            $beritaAcara->do_manifest      = $path;
        }
        
        // File Internal DO
        if ($request->hasFile('file-internal-do')) {
            $name = $request->file('file-internal-do')->getClientOriginalName();
            $path = Storage::putFileAs('internal-do/files', $request->file('file-internal-do'), $name);
            $beritaAcara->internal_do      = $path;
        }
        

        // File LMB
        if ($request->hasFile('file-lmb')) {
            $name = $request->file('file-lmb')->getClientOriginalName();
            $path = Storage::putFileAs('lmb/files', $request->file('file-lmb'), $name);
            $beritaAcara->lmb              = $path;
        }

        $beritaAcara->save();

        return $beritaAcara;
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
        try {
          DB::beginTransaction();

          $beritaAcara = BeritaAcara::findOrFail($id);
          $beritaAcara->details()->delete();
          $beritaAcara->delete();

          DB::commit();

          return true;
        } catch (Exception $e) {
          DB::rollBack();

          return false;
        }
        return BeritaAcara::destroy($id);
    }
}
