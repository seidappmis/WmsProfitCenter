<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\StockTakeScheduleDetail;
use App\Models\StockTakeSchedule;
use App\Models\StockTakeInput1;
use DataTables;
use DB;
use Illuminate\Http\Request;

class StockTakeCompareSAPController extends Controller
{
  public function index(Request $request)
  {
    if ($request->ajax()) {
      
      // below original query
      
      // $query = StockTakeScheduleDetail::select(
      //   DB::raw('log_stocktake_schedule_detail.qty AS quantitySAP'),
      //   'log_stocktake_schedule_detail.material_no',
      //   'log_stocktake_input1.id',
      //   'log_stocktake_input1.no_tag',
      //   'log_stocktake_input1.model',
      //   'log_stocktake_input1.quantity',
      //   'log_stocktake_input1.location',
      //   DB::raw('log_stocktake_input2.id AS id2'),
      //   DB::raw('log_stocktake_input2.no_tag AS no_tag2'),
      //   DB::raw('log_stocktake_input2.model AS model2'),
      //   DB::raw('log_stocktake_input2.quantity AS quantity2'),
      //   DB::raw('log_stocktake_input2.location AS location2')
      // )
      //   ->leftjoin('log_stocktake_input1', function ($join) {
      //     $join->on('log_stocktake_input1.sto_id', '=', 'log_stocktake_schedule_detail.sto_id');
      //     $join->on('log_stocktake_input1.model', '=', 'log_stocktake_schedule_detail.material_no');
      //   })
      //   ->leftjoin('log_stocktake_input2', function ($join) {
      //     $join->on('log_stocktake_input1.sto_id', '=', 'log_stocktake_input2.sto_id');
      //     $join->on('log_stocktake_input1.no_tag', '=', 'log_stocktake_input2.no_tag');
      //   })
      //   ->where('log_stocktake_schedule_detail.sto_id', $request->input('sto_id'))
      //   // ->whereRaw('(log_stocktake_input1.input_date IS NOT NULL AND log_stocktake_input2.input_date IS NOT NULL)')
      // ;

      $query = StockTakeScheduleDetail::selectRaw('
        log_stocktake_schedule_detail.qty AS quantitySAP,
        log_stocktake_schedule_detail.material_no,
        sum(log_stocktake_input1.quantity) as quantity,
        sum(log_stocktake_input2.quantity) AS quantity2')
        ->leftjoin('log_stocktake_input1', function ($join) {
          $join->on('log_stocktake_input1.sto_id', '=', 'log_stocktake_schedule_detail.sto_id');
          $join->on('log_stocktake_input1.model', '=', 'log_stocktake_schedule_detail.material_no');
        })
        ->leftjoin('log_stocktake_input2', function ($join) {
          $join->on('log_stocktake_input1.sto_id', '=', 'log_stocktake_input2.sto_id');
          $join->on('log_stocktake_input1.no_tag', '=', 'log_stocktake_input2.no_tag');
        })
        ->where('log_stocktake_schedule_detail.sto_id', $request->input('sto_id'))        
        ->groupBy('log_stocktake_schedule_detail.material_no')
      ;     

      $datatables = DataTables::of($query)
        ->addIndexColumn() //DT_RowIndex (Penomoran)
        ->addColumn('sap_vs_input_1', function($data){
          return !empty($data->quantity) ? $data->quantity - $data->quantitySAP : '';
        })
        ->addColumn('sap_vs_input_2', function($data){
          return !empty($data->quantity2) ? $data->quantity2 - $data->quantitySAP : '';
        })
      ;

      return $datatables->make(true);
    }

    return view('web.stock-take.stock-take-compare-sap.index');
  }

  public function export(Request $request, $id)
  {
    $data['stockTakeSchedule'] = StockTakeSchedule::findOrFail($id);
    $data['stockTakeDetail'] = StockTakeScheduleDetail::select(
        DB::raw('log_stocktake_schedule_detail.qty AS quantitySAP'),
        'log_stocktake_schedule_detail.material_no',
        'log_stocktake_input1.id',
        'log_stocktake_input1.no_tag',
        'log_stocktake_input1.model',
        'log_stocktake_input1.quantity',
        'log_stocktake_input1.location',
        DB::raw('log_stocktake_input2.id AS id2'),
        DB::raw('log_stocktake_input2.no_tag AS no_tag2'),
        DB::raw('log_stocktake_input2.model AS model2'),
        DB::raw('log_stocktake_input2.quantity AS quantity2'),
        DB::raw('log_stocktake_input2.location AS location2')
      )
        ->leftjoin('log_stocktake_input1', function ($join) {
          $join->on('log_stocktake_input1.sto_id', '=', 'log_stocktake_schedule_detail.sto_id');
          $join->on('log_stocktake_input1.model', '=', 'log_stocktake_schedule_detail.material_no');
        })
        ->leftjoin('log_stocktake_input2', function ($join) {
          $join->on('log_stocktake_input1.sto_id', '=', 'log_stocktake_input2.sto_id');
          $join->on('log_stocktake_input1.no_tag', '=', 'log_stocktake_input2.no_tag');
        })
        ->where('log_stocktake_schedule_detail.sto_id', $id)
        ->get()
      ;

    $view_print = view('web.stock-take.stock-take-compare-sap._print', $data);
    $title      = 'Stock Take Compare SAP';

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
      $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(15);
      $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(5);
      $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(20);
      $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(20);
      $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(20);
      $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(20);
      $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(5);
      $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(15);
      $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(20);

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
