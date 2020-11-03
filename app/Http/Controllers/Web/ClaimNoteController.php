<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\BeritaAcara;
use App\Models\BeritaAcaraDetail;
use App\Models\ClaimNote;
use App\Models\ClaimNoteDetail;
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
            $query = BeritaAcaraDetail::whereNull('claim_note_detail_id')
                ->leftJoin('clm_berita_acara', 'clm_berita_acara.id', '=', 'clm_berita_acara_detail.berita_acara_id')
                ->select(
                    'clm_berita_acara_detail.*',
                    'clm_berita_acara.expedition_code',
                    'clm_berita_acara.vehicle_number',
                    'clm_berita_acara.date_of_receipt',
                    'clm_berita_acara.driver_name'
                )
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
                ->leftJoin('clm_berita_acara_detail AS bad', 'bad.claim_note_detail_id', '=', 'nd.id')
                ->leftJoin('clm_berita_acara AS ba', 'bad.berita_acara_id', '=', 'ba.id')
                ->leftJoin('tr_expedition AS e', 'e.code', '=', 'ba.expedition_code')
                ->orderBy('n.created_at', 'DESC')
                // ->groupBy('n.id')
                ->groupBy('n.id')
                ->select(
                    'n.*',
                    DB::raw("group_concat(bad.berita_acara_no SEPARATOR ', ') as berita_acara_group"),
                    'e.expedition_name',
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
                    $dataClaimNote = [
                        'claim_note_no' => null,
                        'berita_acara_no' => null,
                        'date_of_receipt' => null,
                        'expedition_code' => null,
                        'driver_name' => null,
                        'vehicle_number' => null,
                        'destination' => null,
                        'do_no' => null,
                        'model_name' => null,
                        'serial_number' => null,
                        'qty' => null,
                        'description' => null,
                        'price' => null,
                        'total_price' => null
                    ];
                    // set key of array claim note to berita acara id
                    foreach ($data as $kb => $vb) {
                        $beritaAcaraDetail[$vb['berita_acara_detail_id']] = $vb;
                    }
                    // unset berita acara id from array claim note for parsing
                    foreach ($beritaAcaraDetail as $kc => $vc) {
                        // unset berita_acara_detail_id not used in table clm_claim_note
                        unset($beritaAcaraDetail[$kc]['berita_acara_detail_id']);
                    }

                    DB::transaction(function () use (&$beritaAcaraDetail, &$req) {

                        // Generate No. Claim Note :  01/Claim U-Log/Des/2019
                        $format =  "%s/Claim %s-log/" . date('M') . "/" . date('Y');

                        $max_no  = DB::table('clm_claim_notes')
                            ->select(DB::raw('MAX(SUBSTR(claim_note_no, 1, 2)) AS max_no'))
                            ->orderBy('created_at', 'DESC')
                            ->first()
                            ->max_no;

                        // adding claim note number
                        $type = ($req->type == 'carton-box') ? 'C' : 'U';
                        $max_no = str_pad($max_no + 1, 2, 0, STR_PAD_LEFT);
                        $claim_note_no = sprintf($format, $max_no, $type);

                        // insert to claim note and return id
                        $claimNoteID = ClaimNote::insertGetId([
                            'claim_note_no' => $claim_note_no,
                            'claim' => $req->type,
                            'created_by' => auth()->user()->id,
                            'created_at' => date('Y-m-d H:i:s')
                        ]);

                        foreach ($beritaAcaraDetail as $key => $value) {
                            // insert into claim note detail
                            $claimNoteDetailID = ClaimNoteDetail::insertGetId([
                                'claim_note_id' => $claimNoteID,
                                'berita_acara_detail_id' => $key,
                                'date_of_receipt' => $value['date_of_receipt'],
                                'expedition_code' => $value['expedition_code'],
                                'driver_name' => $value['driver_name'],
                                'vehicle_number' => $value['vehicle_number'],
                                'do_no' => $value['do_no'],
                                'model_name' => $value['model_name'],
                                'serial_number' => $value['serial_number'],
                                'description' => $value['description'],
                                'created_by' => auth()->user()->id,
                                'created_at' => date('Y-m-d H:i:s')
                            ]);
                            // update berita acara detail _> claim note id from before
                            BeritaAcaraDetail::whereId($key)->update(['claim_note_detail_id' => $claimNoteDetailID]);
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
        $data['claimNote'] =  ClaimNote::where('id', $id)->first();
        return view('web.claim.claim-notes.view', $data);
    }

    // DataTable claim note detail
    public function listDetailClaimNotes(Request $request, $id)
    {
        if ($request->ajax()) {
            $query = ClaimNote::from('clm_claim_notes AS n')
                ->leftJoin('clm_claim_note_detail AS nd', 'nd.claim_note_id', '=', 'n.id')
                ->leftJoin('clm_berita_acara_detail AS bad', 'bad.claim_note_detail_id', '=', 'nd.id')
                ->leftJoin('clm_berita_acara AS ba', 'bad.berita_acara_id', '=', 'ba.id')
                ->leftJoin('tr_expedition AS e', 'e.code', '=', 'ba.expedition_code')
                ->orderBy('n.created_at', 'DESC')
                ->where('i.id', $id)
                ->select(
                    'n.*',
                    'e.expedition_name',
                    'ba.date_of_receipt',
                    'ba.berita_acara_no',
                    'nd.destination',
                    'nd.driver_name',
                    'nd.vehicle_number',
                    'nd.do_no',
                    'nd.model_name',
                    'nd.serial_number',
                    'nd.description',
                    'nd.qty',
                    'nd.price',
                    'nd.id AS claim_note_detail'
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

                        ClaimNote::whereId($id)->update([
                            'updated_by' => auth()->user()->id,
                            'updated_at' => date('Y-m-d H:i:s')
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
        //
    }

    /**
     * Print.
     *
     * @return \Illuminate\Http\Response
     */
    public function export(Request $request, $id)
    {
        // $data['claimNote'] = ClaimNote::where('id', $id)->first();
        $claimNoteSubQuery = ClaimNoteDetail::where('claim_note_id', $id)
            ->select(
                'claim_note_id',
                DB::raw("sum(1) as unit"),
                DB::raw("sum(qty) as sum_qty"),
                DB::raw("sum(price) as sum_price"),
                DB::raw("sum(price*qty) as sub_total")
            );

        $data['claimNote'] = ClaimNote::from('clm_claim_notes AS n')
            ->joinSub($claimNoteSubQuery, 'nd', function ($join) {
                $join->on('n.id', '=', 'nd.claim_note_id');
            })
            ->where('id', $id)
            ->first();
        $data['claimNoteDetail'] = ClaimNoteDetail::where('claim_note_id', $id)->get();

        $view_print = view('web.claim.claim-notes._print', $data);

        if ($request->input('filetype') == 'xls') {
            $data['excel'] = 1;
            $view_print = view('web.claim.claim-notes._print_excel', $data);
        }

        $title      = 'claim_letter';

        if ($request->input('filetype') == 'html') {
            // Request HTML View
            return $view_print;
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

    /**
     * Print.
     *
     * @return \Illuminate\Http\Response
     */
    public function exportDetail(Request $request, $id, $detail_id)
    {
        $view_print = view('web.claim.claim-notes._print_detail');
        $title      = 'claim_letter_detail';

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
