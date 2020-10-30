<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\BeritaAcara;
use App\Models\BeritaAcaraDetail;
use App\Models\ClaimNote;
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
        return view('web.claim.claim-notes.index');
    }

    // DataTable Outstanding Index
    public function listOutstanding(Request $request)
    {
        if ($request->ajax()) {
            $query = BeritaAcaraDetail::whereNull('claim_note_id')
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
                    $dataClaimNote = [];
                    // set key of array claim note to berita acara id
                    foreach ($data as $kb => $vb) {
                        $dataClaimNote[$vb['berita_acara_detail_id']] = $vb;
                    }
                    // unset berita acara id from array claim note for parsing
                    foreach ($dataClaimNote as $kc => $vc) {
                        unset($dataClaimNote[$kc]['berita_acara_detail_id']);
                    }

                    DB::transaction(function () use (&$dataClaimNote) {
                        foreach ($dataClaimNote as $key => $value) {
                            // insert to claim note and return id
                            $claimNoteID = ClaimNote::insertGetId($value);
                            // update berita acara detail _> claim note id from before
                            BeritaAcaraDetail::whereId($key)->update(['claim_note_id' => $claimNoteID]);
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
        //
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
        //
    }

    /**
     * Print.
     *
     * @return \Illuminate\Http\Response
     */
    public function export(Request $request, $id)
    {
        $view_print = view('web.claim.claim-notes._print');
        $title      = 'claim_letter';

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
