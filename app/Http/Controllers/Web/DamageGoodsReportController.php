<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\BeritaAcaraDuringDetail;
use App\Models\DamageGoodsReport;
use App\Models\DamageGoodsReportDetail;
use Illuminate\Http\Request;
use DataTables;
use DB;

class DamageGoodsReportController extends Controller
{
  public function index(Request $request)
  {
    return view('web.during.damage-goods-report.index');
  }

  // DataTable Outstanding Index
  public function listOutstanding(Request $request)
  {
    if ($request->ajax()) {
      $query = BeritaAcaraDuringDetail::select(
        'dur_berita_acara_detail.*',
        'dur_berita_acara.expedition_code',
        'dur_berita_acara.vehicle_number',
        'tr_expedition.expedition_name',
        'dur_berita_acara.berita_acara_during_no',
        'dur_berita_acara.invoice_no',
        'dur_berita_acara.bl_no',
        'dur_berita_acara.container_no'
      )
        ->leftJoin('dur_berita_acara', 'dur_berita_acara.id', '=', 'dur_berita_acara_detail.berita_acara_during_id')
        ->leftJoin('dur_dgr_detail', 'dur_dgr_detail.berita_acara_during_detail_id', '=', 'dur_berita_acara_detail.id')
        ->leftjoin('tr_expedition', 'tr_expedition.code', '=', 'dur_berita_acara.expedition_code')
        ->whereNotNull('dur_berita_acara.submit_date')
        ->whereNull('dur_dgr_detail.id')
        ->orderBy('created_at', 'DESC')
        ->get();

      $datatables = DataTables::of($query)
        ->addIndexColumn(); //DT_RowIndex (Penomoran)

      return $datatables->make(true);
    }
  }

  // DataTable claim note Index
  public function listDGR(Request $request)
  {
    if ($request->ajax()) {
      $query = DamageGoodsReport::from('dur_dgr AS d')
        ->leftJoin('dur_dgr_detail AS dd', 'dd.dur_dgr_id', '=', 'd.id')
        ->leftJoin('dur_berita_acara_detail AS bad', 'bad.id', '=', 'dd.berita_acara_during_detail_id')
        ->leftJoin('dur_berita_acara AS ba', 'bad.berita_acara_during_id', '=', 'ba.id')
        ->leftJoin('tr_expedition AS e', 'e.code', '=', 'ba.expedition_code')
        ->orderBy('d.created_at', 'DESC')
        // ->groupBy('d.id')
        ->groupBy('d.id')
        ->select(
          'd.*',
          DB::raw("group_concat(DISTINCT ba.berita_acara_during_no SEPARATOR ', ') as berita_acara_group"),
          DB::raw("group_concat(DISTINCT e.expedition_name SEPARATOR '|') as expedition_name"),
          DB::raw("group_concat(DISTINCT dd.remark SEPARATOR '|') as remark")
        );

      $datatables = DataTables::of($query)
        ->addIndexColumn(); //DT_RowIndex (Penomoran)

      return $datatables->make(true);
    }
  }

