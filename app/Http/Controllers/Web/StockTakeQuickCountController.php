<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\StockTakeInput1;
use App\Models\StockTakeInput2;
use App\Models\StockTakeSchedule;
use DataTables;
use DB;
use Illuminate\Http\Request;

class StockTakeQuickCountController extends Controller
{
  public function index(Request $request)
  {
    if ($request->ajax()) {
      $schedule = StockTakeSchedule::findOrFail($request->input('sto_id'));

      $data['schedule']                     = $schedule;
      $data['total_all_tag_no']             = $schedule->input1->count();
      $data['total_all_models']             = $schedule->details->count();
      $data['total_all_location']           = $schedule->total_all_location();
      $data['summary_tag_compared_matched'] = $schedule->get_summary_tag_compared_matched($schedule->sto_id);
      $data['diff_qty']                     = $schedule->getDifferentQuantity($schedule->sto_id);
      $data['only_input_1']                 = $schedule->input1->whereNotNull('input_date')->count();
      $data['only_input_2']                 = $schedule->input2->whereNotNull('input_date')->count();

      return sendSuccess('Data Retrive', $data);
    }
    return view('web.stock-take.stock-take-quick-count.index');
  }

  public function getInput1(Request $request)
  {
    if ($request->ajax()) {
      $query = StockTakeInput1::select('log_stocktake_input1.*')
        ->leftjoin('log_stocktake_input2', function ($join) {
          $join->on('log_stocktake_input1.sto_id', '=', 'log_stocktake_input2.sto_id');
          $join->on('log_stocktake_input1.no_tag', '=', 'log_stocktake_input2.no_tag');
        })
        ->where('log_stocktake_input1.sto_id', $request->input('sto_id'))
        ->whereNotNull('log_stocktake_input1.input_date')
        ->whereRaw('IF(log_stocktake_input1.quantity IS NULL, 0, log_stocktake_input1.quantity) != IF(log_stocktake_input2.quantity IS NULL, 0, log_stocktake_input2.quantity)')
      ;

      $datatables = DataTables::of($query)
        ->addIndexColumn() //DT_RowIndex (Penomoran)
        ->addColumn('action', function ($data) {
          $action = '';
          $action .= ' ' . get_button_edit('#input-wrapper');
          $action .= ' ' . get_button_delete();
          return $action;
        });

      return $datatables->make(true);
    }
  }

  public function getInput2(Request $request)
  {
    if ($request->ajax()) {
      $query = StockTakeInput2::select('log_stocktake_input2.*')
        ->leftjoin('log_stocktake_input1', function ($join) {
          $join->on('log_stocktake_input1.sto_id', '=', 'log_stocktake_input2.sto_id');
          $join->on('log_stocktake_input1.no_tag', '=', 'log_stocktake_input2.no_tag');
        })
        ->where('log_stocktake_input2.sto_id', $request->input('sto_id'))
        ->whereNotNull('log_stocktake_input2.input_date')
        ->whereRaw('IF(log_stocktake_input1.quantity IS NULL, 0, log_stocktake_input1.quantity) != IF(log_stocktake_input2.quantity IS NULL, 0, log_stocktake_input2.quantity)')
      ;

      $datatables = DataTables::of($query)
        ->addIndexColumn() //DT_RowIndex (Penomoran)
        ->addColumn('action', function ($data) {
          $action = '';
          $action .= ' ' . get_button_edit('#input-wrapper');
          $action .= ' ' . get_button_delete();
          return $action;
        });

      return $datatables->make(true);
    }
  }

  public function getDifferentQuantity(Request $request)
  {
    if ($request->ajax()) {
      $query = StockTakeInput1::select(
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
        ->leftjoin('log_stocktake_input2', function ($join) {
          $join->on('log_stocktake_input1.sto_id', '=', 'log_stocktake_input2.sto_id');
          $join->on('log_stocktake_input1.no_tag', '=', 'log_stocktake_input2.no_tag');
        })
        ->where('log_stocktake_input1.sto_id', $request->input('sto_id'))
        ->whereRaw('(log_stocktake_input1.input_date IS NOT NULL OR log_stocktake_input2.input_date IS NOT NULL)')
        ->whereRaw('IF(log_stocktake_input1.quantity IS NULL, 0, log_stocktake_input1.quantity) != IF(log_stocktake_input2.quantity IS NULL, 0, log_stocktake_input2.quantity)')
      ;

      $datatables = DataTables::of($query)
        ->addIndexColumn() //DT_RowIndex (Penomoran)
      ;

      return $datatables->make(true);
    }
  }

  public function export(Request $request, $id)
  {
    $data['schedule'] = StockTakeSchedule::findOrFail($id);
    $data['details']  = StockTakeInput1::select(
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
      ->leftjoin('log_stocktake_input2', function ($join) {
        $join->on('log_stocktake_input1.sto_id', '=', 'log_stocktake_input2.sto_id');
        $join->on('log_stocktake_input1.no_tag', '=', 'log_stocktake_input2.no_tag');
      })
      ->where('log_stocktake_input1.sto_id', $id)
      ->whereRaw('(log_stocktake_input1.input_date IS NOT NULL OR log_stocktake_input2.input_date IS NOT NULL)')
      ->get()
    ;

    $view_print = view('web.stock-take.stock-take-quick-count._print', $data);
    $title      = 'Stock Take Quick Count';

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
      $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(25);
      $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(30);
      $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(15);
      $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(5);
      $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(10);
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
}
