<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\BeritaAcaraDetail;
use App\Models\ClaimInsurance;
use App\Models\ClaimInsuranceDetail;
use DataTables;
use DB;
use Illuminate\Http\Request;

class ClaimInsuranceController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $req)
  {
    if ($req->ajax()) {
      $query = BeritaAcaraDetail::select(
        'clm_berita_acara_detail.*',
        'clm_berita_acara.expedition_code',
        'clm_berita_acara.vehicle_number',
        'clm_berita_acara.date_of_receipt',
        'clm_berita_acara.driver_name'
      )
        ->leftJoin('clm_berita_acara', 'clm_berita_acara.id', '=', 'clm_berita_acara_detail.berita_acara_id')
        ->leftJoin('clm_claim_insurance_detail', 'clm_claim_insurance_detail.berita_acara_detail_id', '=', 'clm_berita_acara_detail.id')
        ->whereNotNull('clm_berita_acara.submit_date')
        ->whereNull('clm_claim_insurance_detail.id')
      // ->whereNull('claim_note_detail_id')
        ->orderBy('created_at', 'DESC')
        ->get();

      $datatables = DataTables::of($query)
        ->addIndexColumn(); //DT_RowIndex (Penomoran)

      return $datatables->make(true);
    };
    return view('web.claim.claim-insurance.index');
  }

  // DataTable claim insurance Index
  public function listClaimInsurance(Request $request)
  {
    if ($request->ajax()) {
      $query = ClaimInsurance::from('clm_claim_insurance AS i')
        ->leftJoin('clm_claim_insurance_detail AS insurance', 'insurance.claim_insurance_id', '=', 'i.id')
        ->leftJoin('clm_berita_acara_detail AS bad', 'bad.claim_insurance_detail_id', '=', 'insurance.id')
        ->leftJoin('clm_berita_acara AS ba', 'bad.berita_acara_id', '=', 'ba.id')
        ->leftJoin('tr_expedition AS e', 'e.code', '=', 'ba.expedition_code')
        ->orderBy('i.created_at', 'DESC')
        ->groupBy('i.id')
        ->select(
          'i.*',
          DB::raw("group_concat(bad.berita_acara_no SEPARATOR ', ') as berita_acara_group"),
          'e.expedition_name',
          'ba.date_of_receipt',
          'insurance.destination'
        );

      $datatables = DataTables::of($query)
        ->addIndexColumn(); //DT_RowIndex (Penomoran)

      return $datatables->make(true);
    }
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
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
          $dataClaimNote     = [
            'claim_note_no'   => null,
            'berita_acara_no' => null,
            'date_of_receipt' => null,
            'expedition_code' => null,
            'driver_name'     => null,
            'vehicle_number'  => null,
            'destination'     => null,
            'do_no'           => null,
            'model_name'      => null,
            'serial_number'   => null,
            'qty'             => null,
            'description'     => null,
            'price'           => null,
            'total_price'     => null,
          ];
          // set key of array claim insurance to berita acara id
          foreach ($data as $kb => $vb) {
            $beritaAcaraDetail[$vb['berita_acara_detail_id']] = $vb;
          }
          // unset berita acara id from array claim insurance for parsing
          foreach ($beritaAcaraDetail as $kc => $vc) {
            // unset berita_acara_detail_id not used in table clm_claim_note
            unset($beritaAcaraDetail[$kc]['berita_acara_detail_id']);
          }

          DB::transaction(function () use (&$beritaAcaraDetail, &$req) {

            // insert to claim insurance and return id
            $claiminsuranceID = ClaimInsurance::insertGetId([
              'claim_report'        => $req->input('claim_report'),
              'keterangan_kejadian' => $req->input('keterangan_kejadian'),
              'insurance_date'      => date('Y-m-d H:i:s'),
              'created_by'          => auth()->user()->id,
              'created_at'          => date('Y-m-d H:i:s'),
            ]);

            foreach ($beritaAcaraDetail as $key => $value) {
              // insert into claim insurance detail
              $claimInsuranceDetailID = ClaimInsuranceDetail::insertGetId([
                'claim_insurance_id'     => $claiminsuranceID,
                'berita_acara_detail_id' => $key,
                'date_of_receipt'        => $value['date_of_receipt'],
                'expedition_code'        => $value['expedition_code'],
                'driver_name'            => $value['driver_name'],
                'vehicle_number'         => $value['vehicle_number'],
                'do_no'                  => $value['do_no'],
                'model_name'             => $value['model_name'],
                'serial_number'          => $value['serial_number'],
                'description'            => $value['description'],
                'created_by'             => auth()->user()->id,
                'created_at'             => date('Y-m-d H:i:s'),
              ]);
              // update berita acara detail _> claim note id from before
              BeritaAcaraDetail::whereId($key)->update(['claim_insurance_detail_id' => $claimInsuranceDetailID]);
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
    $data['claimInsurance'] = ClaimInsurance::where('id', $id)->first();
    return view('web.claim.claim-insurance.edit', $data);
  }

  // DataTable claim insurance detail
  public function listDetailClaimInsurance(Request $request, $id)
  {
    if ($request->ajax()) {

      $query = ClaimInsurance::from('clm_claim_insurance AS i')
        ->leftJoin('clm_claim_insurance_detail AS id', 'id.claim_insurance_id', '=', 'i.id')
        ->leftJoin('clm_berita_acara_detail AS bad', 'bad.claim_insurance_detail_id', '=', 'id.id')
        ->leftJoin('clm_berita_acara AS ba', 'bad.berita_acara_id', '=', 'ba.id')
        ->leftJoin('tr_expedition AS e', 'e.code', '=', 'ba.expedition_code')
        ->orderBy('i.created_at', 'DESC')
        ->where('i.id', $id)
        ->select(
          'i.*',
          'e.expedition_name',
          'ba.date_of_receipt',
          'ba.berita_acara_no',
          'bad.photo_url',
          'bad.keterangan',
          'id.location',
          'id.driver_name',
          'id.vehicle_number',
          'id.do_no',
          'id.model_name',
          'id.serial_number',
          'id.description',
          'id.qty',
          'id.price',
          'id.id AS claim_insurance_detail'
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

            ClaimInsurance::whereId($id)->update([
              'updated_by' => auth()->user()->id,
              'updated_at' => date('Y-m-d H:i:s'),
            ]);

            foreach ($data as $key => $value) {
              // update berita acara detail _> claim note id from before
              $value['updated_by'] = auth()->user()->id;
              $value['updated_at'] = date('Y-m-d H:i:s');

              ClaimInsuranceDetail::whereId($key)->update($value);
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
    //
  }

  /**
   * Print.
   *
   * @return \Illuminate\Http\Response
   */
  public function exportRPT(Request $request, $id)
  {
    $data['claimInsurance'] = ClaimInsurance::findOrFail($id);
    $view_print = view('web.claim.claim-insurance._print_rpt', $data);
    $title      = 'rpt';

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

  /**
   * Print.
   *
   * @return \Illuminate\Http\Response
   */
  public function exportDetail(Request $request, $id)
  {
    $data = [
      'claimInsurance'       => ClaimInsurance::whereId($id)->first(),
      'claimInsuranceDetail' => ClaimInsuranceDetail::from('clm_claim_insurance_detail AS id')
        ->leftJoin('clm_berita_acara_detail AS bad', 'bad.claim_insurance_detail_id', '=', 'id.id')
        ->leftJoin('clm_berita_acara AS ba', 'bad.berita_acara_id', '=', 'ba.id')
        ->leftJoin('tr_expedition AS e', 'e.code', '=', 'ba.expedition_code')
        ->orderBy('id.created_at', 'DESC')
        ->where('id.claim_insurance_id', $id)
        ->select(
          'e.expedition_name',
          'ba.date_of_receipt',
          'ba.berita_acara_no',
          'bad.photo_url',
          'bad.keterangan',
          'id.location',
          'id.driver_name',
          'id.vehicle_number',
          'id.do_no',
          'id.model_name',
          'id.serial_number',
          'id.description',
          'id.qty',
          'id.price',
          'id.id AS claim_insurance_detail',
          'id.created_at'
        )->get(),
    ];

    $view_print = view('web.claim.claim-insurance._print_detail', $data);
    $title      = 'claim_insurance_detail';

    if ($request->input('filetype') == 'html') {
      // Request HTML View
      return $view_print;
    } else if ($request->input('filetype') == 'xls') {
      $data['excel'] = 1;
      $view_print    = view('web.claim.claim-insurance._print_detail_excel', $data);
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
      $view_print = view('web.claim.claim-insurance._print_detail_pdf', $data);
      // Request File PDF
      $mpdf = new \Mpdf\Mpdf(['tempDir' => '/tmp', 'orientation' => 'L']);

      $mpdf->WriteHTML($view_print, \Mpdf\HTMLParserMode::HTML_BODY);

      $mpdf->Output($title . '.pdf', "D");
    } else {
      // Parameter filetype tidak valid / tidak ditemukan return 404
      return redirect(404);
    }
  }
}