  public function export(Request $request, $id)
  {
    $data['dgr'] = DamageGoodsReport::whereId($id)->first()->toArray();
    $data['detail'] = DamageGoodsReportDetail::where('dur_dgr_detail.dur_dgr_id', $id)
      ->leftJoin('dur_berita_acara_detail as bad', 'bad.id', '=', 'dur_dgr_detail.berita_acara_during_detail_id')
      ->leftJoin('dur_berita_acara as ba', 'ba.id', '=', 'bad.berita_acara_during_id')
      ->select(
        //during_detail
        'dur_dgr_detail.*',
        // berita_acara detail
        'berita_acara_during_id',
        'model_name',
        'bad.qty as ba_qty',
        'pom',
        'serial_number',
        'damage',
        'photo_serial_number',
        'photo_damage',
        // berita acara
        'berita_acara_during_no',
        'tanggal_berita_acara',
        'tanggal_kejadian',
        'ship_name',
        'invoice_no',
        'container_no',
        'bl_no',
        'seal_no',
        'damage_type',
        'expedition_code',
        'vehicle_number',
        'weather',
        'working_hour',
        'location',
        'photo_container_came',
        'photo_container_loading',
        'photo_seal_no',
        'photo_loading',
        'submit_by',
        'submit_date'
      )
      ->orderBy('dur_dgr_detail.berita_acara_during_detail_id')
      ->get()->toArray();

    $rowspan = 1;
    foreach ($data['detail'] as $k => $v) {
      if ($k > 0 && $data['detail'][$k]['berita_acara_during_no'] == $data['detail'][$k - 1]['berita_acara_during_no']) {
        $rowspan++;
      } else {
        $rowspan = 1;
      }
      $data['detail'][$k]['rowspan'] = $rowspan;
    };

    for ($i = 0; $i < count($data['detail']) - 1; $i++) {
      $tmp = [];
      // dd($data['detail'][$i]['rowspan'], $data['detail'][$i + 1]['rowspan']);
      if ($data['detail'][$i]['rowspan'] < $data['detail'][$i + 1]['rowspan'] && $data['detail'][$i]['berita_acara_during_no'] == $data['detail'][$i + 1]['berita_acara_during_no']) {
        $tmp = $data['detail'][$i];
        $data['detail'][$i] = $data['detail'][$i + 1];
        $data['detail'][$i + 1] = $tmp;
      }
    };
    $view_print = view('web.during.damage-goods-report._print', $data);
    $title      = 'Damage Goods Report';

    if ($request->input('filetype') == 'html') {

      // request HTML View
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

      $view_print = view('web.during.damage-goods-report._print_excel', $data);
      // Request FILE EXCEL
      $reader      = new \PhpOffice\PhpSpreadsheet\Reader\Html();
      $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

      $spreadsheet = $reader->loadFromString($view_print, $spreadsheet);

      // Set warna background putih
      $spreadsheet->getDefaultStyle()->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('ffffff');
      // Set Font
      $spreadsheet->getDefaultStyle()->getFont()->setName('courier New');

      $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment; filename="' . $title . '.xls"');

      $writer->save("php://output");
    } else if ($request->input('filetype') == 'pdf') {

      // REQUEST PDF
      $mpdf = new \Mpdf\Mpdf([
        'tempDir' => '/tmp',
        'margin_left'                     => 5,
        'margin_right'                    => 5,
        'margin_top'                      => 5,
        'margin_bottom'                   => 5,
        'format'                          => 'A4',
        'orientation'                     => 'L'
      ]);
      $mpdf->WriteHTML($view_print, \Mpdf\HTMLParserMode::HTML_BODY);

      $mpdf->Output($title . '.pdf', "D");
    } else {
      // Parameter filetype tidak valid / tidak ditemukan return 404
      return redirect(404);
    }
  }

  public function exportDetail(Request $request, $id)
  {
    $data['detail'] = DamageGoodsReportDetail::where('dur_dgr_detail.dur_dgr_id', $id)
      ->leftJoin('dur_dgr as d', 'd.id', '=', 'dur_dgr_detail.dur_dgr_id')
      ->leftJoin('dur_berita_acara_detail as bad', 'bad.id', '=', 'dur_dgr_detail.berita_acara_during_detail_id')
      ->leftJoin('dur_berita_acara as ba', 'ba.id', '=', 'bad.berita_acara_during_id')
      ->leftJoin('tr_expedition AS e', 'e.code', '=', 'ba.expedition_code')
      ->select(
        'd.dgr_no',
        'd.claim',
        //dgr_detail
        'dur_dgr_detail.*',
        // berita_acara detail
        'berita_acara_during_id',
        'model_name',
        'bad.qty as ba_qty',
        'pom',
        'serial_number',
        'damage',
        'photo_serial_number',
        'photo_damage',
        // berita acara
        'berita_acara_during_no',
        'tanggal_berita_acara',
        'tanggal_kejadian',
        'ship_name',
        'invoice_no',
        'container_no',
        'bl_no',
        'seal_no',
        'damage_type',
        'expedition_code',
        'vehicle_number',
        'weather',
        'working_hour',
        'ba.location',
        'photo_container_came',
        'photo_container_loading',
        'photo_seal_no',
        'photo_loading',
        'submit_by',
        'submit_date',
        'expedition_name'
      )
      ->orderBy('dur_dgr_detail.berita_acara_during_detail_id')
      ->get()->toArray();

    $rowspan = 1;
    foreach ($data['detail'] as $k => $v) {
      if ($k > 0 && $data['detail'][$k]['berita_acara_during_no'] == $data['detail'][$k - 1]['berita_acara_during_no']) {
        $rowspan++;
      } else {
        $rowspan = 1;
      }
      $data['detail'][$k]['rowspan'] = $rowspan;
    };

    for ($i = 0; $i < count($data['detail']) - 1; $i++) {
      $tmp = [];
      // dd($data['detail'][$i]['rowspan'], $data['detail'][$i + 1]['rowspan']);
      if ($data['detail'][$i]['rowspan'] < $data['detail'][$i + 1]['rowspan'] && $data['detail'][$i]['berita_acara_during_no'] == $data['detail'][$i + 1]['berita_acara_during_no']) {
        $tmp = $data['detail'][$i];
        $data['detail'][$i] = $data['detail'][$i + 1];
        $data['detail'][$i + 1] = $tmp;
      }
    };

    $view_print = view('web.during.damage-goods-report._print_detail', $data);
    $title      = 'Damage Goods Report Detail';

    if ($request->input('filetype') == 'html') {

      // request HTML View
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

      // Set warna background putih
      $spreadsheet->getDefaultStyle()->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('ffffff');
      // Set Font
      $spreadsheet->getDefaultStyle()->getFont()->setName('courier New');

      $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment; filename="' . $title . '.xls"');

      $writer->save("php://output");
    } else if ($request->input('filetype') == 'pdf') {

      // REQUEST PDF
      $mpdf = new \Mpdf\Mpdf([
        'tempDir' => '/tmp',
        'margin_left'                     => 5,
        'margin_right'                    => 5,
        'margin_top'                      => 5,
        'margin_bottom'                   => 5,
        'format'                          => 'A4',
        'orientation'                     => 'L'
      ]);
      $mpdf->WriteHTML($view_print, \Mpdf\HTMLParserMode::HTML_BODY);

      $mpdf->Output($title . '.pdf', "D");
    } else {
      // Parameter filetype tidak valid / tidak ditemukan return 404
      return redirect(404);
    }
  }

