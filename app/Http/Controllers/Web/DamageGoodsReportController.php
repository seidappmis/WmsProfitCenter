<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
      $query = BeritaAcaraDetail::select(
        'clm_berita_acara_detail.*',
        'clm_berita_acara.expedition_code',
        'clm_berita_acara.vehicle_number',
        'clm_berita_acara.date_of_receipt',
        'clm_berita_acara.driver_name'
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


  public function export(Request $request, $id)
  {
    // $data['pickinglistHeader'] = PickinglistHeader::findOrFail($id);

    $view_print = view('web.during.damage-goods-report._print');
    $title      = 'Damage Goods Report';

    if ($request->input('filetype') == 'html') {

      // request HTML View
      return $view_print;
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
      $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(5);
      $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(20);
      $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(30);
      $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(20);
      $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(20);
      $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(20);
      $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(20);
      $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(10);
      $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(10);
      $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(25);
      $spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(45);

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
}
