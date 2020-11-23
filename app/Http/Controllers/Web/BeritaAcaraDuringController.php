<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\BeritaAcaraDuring;
use App\Models\BeritaAcaraDuringDetail;
use DataTables;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BeritaAcaraDuringController extends Controller
{
  public function index(Request $request)
  {
    if ($request->ajax()) {
      $query = BeritaAcaraDuring::orderBy('created_at', 'DESC')->get();

      $datatables = DataTables::of($query)
        ->addIndexColumn() //DT_RowIndex (Penomoran)
      ;

      return $datatables->make(true);
    };
    return view('web.during.berita-acara-during.index');
  }

  public function detail(Request $request, $id)
  {
    $berita_acara = BeritaAcaraDuring::where('dur_berita_acara.id', $id);

    if (auth()->user()->cabang->hq) {
      $berita_acara->leftJoin('tr_expedition', 'dur_berita_acara.expedition_code', '=', 'tr_expedition.code')
        ->select('dur_berita_acara.*', 'tr_expedition.expedition_name');
    } else {
      $berita_acara->leftJoin('wms_branch_expedition', 'dur_berita_acara.expedition_code', '=', 'wms_branch_expedition.code')
        ->select('dur_berita_acara.*', 'wms_branch_expedition.expedition_name');
    }

    $data['berita_acara'] = $berita_acara->first()->toArray();

    return view('web.during.berita-acara-during.detail', $data);
  }

  public function export(Request $req, $id)
  {
    $berita_acara = BeritaAcaraDuring::where('dur_berita_acara.id', $id);

    if (auth()->user()->cabang->hq) {
      $berita_acara->leftJoin('tr_expedition', 'dur_berita_acara.expedition_code', '=', 'tr_expedition.code')
        ->select('dur_berita_acara.*', 'tr_expedition.expedition_name');
    } else {
      $berita_acara->leftJoin('wms_branch_expedition', 'dur_berita_acara.expedition_code', '=', 'wms_branch_expedition.code')
        ->select('dur_berita_acara.*', 'wms_branch_expedition.expedition_name');
    }

    $data['berita_acara'] = $berita_acara->first();
    $data['detail']       = BeritaAcaraDuringDetail::where('berita_acara_during_id', $id)->get()->toArray();
    $data['request']      = $req;

    $view_print = view('web.during.berita-acara-during._print_BA', $data);
    if ($req->input('filetype') == 'xls') {
      $data['excel'] = 1;
      $view_print    = view('web.during.berita-acara-during._print_BA_excel', $data);
    }
    $title = 'Berita Acara Barang During';

    if ($req->input('filetype') == 'html') {

      // req HTML View
      $mpdf = new \Mpdf\Mpdf([
        'tempDir'       => '/tmp',
        'margin_left'   => 5,
        'margin_right'  => 5,
        'margin_top'    => 5,
        'margin_bottom' => 5,
        'format'        => 'A4',
      ]);
      $mpdf->shrink_tables_to_fit = 1;
      $mpdf->WriteHTML($view_print);

      $mpdf->Output();
      return;
    } elseif ($req->input('filetype') == 'xls') {

      // req FILE EXCEL
      $reader      = new \PhpOffice\PhpSpreadsheet\Reader\Html();
      $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

      $spreadsheet = $reader->loadFromString($view_print, $spreadsheet);

      // Set warna background putih
      $spreadsheet->getDefaultStyle()->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('ffffff');
      // Set Font
      $spreadsheet->getDefaultStyle()->getFont()->setName('courier New');

      // Atur lebar kolom
      $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(15);
      $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(5);
      $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(25);
      $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(10);
      $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(15);
      $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(30);
      $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(30);
      $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(30);

      $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment; filename="' . $title . '.xls"');

      $writer->save("php://output");
    } else if ($req->input('filetype') == 'pdf') {

      // REQUEST PDF
      $mpdf = new \Mpdf\Mpdf(['tempDir' => '/tmp']);

      $mpdf->WriteHTML($view_print, \Mpdf\HTMLParserMode::HTML_BODY);

      $mpdf->Output($title . '.pdf', "D");
    } else {
      // Parameter filetype tidak valid / tidak ditemukan return 404
      return redirect(404);
    }
  }

  public function exportAttach(Request $request, $id)
  {
    $berita_acara = BeritaAcaraDuring::where('dur_berita_acara.id', $id);

    if (auth()->user()->cabang->hq) {
      $berita_acara->leftJoin('tr_expedition', 'dur_berita_acara.expedition_code', '=', 'tr_expedition.code')
        ->select('dur_berita_acara.*', 'tr_expedition.expedition_name');
    } else {
      $berita_acara->leftJoin('wms_branch_expedition', 'dur_berita_acara.expedition_code', '=', 'wms_branch_expedition.code')
        ->select('dur_berita_acara.*', 'wms_branch_expedition.expedition_name');
    }

    $data['berita_acara'] = $berita_acara->first();
    $data['detail']       = BeritaAcaraDuringDetail::where('berita_acara_during_id', $id)->get()->toArray();

    $data['export'] = [];
    $export         = 0;
    foreach ($data['detail'] as $k => $v) {
      if (!isset($data['export'][$export]) || count($data['export'][$export]) >= 2) {
        $export++;
      }
      $data['export'][$export][] = $v;
    }

    $view_print = view('web.during.berita-acara-during._print_attach', $data);
    if ($request->input('filetype') == 'xls') {
      $data['excel'] = 1;
      $view_print    = view('web.during.berita-acara-during._print_attach_excel', $data);
    }
    $title = 'Berita Acara Barang During';

    // dd($data);
    if ($request->input('filetype') == 'html') {

      // req HTML View
      $mpdf = new \Mpdf\Mpdf([
        'tempDir'       => '/tmp',
        'margin_left'   => 5,
        'margin_right'  => 5,
        'margin_top'    => 5,
        'margin_bottom' => 5,
        'format'        => 'A4',
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

      // Set warna background putih
      $spreadsheet->getDefaultStyle()->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('ffffff');
      // Set Font
      $spreadsheet->getDefaultStyle()->getFont()->setName('courier New');

      // Atur lebar kolom
      $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(15);
      $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(15);
      $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(15);
      $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(15);
      $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(25);
      $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(5);
      $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(15);
      $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(15);

      $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment; filename="' . $title . '.xls"');

      $writer->save("php://output");
    } else if ($request->input('filetype') == 'pdf') {

      // REQUEST PDF
      $mpdf = new \Mpdf\Mpdf(['tempDir' => '/tmp']);

      $mpdf->WriteHTML($view_print, \Mpdf\HTMLParserMode::HTML_BODY);

      $mpdf->Output($title . '.pdf', "D");
    } else {
      // Parameter filetype tidak valid / tidak ditemukan return 404
      return redirect(404);
    }
  }

  public function create(Request $req)
  {
    // display create page
    return view('web.during.berita-acara-during.create');
  }

  public function prosesCreate(Request $req)
  {
    // proses create
    if ($req->ajax()) {

      // Generate No. Claim Note :  037/DR-SWD/XII/ 2019
      $format = "%s/DR-" . auth()->user()->area_data->code . "/" . $this->rome((int) date('m')) . "/" . date('Y');

      $max_no = DB::table('dur_berita_acara')
        ->select(DB::raw('berita_acara_during_no AS max_no'))
        ->orderBy('created_at', 'DESC')
        ->first();
      $max_no = isset($max_no->max_no) ? $max_no->max_no : 0;
      $max_no = str_pad(explode("/", $max_no)[0] + 1, 3, 0, STR_PAD_LEFT);
      $no     = sprintf($format, $max_no);

      try {
        $data                         = new BeritaAcaraDuring;
        $data->berita_acara_during_no = $no;
        $data->tanggal_berita_acara   = date('Y-m-d H:i:s');
        $data->tanggal_kejadian       = date_reformat($req->tanggal_kejadian);
        $data->ship_name              = $req->ship_name;
        $data->invoice_no             = $req->invoice_no;
        $data->container_no           = $req->container_no;
        $data->bl_no                  = $req->bl_no;
        $data->seal_no                = $req->seal_no;
        $data->damage_type            = $req->damage_type;
        $data->expedition_code        = $req->expedition_code;
        $data->vehicle_number         = $req->vehicle_number;
        $data->weather                = $req->weather;
        $data->working_hour           = $req->working_hour;
        $data->location               = $req->location;

        if ($req->hasFile('photo_container_came')) {
          $name                       = uniqid() . '.' . pathinfo($req->file('photo_container_came')->getClientOriginalName(), PATHINFO_EXTENSION);
          $path                       = Storage::putFileAs('public/berita-acara-during/files/photo-container-came', $req->file('photo_container_came'), $name);
          $data->photo_container_came = 'berita-acara-during/files/photo-container-came/' . $name;
        }

        if ($req->hasFile('photo_container_loading')) {
          $name                          = uniqid() . '.' . pathinfo($req->file('photo_container_loading')->getClientOriginalName(), PATHINFO_EXTENSION);
          $path                          = Storage::putFileAs('public/berita-acara-during/files/photo-container-loading', $req->file('photo_container_loading'), $name);
          $data->photo_container_loading = 'berita-acara-during/files/photo-container-loading/' . $name;
        }

        if ($req->hasFile('photo_seal_no')) {
          $name                = uniqid() . '.' . pathinfo($req->file('photo_seal_no')->getClientOriginalName(), PATHINFO_EXTENSION);
          $path                = Storage::putFileAs('public/berita-acara-during/files/photo-seal-no', $req->file('photo_seal_no'), $name);
          $data->photo_seal_no = 'berita-acara-during/files/photo-seal-no/' . $name;
        }

        if ($req->hasFile('photo_loading')) {
          $name                = uniqid() . '.' . pathinfo($req->file('photo_loading')->getClientOriginalName(), PATHINFO_EXTENSION);
          $path                = Storage::putFileAs('public/berita-acara-during/files/photo-loading', $req->file('photo_loading'), $name);
          $data->photo_loading = 'berita-acara-during/files/photo-loading/' . $name;
        }

        $data->created_at = date('Y-m-d H:i:s');
        $data->created_by = auth()->user()->id;

        DB::transaction(function () use (&$data) {
          $data->save();
        });

        if (auth()->user()->cabang->hq) {
          $return_data = BeritaAcaraDuring::where('dur_berita_acara.id', $data->id)
            ->leftJoin('tr_expedition', 'tr_expedition.code', '=', 'dur_berita_acara.expedition_code')
            ->select(
              'dur_berita_acara.*',
              'tr_expedition.expedition_name'
            )
            ->first();
        } else {
          $return_data = BeritaAcaraDuring::where('dur_berita_acara.id', $data->id)
            ->leftJoin('wms_branch_expedition', 'wms_branch_expedition.code', '=', 'dur_berita_acara.expedition_code')
            ->select(
              'dur_berita_acara.*',
              'wms_branch_expedition.expedition_name'
            )
            ->first();
        }

        return sendSuccess('Data Successfully Created.', [
          'during' => $return_data,
        ]);
      } catch (\Exception $e) {
        return sendError($e->getMessage());
      }
    };
  }

  public function prosesUpdate(Request $req)
  {
    // proses create
    if ($req->ajax()) {

      try {
        $data = BeritaAcaraDuring::whereId($req->berita_acara_id)->first();

        $data->tanggal_kejadian = date_reformat($req->tanggal_kejadian);
        $data->ship_name        = $req->ship_name;
        $data->invoice_no       = $req->invoice_no;
        $data->container_no     = $req->container_no;
        $data->bl_no            = $req->bl_no;
        $data->seal_no          = $req->seal_no;
        $data->damage_type      = $req->damage_type;
        $data->expedition_code  = $req->expedition_code;
        $data->vehicle_number   = $req->vehicle_number;
        $data->weather          = $req->weather;
        $data->working_hour     = $req->working_hour;
        $data->location         = $req->location;

        if ($req->hasFile('photo_container_came')) {
          $name                       = uniqid() . '.' . pathinfo($req->file('photo_container_came')->getClientOriginalName(), PATHINFO_EXTENSION);
          $path                       = Storage::putFileAs('public/berita-acara-during/files/photo-container-came', $req->file('photo_container_came'), $name);
          $data->photo_container_came = 'berita-acara-during/files/photo-container-came/' . $name;
        }

        if ($req->hasFile('photo_container_loading')) {
          $name                          = uniqid() . '.' . pathinfo($req->file('photo_container_loading')->getClientOriginalName(), PATHINFO_EXTENSION);
          $path                          = Storage::putFileAs('public/berita-acara-during/files/photo-container-loading', $req->file('photo_container_loading'), $name);
          $data->photo_container_loading = 'berita-acara-during/files/photo-container-loading/' . $name;
        }

        if ($req->hasFile('photo_seal_no')) {
          $name                = uniqid() . '.' . pathinfo($req->file('photo_seal_no')->getClientOriginalName(), PATHINFO_EXTENSION);
          $path                = Storage::putFileAs('public/berita-acara-during/files/photo-seal-no', $req->file('photo_seal_no'), $name);
          $data->photo_seal_no = 'berita-acara-during/files/photo-seal-no/' . $name;
        }

        if ($req->hasFile('photo_loading')) {
          $name                = uniqid() . '.' . pathinfo($req->file('photo_loading')->getClientOriginalName(), PATHINFO_EXTENSION);
          $path                = Storage::putFileAs('public/berita-acara-during/files/photo-loading', $req->file('photo_loading'), $name);
          $data->photo_loading = 'berita-acara-during/files/photo-loading/' . $name;
        }

        $data->updated_at = date('Y-m-d H:i:s');
        $data->updated_by = auth()->user()->id;

        DB::transaction(function () use (&$data) {
          $data->save();
        });

        if (auth()->user()->cabang->hq) {
          $return_data = BeritaAcaraDuring::where('dur_berita_acara.id', $data->id)
            ->leftJoin('tr_expedition', 'tr_expedition.code', '=', 'dur_berita_acara.expedition_code')
            ->select(
              'dur_berita_acara.*',
              'tr_expedition.expedition_name'
            )
            ->first();
        } else {
          $return_data = BeritaAcaraDuring::where('dur_berita_acara.id', $data->id)
            ->leftJoin('wms_branch_expedition', 'wms_branch_expedition.code', '=', 'dur_berita_acara.expedition_code')
            ->select(
              'dur_berita_acara.*',
              'wms_branch_expedition.expedition_name'
            )
            ->first();
        }

        return sendSuccess('Data Successfully Updated.', [
          'during' => $return_data,
        ]);
      } catch (\Exception $e) {
        return sendError($e->getMessage());
      }
    };
  }

  public function prosesDelete(Request $req, $id)
  {
    // proses create
    if ($req->ajax()) {

      try {
        DB::transaction(function () use (&$id) {
          BeritaAcaraDuringDetail::where('berita_acara_during_id', $id)->delete();
          BeritaAcaraDuring::whereId($id)->delete();
        });

        return sendSuccess('Data Successfully Deleted.', []);
      } catch (\Exception $e) {
        return sendError($e->getMessage());
      }
    };
  }

  public function prosesDeleteImage(Request $req, $id, $type)
  {
    // proses create
    if ($req->ajax()) {

      try {
        $data = BeritaAcaraDuring::whereId($id)->first();
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

  public function prosesCreateDetail(Request $req, $id)
  {
    // proses create
    if ($req->ajax()) {

      try {
        $data                         = new BeritaAcaraDuringDetail;
        $data->berita_acara_during_id = $id;
        $data->model_name             = $req->model_name;
        $data->qty                    = $req->qty;
        $data->pom                    = $req->pom;
        $data->serial_number          = $req->serial_number;
        $data->damage                 = $req->damage;

        if ($req->hasFile('photo_serial_number')) {
          $name                      = uniqid() . '.' . pathinfo($req->file('photo_serial_number')->getClientOriginalName(), PATHINFO_EXTENSION);
          $path                      = Storage::putFileAs('public/berita-acara-during/files/photo-serial-number', $req->file('photo_serial_number'), $name);
          $data->photo_serial_number = 'berita-acara-during/files/photo-serial-number/' . $name;
        }

        if ($req->hasFile('photo_damage')) {
          $name               = uniqid() . '.' . pathinfo($req->file('photo_damage')->getClientOriginalName(), PATHINFO_EXTENSION);
          $path               = Storage::putFileAs('public/berita-acara-during/files/photo-damage', $req->file('photo_damage'), $name);
          $data->photo_damage = 'berita-acara-during/files/photo-damage/' . $name;
        }

        $data->created_at = date('Y-m-d H:i:s');
        $data->created_by = auth()->user()->id;

        DB::transaction(function () use (&$data) {
          $data->save();
        });

        return sendSuccess('Data Successfully Created.', []);
      } catch (\Exception $e) {
        return sendError($e->getMessage());
      }
    };
  }

  public function rome($number)
  {
    $map         = array('M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1);
    $returnValue = '';
    while ($number > 0) {
      foreach ($map as $roman => $int) {
        if ($number >= $int) {
          $number -= $int;
          $returnValue .= $roman;
          break;
        }
      }
    }
    return $returnValue;
  }

  public function submit(Request $request, $id)
  {
    $beritaAcara              = BeritaAcaraDuring::findOrFail($id);
    $beritaAcara->submit_by   = auth()->user()->id;
    $beritaAcara->submit_date = date('Y-m-d H:i:s');

    $beritaAcara->save();

    return sendSuccess('Berita Acara submited.', $beritaAcara);
  }
}
