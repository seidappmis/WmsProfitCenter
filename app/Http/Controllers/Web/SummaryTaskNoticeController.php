<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\LogReturnSuratTugasHeader;
use DataTables;
use DB;
use Illuminate\Http\Request;

class SummaryTaskNoticeController extends Controller
{
  public function index(Request $request)
  {
    if ($request->ajax()) {
      $query = LogReturnSuratTugasHeader::select(
        DB::raw('log_return_surat_tugas_header.date AS upload_date'),
        DB::raw('log_return_surat_tugas_actual.created_date AS receive_date'),
        DB::raw('log_return_surat_tugas_plan.no AS no_doc'),
        DB::raw('log_return_surat_tugas_plan.costumer_code'),
        DB::raw('log_return_surat_tugas_plan.costumer_name'),
        DB::raw('log_return_surat_tugas_plan.cbm'),
        DB::raw('log_return_surat_tugas_plan.no_app AS no_apply'),
        DB::raw('log_return_surat_tugas_plan.model AS model_plan'),
        DB::raw('log_return_surat_tugas_plan.no_do AS do_number_plan'),
        DB::raw('log_return_surat_tugas_plan.vehicle_no AS no_mobil'),
        DB::raw('log_return_surat_tugas_plan.expedition AS expedisi'),
        DB::raw('log_return_surat_tugas_plan.driver AS driver'),
        DB::raw('log_return_surat_tugas_plan.qty AS qty_plan'),
        DB::raw('log_return_surat_tugas_plan.category AS category'),
        DB::raw('log_return_surat_tugas_actual.model AS model_actual'),
        DB::raw('log_return_surat_tugas_actual.qty AS qty_actual'),
        DB::raw('log_return_surat_tugas_actual.ceck AS `check`'),
        DB::raw('log_return_surat_tugas_actual.no_do AS do_number_actual'),
        DB::raw('log_return_surat_tugas_actual.serial_number AS no_serial'),
        DB::raw('log_return_surat_tugas_actual.no_so'),
        DB::raw('log_return_surat_tugas_actual.no_po'),
        DB::raw('log_return_surat_tugas_actual.kondisi'),
        DB::raw('log_return_surat_tugas_actual.rr'),
        DB::raw('log_return_surat_tugas_actual.remark'),
        DB::raw('log_return_surat_tugas_header.no_document AS no_st_or_no_urf'),
        'log_return_surat_tugas_actual.modifiy_date'
      )
        ->leftjoin('log_return_surat_tugas_plan', 'log_return_surat_tugas_plan.id_header', '=', 'log_return_surat_tugas_header.id_header')
        ->leftjoin('log_return_surat_tugas_actual', 'log_return_surat_tugas_actual.id_detail_plan', '=', 'log_return_surat_tugas_plan.id_detail_plan');
      if (!empty($request->input('no_document')))
        $query->where('log_return_surat_tugas_plan.no', $request->input('no_document'));
      $query->where('log_return_surat_tugas_header.area', $request->input('area'));
      $query->where('log_return_surat_tugas_header.date', '>=', date('Y-m-d', strtotime($request->input('start_date'))));
      $query->where('log_return_surat_tugas_header.date', '<=', date('Y-m-d', strtotime($request->input('end_date'))));

      $datatables = DataTables::of($query)
        ->editColumn('date', function ($data) {
          return $data->date;
        });

      return $datatables->make(true);
    }

    return view('web.report.summary-task-notice.index');
  }


  public function export(Request $request)
  {

    $main = LogReturnSuratTugasHeader::select(
      DB::raw('log_return_surat_tugas_header.date AS upload_date'),
      DB::raw('log_return_surat_tugas_actual.created_date AS receive_date'),
      DB::raw('log_return_surat_tugas_plan.no AS no_doc'),
      DB::raw('log_return_surat_tugas_plan.costumer_code'),
      DB::raw('log_return_surat_tugas_plan.costumer_name'),
      DB::raw('log_return_surat_tugas_plan.cbm'),
      DB::raw('log_return_surat_tugas_plan.no_app AS no_apply'),
      DB::raw('log_return_surat_tugas_plan.model AS model_plan'),
      DB::raw('log_return_surat_tugas_plan.no_do AS do_number_plan'),
      DB::raw('log_return_surat_tugas_plan.vehicle_no AS no_mobil'),
      DB::raw('log_return_surat_tugas_plan.expedition AS expedisi'),
      DB::raw('log_return_surat_tugas_plan.driver AS driver'),
      DB::raw('log_return_surat_tugas_plan.qty AS qty_plan'),
      DB::raw('log_return_surat_tugas_plan.category AS category'),
      DB::raw('log_return_surat_tugas_actual.model AS model_actual'),
      DB::raw('log_return_surat_tugas_actual.qty AS qty_actual'),
      DB::raw('log_return_surat_tugas_actual.ceck AS `check`'),
      DB::raw('log_return_surat_tugas_actual.no_do AS do_number_actual'),
      DB::raw('log_return_surat_tugas_actual.serial_number AS no_serial'),
      DB::raw('log_return_surat_tugas_actual.no_so'),
      DB::raw('log_return_surat_tugas_actual.no_po'),
      DB::raw('log_return_surat_tugas_actual.kondisi'),
      DB::raw('log_return_surat_tugas_actual.rr'),
      DB::raw('log_return_surat_tugas_actual.remark'),
      DB::raw('log_return_surat_tugas_header.no_document AS no_st_or_no_urf'),
      'log_return_surat_tugas_actual.modifiy_date'
    )
      ->leftjoin('log_return_surat_tugas_plan', 'log_return_surat_tugas_plan.id_header', '=', 'log_return_surat_tugas_header.id_header')
      ->leftjoin('log_return_surat_tugas_actual', 'log_return_surat_tugas_actual.id_detail_plan', '=', 'log_return_surat_tugas_plan.id_detail_plan');
    if (!empty($request->input('no_document')))
      $main->where('log_return_surat_tugas_plan.no', $request->input('no_document'));
    $main->where('log_return_surat_tugas_header.area', $request->input('area'));
    $main->where('log_return_surat_tugas_header.date', '>=', date('Y-m-d', strtotime($request->input('start_date'))));
    $main->where('log_return_surat_tugas_header.date', '<=', date('Y-m-d', strtotime($request->input('end_date'))));
    $data['data'] = $main->get()->toArray();
    $data['request'] = $request->all();
    // dd($data);
    $view_print = view('web.report.summary-task-notice._print', $data);

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
}