  public function create(Request $req)
  {
    if ($req->ajax()) {
      // parsing from string to array
      $data = json_decode($req->data, true);
      // unset length
      unset($data['length']);

      try {
        if (!empty($data)) {
          $beritaAcaraDetail = [];

          // set key of array claim note to berita acara id
          foreach ($data as $kb => $vb) {
            $beritaAcaraDetail[$vb['berita_acara_during_detail_id']] = $vb;
          }
          // unset berita acara id from array claim note for parsing
          foreach ($beritaAcaraDetail as $kc => $vc) {
            // unset berita_acara_during_detail_id not used in table dur_dgr
            unset($beritaAcaraDetail[$kc]['berita_acara_during_detail_id']);
          }

          DB::transaction(function () use (&$beritaAcaraDetail, &$req) {

            // Generate No. dgr :  001/DR -HQ-XII/2019
            $format = "%s/DR -HQ-" . $this->rome((int) date('m')) . "/" . date('Y');

            $max_no = DB::table('dur_dgr')
              ->select(DB::raw('dgr_no AS max_no'))
              ->orderBy('created_at', 'DESC')
              ->first();
            $max_no = isset($max_no->max_no) ? $max_no->max_no : 0;

            // adding during note number
            $max_no        = str_pad(explode("/", $max_no)[0] + 1, 2, 0, STR_PAD_LEFT);
            $dgr_no = sprintf($format, $max_no);

            // insert to during note and return id
            $dgrID = DamageGoodsReport::insertGetId([
              'dgr_no'        => $dgr_no,
              'claim'         => $req->type,
              'created_by'    => auth()->user()->id,
              'created_at'    => date('Y-m-d H:i:s'),
            ]);

            $rsDetailDuring = [];
            foreach ($beritaAcaraDetail as $key => $value) {
              // insert into during note detail
              $detailDuring = [
                'berita_acara_during_detail_id' => $key,
                'dur_dgr_id'                    => $dgrID,
                'description'            => $value['description'],
                'qty'                    => $value['qty'],
                'created_by'             => auth()->user()->id,
                'created_at'             => date('Y-m-d H:i:s'),
              ];
              $rsDetailDuring[] = $detailDuring;
            }

            if (!empty($rsDetailDuring)) {
              DamageGoodsReportDetail::insert($rsDetailDuring);
            }
          });
        }

        return sendSuccess('Data Successfully Created.', []);
      } catch (\Exception $e) {
        return sendError($e->getMessage());
      }
    }
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
}
