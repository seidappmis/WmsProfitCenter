<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\BeritaAcara;
use App\Models\BeritaAcaraDetail;
use App\Models\MasterModel;
use DataTables;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

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
        )
        ->orderBy('clm_berita_acara.created_at', 'DESC');

      $datatables = DataTables::of($query)
        ->addIndexColumn() //DT_RowIndex (Penomoran)
        ->addColumn('action', function ($data) {
          $action = '';
          $action .= ' ' . get_button_view(url('berita-acara/' . $data->id));
          $action .= ' ' . get_button_print('#', 'Print Letter', 'btn-print-letter');
          $action .= ' ' . get_button_print();
          if (empty($data->submit_date)  && $data->details()->count() > 0) {
            $action .= ' ' . get_button_edit('#!', 'Submit', 'btn-submit');
            $action .= ' ' . get_button_delete();
          }
          return $action;
        });

      return $datatables->make(true);
    };

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
        ->select('clm_berita_acara_detail.*', 'clm_berita_acara.submit_date')
        ->leftjoin('clm_berita_acara', 'clm_berita_acara.id', '=', 'clm_berita_acara_detail.berita_acara_id')
        ->get();

      $datatables = DataTables::of($query)
        ->addIndexColumn() //DT_RowIndex (Penomoran)
        ->addColumn('action', function ($data) {
          $action = '';
          if (empty($data->submit_date)) {
            $action .= ' ' . get_button_edit(url('berita-acara/' . $data->berita_acara_id . '/detail/' . $data->id . '/edit'));
            $action .= ' ' . get_button_delete();
          }
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
        'expedition_code'  => 'required',
        'driver_name'      => 'required',
        'vehicle_number'   => 'required',
        'file-do-manifest' => 'nullable|mimes:jpeg,jpg,png,gif',
        'file-internal-do' => 'nullable|mimes:jpeg,jpg,png,gif',
        'file-lmb'         => 'nullable|mimes:jpeg,jpg,png,gif',
      ]);

      // Check validation failure
      if ($validator->fails()) {
        return ['status' => false, 'msg' => $validator->messages()->first()];
      }

      // Generate No. Berita Acara : No.urut/BA-Kode cabang/Bulan/Tahun
      $kode_cabang  = auth()->user()->cabang->short_description;
      $formatNumber = '/BA-' . $kode_cabang . '/' . date('m') . '/' . date('yy');

      $prefix_length = strlen($formatNumber);
      $max_no        = DB::table('clm_berita_acara')
        ->select(DB::raw('berita_acara_no AS max_no'))
        ->orderBy('created_at', 'DESC')
        ->first();
      $max_no        = isset($max_no->max_no) ? $max_no->max_no : 0;
      $max_no        = str_pad(explode("/", $max_no)[0] + 1, 2, 0, STR_PAD_LEFT);
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
          $name                     = uniqid() . '.' . pathinfo($request->file('file-do-manifest')->getClientOriginalName(), PATHINFO_EXTENSION);
          $path                     = Storage::putFileAs('public/do-manifest/files', $request->file('file-do-manifest'), $name);
          $beritaAcara->do_manifest = 'do-manifest/files/' . $name;
        }

        // File Internal DO
        if ($request->hasFile('file-internal-do')) {
          $name                     = uniqid() . '.' . pathinfo($request->file('file-internal-do')->getClientOriginalName(), PATHINFO_EXTENSION);
          $path                     = Storage::putFileAs('public/internal-do/files', $request->file('file-internal-do'), $name);
          $beritaAcara->internal_do = 'internal-do/files/' . $name;
        }

        // File LMB
        if ($request->hasFile('file-lmb')) {
          $name             = uniqid() . '.' . pathinfo($request->file('file-lmb')->getClientOriginalName(), PATHINFO_EXTENSION);
          $path             = Storage::putFileAs('public/lmb/files/', $request->file('file-lmb'), $name);
          $beritaAcara->lmb = 'lmb/files/' . $name;
        }

        $beritaAcara->kode_cabang = auth()->user()->cabang->short_description;

        DB::transaction(function () use (&$beritaAcara) {
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

  public function submit(Request $request, $berita_acara_id)
  {
    $beritaAcara              = BeritaAcara::findOrFail($berita_acara_id);
    $beritaAcara->submit_by   = auth()->user()->id;
    $beritaAcara->submit_date = date('Y-m-d H:i:s');

    $beritaAcara->save();

    return sendSuccess('Berita Acara submited.', $beritaAcara);
  }

  public function prosesDeleteImage(Request $req, $id, $type)
  {
    // proses create
    if ($req->ajax()) {

      try {
        $data = BeritaAcara::whereId($id)->first();
        if (!empty($data->submit_date)) {
          return sendError('Berita acara sudah di submit !');
        }

        DB::transaction(function () use (&$id, &$type, &$data) {
          $data->$type = '';
          $data->save();
        });

        return sendSuccess('Data Successfully Deleted.', []);
      } catch (\Exception $e) {
        return sendError($e->getMessage());
      }
    };
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

      return sendSuccess("Berita acara berhasil dihapus.", $beritaAcara);
    } catch (Exception $e) {
      DB::rollBack();

      return false;
    }
    // return BeritaAcara::destroy($id);
  }

  /**
   * Print.
   *
   * @return \Illuminate\Http\Response
   */
  public function export(Request $request, $id)
  {
    // dd($request->all(), $id, auth()->user());
    $data['beritaAcara']       = BeritaAcara::where('id', $id)->first();
    $data['beritaAcaraDetail'] = BeritaAcaraDetail::where('berita_acara_id', $id)->get();
    $data['detail']            = [
      "branch_manager" => $request->branch_manager,
      "chief_admin" => $request->chief_admin,
      "chief_warehouse" => $request->chief_warehouse,
      "supir" => $request->supir,
      "area" => auth()->user()->area
    ];
    // dd($data);
    $view_print                = view('web.claim.berita-acara._print', $data);

    if ($request->input('filetype') == 'xls') {
      $data['excel'] = 1;
      $view_print    = view('web.claim.berita-acara._print_excel', $data);
    }
    $title = 'berita-acara';

    if ($request->input('filetype') == 'html') {

      // return $view_print;
      // request HTML View
      $mpdf = new \Mpdf\Mpdf([
        'tempDir' => '/tmp',
        'margin_left'                     => 5,
        'margin_right'                    => 5,
        'margin_top'                      => 5,
        'margin_bottom'                   => 5,
        'format'                          => 'A4',
        'orientation'                     => 'L'
      ]);
      $mpdf->shrink_tables_to_fit = 1;
      $mpdf->WriteHTML($view_print);

      $mpdf->Output();
      return;
    } elseif ($request->input('filetype') == 'xls') {

      // Request FILE EXCEL
      $reader      = new \PhpOffice\PhpSpreadsheet\Reader\Html();
      $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

      $spreadsheet = $reader->loadFromString($view_print, $spreadsheet);

      $spreadsheet->getActiveSheet()->getPageMargins()->setTop(0.2);
      $spreadsheet->getActiveSheet()->getPageMargins()->setRight(0.2);
      $spreadsheet->getActiveSheet()->getPageMargins()->setLeft(0.2);
      $spreadsheet->getActiveSheet()->getPageMargins()->setBottom(0.2);
      $spreadsheet->getActiveSheet()->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
      // Set warna background putih
      $spreadsheet->getDefaultStyle()->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('ffffff');
      // Set Font
      $spreadsheet->getDefaultStyle()->getFont()->setName('courier New');

      // Atur lebar kolom
      $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(16);
      $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(10);
      $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(5);
      $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(16);
      $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(16);
      $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(16);
      $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(16);

      $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment; filename="' . $title . '.xls"');

      $writer->save("php://output");
    } else if ($request->input('filetype') == 'pdf') {

      // REQUEST PDF
      $mpdf = new \Mpdf\Mpdf([
        'tempDir'       => '/tmp',
        'margin_left'   => 7,
        'margin_right'  => 12,
        'margin_top'    => 5,
        'margin_bottom' => 5,
        'format'        => 'A4',
      ]);
      $mpdf->shrink_tables_to_fit = 1;
      $mpdf->WriteHTML($view_print);

      $mpdf->Output($title . '.pdf', "D");
      // $mpdf->Output();

    } else {
      // Parameter filetype tidak valid / tidak ditemukan return 404
      return redirect(404);
    }
  }

  public function exportDetail(Request $request, $id)
  {
    // dd($request->all(), $id, auth()->user());
    $data['beritaAcara']       = BeritaAcara::where('id', $id)->first();
    $data['beritaAcaraDetail'] = BeritaAcaraDetail::where('berita_acara_id', $id)->get();
    // dd($data);
    $view_print                = view('web.claim.berita-acara._print_detail', $data);

    if ($request->input('filetype') == 'xls') {
      $data['excel'] = 1;
      $view_print    = view('web.claim.berita-acara._print_detail_excel', $data);
    }
    $title = 'berita-acara-detail';

    if ($request->input('filetype') == 'html') {

      // return $view_print;
      // request HTML View
      $mpdf = new \Mpdf\Mpdf([
        'tempDir' => '/tmp',
        'margin_left'                     => 5,
        'margin_right'                    => 5,
        'margin_top'                      => 5,
        'margin_bottom'                   => 5,
        'format'                          => 'A4',
        // 'orientation'                     => 'L'
      ]);
      $mpdf->shrink_tables_to_fit = 1;
      $mpdf->WriteHTML($view_print);

      $mpdf->Output();
      return;
    } elseif ($request->input('filetype') == 'xls') {

      // Request FILE EXCEL
      $reader      = new \PhpOffice\PhpSpreadsheet\Reader\Html();
      $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

      $spreadsheet = $reader->loadFromString($view_print, $spreadsheet);

      $spreadsheet->getActiveSheet()->getPageMargins()->setTop(0.2);
      $spreadsheet->getActiveSheet()->getPageMargins()->setRight(0.2);
      $spreadsheet->getActiveSheet()->getPageMargins()->setLeft(0.2);
      $spreadsheet->getActiveSheet()->getPageMargins()->setBottom(0.2);
      $spreadsheet->getActiveSheet()->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
      // Set warna background putih
      $spreadsheet->getDefaultStyle()->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('ffffff');
      // Set Font
      $spreadsheet->getDefaultStyle()->getFont()->setName('courier New');

      // Atur lebar kolom
      $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(16);
      $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(16);
      $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(16);
      $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(16);
      $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(16);
      $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(16);
      $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(16);

      $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment; filename="' . $title . '.xls"');

      $writer->save("php://output");
    } else if ($request->input('filetype') == 'pdf') {

      // REQUEST PDF
      $mpdf = new \Mpdf\Mpdf([
        'tempDir'       => '/tmp',
        'margin_left'   => 7,
        'margin_right'  => 12,
        'margin_top'    => 5,
        'margin_bottom' => 5,
        'format'        => 'A4',
      ]);
      $mpdf->shrink_tables_to_fit = 1;
      $mpdf->WriteHTML($view_print);

      $mpdf->Output($title . '.pdf', "D");
      // $mpdf->Output();

    } else {
      // Parameter filetype tidak valid / tidak ditemukan return 404
      return redirect(404);
    }
  }
  // func get template excell
  public function bulkTemplate()
  {
    $view_print = view('web.claim.berita-acara._excel', []);
    $title      = 'template_berita_acara';
    // return $view_print;
    // Request FILE EXCEL
    $reader      = new \PhpOffice\PhpSpreadsheet\Reader\Html();
    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

    $spreadsheet = $reader->loadFromString($view_print, $spreadsheet);

    $spreadsheet->getActiveSheet()->getPageMargins()->setTop(0.2);
    $spreadsheet->getActiveSheet()->getPageMargins()->setRight(0.2);
    $spreadsheet->getActiveSheet()->getPageMargins()->setLeft(0.2);
    $spreadsheet->getActiveSheet()->getPageMargins()->setBottom(0.2);
    $spreadsheet->getActiveSheet()->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);

    // Set Font
    $spreadsheet->getDefaultStyle()->getFont()->setName('courier New');

    // Atur lebar kolom
    $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
    $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
    $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
    $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
    $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
    $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
    $spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);

    $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $title . '.xls"');

    $writer->save("php://output");
  }

  // func get template excell
  public function uploadBulk(Request $req, $id)
  {
    $beritaAcara = BeritaAcara::where('id', $id)->first();

    $spreadsheet   = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $inputFileType = pathinfo($req->file('file-bulk')->getClientOriginalName(), PATHINFO_EXTENSION);
    $inputFileName = $req->file('file-bulk')->getPathName();

    $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($inputFileName);
    $reader->setReadDataOnly(true);
    $spreadsheet = $reader->load($inputFileName);
    $bulk        = $spreadsheet->getActiveSheet()->toArray();
    unset($bulk[0]);

    $model = [];
    $db    = [];
    // dd($bulk);
    // dd($spreadsheet);

    try {
      if (!empty($bulk)) {
        foreach ($bulk as $key => $value) {

          $db[$key]['berita_acara_no'] = $beritaAcara->berita_acara_no;
          $db[$key]['berita_acara_id'] = $beritaAcara->id;
          $db[$key]['do_no']           = $value[1];
          $db[$key]['model_name']      = $value[2];
          $db[$key]['serial_number']   = $value[3];
          $db[$key]['qty']             = $value[4];
          $db[$key]['description']     = $value[5];
          $db[$key]['keterangan']      = $value[6];
          $db[$key]['created_by']      = auth()->user()->id;
          $db[$key]['created_at']      = date('Y-m-d H:i:s');

          if (empty($model[$value[2]])) {
            $masterModel = MasterModel::where('model_name', $value[2])->first();
            if (empty($masterModel)) {
              return sendError('Model ' . $value[2] . ' not found in master model !');
            }
            $model[$value[2]] = $masterModel;
          }
        }

        DB::transaction(function () use (&$db) {
          BeritaAcaraDetail::insert($db);
        });
      }

      return sendSuccess('Bulk Success uploaded.', []);
    } catch (\Exception $e) {
      return sendError($e->getMessage());
    }
  }
}
