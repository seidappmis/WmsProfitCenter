<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\BeritaAcara;
use DataTables;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
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
      $query = BeritaAcara::select(
        'clm_berita_acara.*',
        DB::raw('tr_expedition.expedition_name AS expedition_name')
      )
        ->leftjoin(
          'tr_expedition',
          'tr_expedition.code',
          '=',
          'clm_berita_acara.expedition_code'
        );

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
    return view('web.claim.berita-acara.create');
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show(Request $request, $berita_acara_id)
  {
    $data['beritaAcara'] = BeritaAcara::findOrFail($berita_acara_id);

    if ($request->ajax()) {
      $query = $data['beritaAcara']
        ->details()
        ->get();

      $datatables = DataTables::of($query)
        ->addIndexColumn() //DT_RowIndex (Penomoran)
        ->addColumn('action', function ($data) {
          $action = '';
          $action .= ' ' . get_button_edit(url('berita-acara/' . $data->berita_acara_id . '/detail/' . $data->id . '/edit'));
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
    if ($request->ajax()) {

      $validator = Validator::make($request->all(), [
        'expedition_code'   => 'required',
        'driver_name'       => 'required',
        'vehicle_number'    => 'required',
        'file-do-manifest'  => 'nullable|mimes:jpeg,jpg,png,gif',
        'file-internal-do'  => 'nullable|mimes:jpeg,jpg,png,gif',
        'file-lmb'          => 'nullable|mimes:jpeg,jpg,png,gif',
      ]);

      // Check validation failure
      if ($validator->fails()) {
        return ['status' => false, 'msg' => $validator->messages()->first()];
      }
      // Generate No. Berita Acara : No.urut/BA-Kode cabang/Bulan/Tahun
      $kode_cabang = auth()->user()->cabang->short_description;
      $formatNumber = '/BA-' . $kode_cabang . '/' . date('m') . '/' . date('yy');

      $prefix_length = strlen($formatNumber);
      $max_no        = DB::select('SELECT MAX(SUBSTR(berita_acara_no, 1, 2)) AS max_no FROM clm_berita_acara WHERE SUBSTR(berita_acara_no,1,1) = 0 ', [$prefix_length + 2, $prefix_length, $formatNumber])[0]->max_no;
      $max_no        = str_pad($max_no + 1, 2, 0, STR_PAD_LEFT);

      $beritaAcaraNo = $max_no . $formatNumber;

      try {
        $beritaAcara                  = new BeritaAcara;
        $beritaAcara->berita_acara_no = $beritaAcaraNo;
        $beritaAcara->date_of_receipt = date('Y-m-d', strtotime($request->input('date_of_receipt')));
        $beritaAcara->expedition_code = $request->input('expedition_code');
        $beritaAcara->driver_name     = $request->input('driver_name');
        $beritaAcara->vehicle_number  = $request->input('vehicle_number');
        // File DO Manifest
        if ($request->hasFile('file-do-manifest')) {
          $name = uniqid() . '.' . pathinfo($request->file('file-do-manifest')->getClientOriginalName(), PATHINFO_EXTENSION);
          $path = Storage::putFileAs('public/do-manifest/files', $request->file('file-do-manifest'), $name);
          $beritaAcara->do_manifest  = 'do-manifest/files/' . $name;
        }

        // File Internal DO
        if ($request->hasFile('file-internal-do')) {
          $name = uniqid() . '.' . pathinfo($request->file('file-internal-do')->getClientOriginalName(), PATHINFO_EXTENSION);
          $path = Storage::putFileAs('public/internal-do/files', $request->file('file-internal-do'), $name);
          $beritaAcara->internal_do   = 'internal-do/files' . $name;
        }


        // File LMB
        if ($request->hasFile('file-lmb')) {
          $name = uniqid() . '.' . pathinfo($request->file('file-lmb')->getClientOriginalName(), PATHINFO_EXTENSION);
          $path = Storage::putFileAs('public/lmb/files/', $request->file('file-lmb'), $name);
          $beritaAcara->lmb             = 'lmb/files/' . $name;
        }

        $beritaAcara->kode_cabang         = auth()->user()->cabang->short_description;

        DB::transaction(function () use (&$beritaAcara) {
          // dd($beritaAcara);
          $beritaAcara->save();
        });

        return ['status' => true, 'msg' => 'successfully create date', 'meta' => $beritaAcara];
      } catch (\Exception $e) {
        return ['status' => false, 'msg' => $e->getMessage()];
      }
    }
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

  /**
   * Print.
   *
   * @return \Illuminate\Http\Response
   */
  public function export(Request $request, $id)
  {
    $view_print = view('web.claim.berita-acara.print');
    $title      = 'berita_acara';

    if ($request->input('filetype') == 'html') {
      // Request HTML View
      return $view_print;
    } else if ($request->input('filetype') == 'xls') {
      // Request File EXCEL
      $reader      = new \PhpOffice\PhpSpreadsheet\Reader\Html();
      $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

      $spreadsheet = $reader->loadFromString($view_print, $spreadsheet);

      // Set warna background putih
      $spreadsheet->getDefaultStyle()->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('ffffff');

      // Set Font
      $spreadsheet->getDefaultStyle()->getFont()->setName('courier New');

      // Atur lebar kolom
      $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(20);
      $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);

      $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment; filename="' . $title . '.xls"');

      $writer->save("php://output");
    } else if ($request->input('filetype') == 'pdf') {
      // Request File PDF
      $mpdf = new \Mpdf\Mpdf(['tempDir' => '/tmp']);

      $mpdf->WriteHTML($view_print, \Mpdf\HTMLParserMode::HTML_BODY);

      $mpdf->Output($title . '.pdf', "D");
    } else {
      // Parameter filetype tidak valid / tidak ditemukan return 404
      return redirect(404);
    }
  }
}
