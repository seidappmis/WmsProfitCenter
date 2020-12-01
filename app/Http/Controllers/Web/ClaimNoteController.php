<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\BeritaAcara;
use App\Models\BeritaAcaraDetail;
use App\Models\ClaimNote;
use App\Models\ClaimNoteDetail;
use App\Models\MasterModel;
use DataTables;
use DB;
use Illuminate\Http\Request;

class ClaimNoteController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    // return  view('web.claim.claim-notes._print');
    return view('web.claim.claim-notes.index');
  }

  // DataTable Outstanding Index
  public function listOutstanding(Request $request)
  {
    if ($request->ajax()) {
      $query = BeritaAcaraDetail::select(
        'clm_berita_acara_detail.*',
        'clm_berita_acara.expedition_code',
        'clm_berita_acara.vehicle_number',
        'clm_berita_acara.date_of_receipt',
        'clm_berita_acara.driver_name',
        'clm_berita_acara.submit_by',
        'clm_berita_acara.submit_date'
      )
        ->leftJoin('clm_berita_acara', 'clm_berita_acara.id', '=', 'clm_berita_acara_detail.berita_acara_id')
        ->leftJoin('clm_claim_note_detail', 'clm_claim_note_detail.berita_acara_detail_id', '=', 'clm_berita_acara_detail.id')
        ->whereNotNull('clm_berita_acara.submit_date')
        ->whereNull('clm_claim_note_detail.id')
        // ->whereNull('claim_note_detail_id')
        ->orderBy('created_at', 'DESC')
        ->get();

      $datatables = DataTables::of($query)
        ->addIndexColumn(); //DT_RowIndex (Penomoran)

      return $datatables->make(true);
    }
  }

  // DataTable claim note Index
  public function listClaimNotes(Request $request)
  {
    if ($request->ajax()) {
      $query = ClaimNote::from('clm_claim_notes AS n')
        ->leftJoin('clm_claim_note_detail AS nd', 'nd.claim_note_id', '=', 'n.id')
        ->leftJoin('clm_berita_acara_detail AS bad', 'bad.id', '=', 'nd.berita_acara_detail_id')
        ->leftJoin('clm_berita_acara AS ba', 'bad.berita_acara_id', '=', 'ba.id')
        ->leftJoin('tr_expedition AS e', 'e.code', '=', 'ba.expedition_code')
        ->orderBy('n.created_at', 'DESC')
        // ->groupBy('n.id')
        ->groupBy('n.id')
        ->select(
          'n.*',
          DB::raw("group_concat(DISTINCT bad.berita_acara_no SEPARATOR ', ') as berita_acara_group"),
          DB::raw("group_concat(DISTINCT e.expedition_name SEPARATOR ', ') as expedition_name"),
          // 'e.expedition_name',
          'ba.date_of_receipt',
          'nd.destination'
        );

      $datatables = DataTables::of($query)
        ->addIndexColumn(); //DT_RowIndex (Penomoran)

      return $datatables->make(true);
    }
  }

  // DataTable Claim Note Carton Box Indez
  public function listCartonBox(Request $request)
  {
    if ($request->ajax()) {
      $query = ClaimNote::all();

      $datatables = DataTables::of($query)
        ->addIndexColumn() //DT_RowIndex (Penomoran)
        ->addColumn('action', function ($data) {
          $action = '';
          $action .= ' ' . get_button_view('#');
          $action .= ' ' . get_button_print();
          $action .= ' ' . get_button_delete();
          return $action;
        });

      return $datatables->make(true);
    }
  }

  // DataTables Claim Note Unit Index
  public function listUnit(Request $request)
  {
    if ($request->ajax()) {
      $query = ClaimNote::all();

      $datatables = DataTables::of($query)
        ->addIndexColumn() //DT_RowIndex (Penomoran)
        ->addColumn('action', function ($data) {
          $action = '';
          $action .= ' ' . get_button_view('#');
          $action .= ' ' . get_button_print();
          $action .= ' ' . get_button_delete();
          return $action;
        });

      return $datatables->make(true);
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
            $beritaAcaraDetail[$vb['berita_acara_detail_id']] = $vb;
          }
          // unset berita acara id from array claim note for parsing
          foreach ($beritaAcaraDetail as $kc => $vc) {
            // unset berita_acara_detail_id not used in table clm_claim_note
            unset($beritaAcaraDetail[$kc]['berita_acara_detail_id']);
          }

          $rsModels = [];

          DB::transaction(function () use (&$beritaAcaraDetail, &$req) {

            // Generate No. Claim Note :  01/Claim U-Log/Des/2019
            $format = "%s/Claim %s-log/" . date('M') . "/" . date('Y');

            $max_no = DB::table('clm_claim_notes')
              ->select(DB::raw('claim_note_no AS max_no'))
              ->orderBy('created_at', 'DESC')
              ->first();
            $max_no = isset($max_no->max_no) ? $max_no->max_no : 0;

            // adding claim note number
            $type          = ($req->type == 'carton-box') ? 'C' : 'U';
            $max_no        = str_pad(explode("/", $max_no)[0] + 1, 2, 0, STR_PAD_LEFT);
            $claim_note_no = sprintf($format, $max_no, $type);

            // insert to claim note and return id
            $claimNoteID = ClaimNote::insertGetId([
              'claim_note_no' => $claim_note_no,
              'claim'         => $req->type,
              'created_by'    => auth()->user()->id,
              'created_at'    => date('Y-m-d H:i:s'),
            ]);

            $rsDetailClaim = [];
            foreach ($beritaAcaraDetail as $key => $value) {
              // insert into claim note detail
              $detailClaim = [
                'claim_note_id'          => $claimNoteID,
                'berita_acara_detail_id' => $key,
                'date_of_receipt'        => $value['date_of_receipt'],
                'expedition_code'        => $value['expedition_code'],
                'driver_name'            => $value['driver_name'],
                'vehicle_number'         => $value['vehicle_number'],
                'do_no'                  => $value['do_no'],
                'model_name'             => $value['model_name'],
                'serial_number'          => $value['serial_number'],
                'qty'                    => $value['qty'],
                'description'            => $value['description'],
                'created_by'             => auth()->user()->id,
                'created_at'             => date('Y-m-d H:i:s'),
              ];

              if (($req->type == 'carton-box')) {
                if (empty($rsModels[$detailClaim['model_name']])) {
                  $model = MasterModel::where('model_name', $detailClaim['model_name'])->first();

                  $rsModels[$detailClaim['model_name']] = $model;
                }

                $detailClaim['price'] = $rsModels[$detailClaim['model_name']]->price_carton_box;
              }

              $rsDetailClaim[] = $detailClaim;
            }

            if (!empty($rsDetailClaim)) {
              ClaimNoteDetail::insert($rsDetailClaim);
            }
          });
        }

        return sendSuccess('Data Successfully Created.', []);
      } catch (\Exception $e) {
        return sendError($e->getMessage());
      }
    }
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function createCartonBox(Request $request)
  {
    if ($request->ajax()) {
      $query = BeritaAcara::select('clm_berita_acara.*', 'clm_berita_acara_detail.do_no', 'clm_berita_acara_detail.model_name', 'clm_berita_acara_detail.serial_number', 'clm_berita_acara_detail.qty', 'clm_berita_acara_detail.description', 'tr_expedition.expedition_name', 'tr_vehicle_expedition.destination')
        ->leftjoin('clm_berita_acara_detail', 'clm_berita_acara_detail.berita_acara_id', '=', 'clm_berita_acara.id')
        ->leftjoin('tr_expedition', 'tr_expedition.code', '=', 'clm_berita_acara.expedition_code')
        ->leftjoin('tr_vehicle_expedition', 'tr_vehicle_expedition.vehicle_number', '=', 'clm_berita_acara.vehicle_number');

      $datatables = DataTables::of($query)
        ->addIndexColumn() //DT_RowIndex (Penomoran)
        ->addColumn('location', function ($data) {
          $location = $data->kode_cabang == null || 'HQ' ? 'WH Return' : 'WH Branch';
          return $location;
        })
        ->addColumn('total', function ($data) {
          $total = 'total price test';
          return $total;
        })
        ->addColumn('action', function ($data) {
          $action = '';
          $action .= ' ' . get_button_view('#', 'Select', 'btn-select');
          return $action;
        });

      return $datatables->make(true);
    }
    return view('web.claim.claim-notes.create-carton-box');
  }

  public function createUnit(Request $request)
  {
    if ($request->ajax()) {
      $query = BeritaAcara::all();

      $datatables = DataTables::of($query)
        ->addIndexColumn() //DT_RowIndex (Penomoran)
        ->addColumn('action', function ($data) {
          $action = '';
          $action .= ' ' . get_button_view('#', 'Select');
          return $action;
        });

      return $datatables->make(true);
    }
    return view('web.claim.claim-notes.create-unit');
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
    $data['claimNote'] = ClaimNote::where('id', $id)->first();
    return view('web.claim.claim-notes.view', $data);
  }

  // DataTable claim note detail
  public function listDetailClaimNotes(Request $request, $id)
  {
    if ($request->ajax()) {
      $query = ClaimNote::from('clm_claim_notes AS n')
        ->leftJoin('clm_claim_note_detail AS nd', 'nd.claim_note_id', '=', 'n.id')
        ->leftJoin('clm_berita_acara_detail AS bad', 'bad.id', '=', 'nd.berita_acara_detail_id')
        ->leftJoin('clm_berita_acara AS ba', 'bad.berita_acara_id', '=', 'ba.id')
        ->leftJoin('tr_expedition AS e', 'e.code', '=', 'ba.expedition_code')
        ->leftJoin('wms_master_model AS m', 'm.model_name', '=', 'nd.model_name')
        ->orderBy('n.created_at', 'DESC')
        ->where('n.id', $id)
        ->select(
          'n.*',
          'e.expedition_name',
          'ba.date_of_receipt',
          'ba.berita_acara_no',
          'nd.destination',
          DB::raw('nd.location AS warehouse'),
          'nd.driver_name',
          'nd.vehicle_number',
          'nd.do_no',
          'nd.model_name',
          'nd.serial_number',
          'nd.description',
          'nd.reason',
          'nd.qty',
          'nd.price',
          'nd.id AS claim_note_detail',
          'bad.photo_url',
          'm.price_carton_box'
        );

      $datatables = DataTables::of($query)
        ->addIndexColumn(); //DT_RowIndex (Penomoran)

      return $datatables->make(true);
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

  public function submit(Request $request, $id)
  {
    $claimNote              = ClaimNote::findOrFail($id);
    $claimNote->submit_by   = auth()->user()->id;
    $claimNote->submit_date = date('Y-m-d H:i:s');

    $claimNote->save();

    return sendSuccess('Berita Acara submited.', $claimNote);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $req, $id)
  {
    if ($req->ajax()) {
      // parsing from string to array
      $data = json_decode($req->data, true);

      try {
        if (!empty($data)) {

          DB::transaction(function () use (&$data, &$id) {

            ClaimNote::whereId($id)->update([
              'updated_by' => auth()->user()->id,
              'updated_at' => date('Y-m-d H:i:s'),
            ]);

            foreach ($data as $key => $value) {
              // update berita acara detail _> claim note id from before
              $value['updated_by'] = auth()->user()->id;
              $value['updated_at'] = date('Y-m-d H:i:s');

              ClaimNoteDetail::whereId($key)->update($value);
            }
          });
        }

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
  public function destroy($id)
  {
    try {
      DB::beginTransaction();

      $claimNote = ClaimNote::findOrFail($id);
      $claimNote->details()->delete();
      $claimNote->delete();

      DB::commit();

      return sendSuccess("Berita acara berhasil dihapus.", $claimNote);
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
    $claimNoteSubQuery = ClaimNoteDetail::where('claim_note_id', $id)
      ->select(
        'claim_note_id',
        DB::raw("sum(1) as unit"),
        DB::raw("GROUP_CONCAT(DISTINCT reason SEPARATOR ',') AS reasons"),
        DB::raw("sum(qty) as sum_qty"),
        DB::raw("IF(clm_claim_notes.claim = 'unit', sum(price * 110 / 100), sum(price)) as sum_price"),
        DB::raw("sum(IF(clm_claim_notes.claim = 'unit', price * 110 / 100 , price) * qty) as sub_total")
      )
      ->leftJoin('clm_claim_notes', 'clm_claim_notes.id', '=', 'clm_claim_note_detail.claim_note_id');
    $claimNoteSubQuery2 = ClaimNoteDetail::where('claim_note_id', $id)
      ->select(
        'claim_note_id',
        'berita_acara_detail_id'
      )->limit(1);

    $data['claimNote'] = ClaimNote::from('clm_claim_notes AS n')
      ->joinSub($claimNoteSubQuery, 'nd', function ($join) {
        $join->on('n.id', '=', 'nd.claim_note_id');
      })
      ->joinSub($claimNoteSubQuery2, 'nds', function ($join) {
        $join->on('n.id', '=', 'nds.claim_note_id');
      })
      ->leftJoin('clm_claim_note_detail AS nd', 'nds.claim_note_id', '=', 'n.id')
      ->leftJoin('clm_berita_acara_detail AS bad', 'bad.id', '=', 'nds.berita_acara_detail_id')
      ->leftJoin('clm_berita_acara AS ba', 'bad.berita_acara_id', '=', 'ba.id')
      ->leftJoin('tr_expedition AS e', 'e.code', '=', 'ba.expedition_code')
      ->select(
        'n.*',
        'nd.*',
        'e.expedition_name',
        'ba.expedition_code'
      )
      ->where('n.id', $id)
      ->first();

    $data['claimNoteDetail'] = ClaimNoteDetail::select(
      'clm_claim_note_detail.*',
      DB::raw('tr_expedition.expedition_name AS expedition_name')
    )->leftJoin(
      'tr_expedition',
      'tr_expedition.code',
      '=',
      'clm_claim_note_detail.expedition_code'
    )
      ->where('clm_claim_note_detail.claim_note_id', $id)
      ->get();

    $data['request']  = $request;
    $data['rs_reasons']  = explode(',', $data['claimNote']->reasons);

    // dd($data);
    // echo "<pre>";
    // print_r($data['rs_reasons']); exit;
    $view_print = view('web.claim.claim-notes._print', $data);

    $title = 'claim_letter';

    if ($request->input('filetype') == 'html') {

      // return $view_print;
      // request HTML View
      $mpdf = new \Mpdf\Mpdf([
        'tempDir'       => '/tmp',
        'margin_left'   => 3,
        'margin_right'  => 3,
        'margin_top'    => 4,
        'margin_bottom' => 4,
        'format'        => 'A4',
      ]);
      $mpdf->shrink_tables_to_fit = 1;
      $mpdf->WriteHTML($view_print);

      $mpdf->Output();
      return;
    } else if ($request->input('filetype') == 'xls') {

      // Request FILE EXCEL
      $reader      = new \PhpOffice\PhpSpreadsheet\Reader\Html();
      $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

      $spreadsheet = $reader->loadFromString($view_print, $spreadsheet);

      // $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
      // $drawing->setPath('images/sharp-logo.png'); // put your path and image here
      // $drawing->setCoordinates('A1');
      // $drawing->getShadow()->setVisible(true);
      // $drawing->setWorksheet($spreadsheet->getActiveSheet());

      $spreadsheet->getActiveSheet()->getPageMargins()->setTop(0.2);
      $spreadsheet->getActiveSheet()->getPageMargins()->setRight(0.2);
      $spreadsheet->getActiveSheet()->getPageMargins()->setLeft(0.2);
      $spreadsheet->getActiveSheet()->getPageMargins()->setBottom(0.2);
      $spreadsheet->getActiveSheet()->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
      // // Set warna background putih
      $spreadsheet->getDefaultStyle()->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('ffffff');
      // // Set Font
      // $spreadsheet->getDefaultStyle()->getFont()->setName('courier New');

      $colResize = 'A';
      while ($colResize != 'AI') {
        $spreadsheet->getActiveSheet()->getColumnDimension($colResize++)->setWidth(4.08);
      }

      $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment; filename="' . $title . '.xls"');

      $writer->save("php://output");
    } else if ($request->input('filetype') == 'pdf') {
      $mpdf = new \Mpdf\Mpdf([
        'tempDir'       => '/tmp',
        'margin_left'   => 3,
        'margin_right'  => 3,
        'margin_top'    => 4,
        'margin_bottom' => 4,
        'format'        => 'A4',
      ]);
      $mpdf->shrink_tables_to_fit = 1;
      $mpdf->WriteHTML($view_print);

      $mpdf->Output($title . '.pdf', "D");
    } else {
      // Parameter filetype tidak valid / tidak ditemukan return 404
      return redirect(404);
    }
  }

  /**
   * Print.
   *
   * @return \Illuminate\Http\Response
   */
  public function exportDetail(Request $request, $id)
  {
    // $data['claimNote'] = ClaimNote::where('id', $id)->first();
    $claimNoteSubQuery = ClaimNoteDetail::where('claim_note_id', $id)
      ->select(
        'claim_note_id',
        DB::raw("sum(1) as unit"),
        DB::raw("sum(qty) as sum_qty"),
        DB::raw("IF(clm_claim_notes.claim = 'unit', sum(price * 110 / 100), sum(price)) as sum_price"),
        DB::raw("sum(IF(clm_claim_notes.claim = 'unit', price * 110 / 100 , price) * qty) as sub_total")
      )
      ->leftJoin('clm_claim_notes', 'clm_claim_notes.id', '=', 'clm_claim_note_detail.claim_note_id');

    $data['claimNote'] = ClaimNote::from('clm_claim_notes AS n')
      ->joinSub($claimNoteSubQuery, 'nd', function ($join) {
        $join->on('n.id', '=', 'nd.claim_note_id');
      })
      ->where('id', $id)
      ->first();

    $data['claimNoteDetail'] = ClaimNoteDetail::select(
      'clm_claim_note_detail.*',
      DB::raw('tr_expedition.expedition_name AS expedition_name')
    )->leftJoin(
      'tr_expedition',
      'tr_expedition.code',
      '=',
      'clm_claim_note_detail.expedition_code'
    )
      ->where('clm_claim_note_detail.claim_note_id', $id)
      ->get();

    $data['qty']      = 0;
    $data['price']    = 0;
    $data['subTotal'] = 0;
    if (!$data['claimNoteDetail']->isEmpty()) {
      foreach ($data['claimNoteDetail'] as $key => $value) {
        $data['qty'] += $value->qty;
        $price = $data['claimNote']->claim == 'unit' ? $value->price * 110 / 100 : $value->price;
        $data['price'] += $price;
        $data['subTotal'] += ($value->qty * $price);
      }
    }

    $view_print = view('web.claim.claim-notes._print_detail', $data);
    if ($request->input('filetype') == 'xls') {
      $data['excel'] = 1;
      $view_print    = view('web.claim.claim-notes._print_detail', $data);
    }

    $title = 'claim_letter';

    if ($request->input('filetype') == 'html') {

      // return $view_print;
      // request HTML View
      $mpdf = new \Mpdf\Mpdf([
        'tempDir'       => '/tmp',
        'margin_left'   => 5,
        'margin_right'  => 5,
        'margin_top'    => 5,
        'margin_bottom' => 5,
        'format'        => 'A4',
        'orientation'   => 'L',
      ]);
      $mpdf->shrink_tables_to_fit = 1;
      $mpdf->WriteHTML($view_print);

      $mpdf->Output();
      return;
    } else if ($request->input('filetype') == 'xls') {

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
