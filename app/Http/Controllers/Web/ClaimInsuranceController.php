<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClaimInsuranceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
    public function exportRPT(Request $request, $id)
    {
        $view_print = view('web.claim.claim-insurance._print_rpt');
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
    public function exportDetail(Request $request, $id, $detail_id)
    {
        $view_print = view('web.claim.claim-insurance._print_detail');
        $title      = 'claim_insurance_detail';

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
