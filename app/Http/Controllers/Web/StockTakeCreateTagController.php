<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\StockTakeInput1;
use App\Models\StockTakeInput2;
use App\Models\StockTakeSchedule;
use DataTables;
use DB;
use Illuminate\Http\Request;

class StockTakeCreateTagController extends Controller
{
  public function index(Request $request)
  {
    if ($request->ajax()) {
      $query = StockTakeInput1::
        where('sto_id', $request->input('sto_id'))
      ;

      $datatables = DataTables::of($query)
        ->addIndexColumn() //DT_RowIndex (Penomoran)
        ->addColumn('action', function ($data) {
          $action = '';
          $action .= ' ' . get_button_edit('#input-wrapper');
          // $action .= ' ' . get_button_delete();
          return $action;
        });

      return $datatables->make(true);
    }

    return view('web.stock-take.stock-take-create-tag.index');
  }

  public function store(Request $request)
  {
    $request->validate([
      'sto_id'              => 'required',
      'file-stock-take-tag' => 'required',
    ]);

    $file_stocktake_create_tag = $request->file('file-stock-take-tag');

    $file  = fopen($file_stocktake_create_tag, "r");
    $title = true;

    $date             = date('Y-m-d H:i:s');
    $stocktake_inputs = [];
    $no_tag           = 1;

    // Loop data sampai baris terakhir
    while (!feof($file)) {
      $row = fgetcsv($file);
      if ($title) {
        $title = false;
        continue; // Skip baris judul
      }

      if (!empty($row[0])) {
        $stockTakeInput['sto_id']      = $request->input('sto_id');
        $stockTakeInput['no_tag']      = $no_tag++;
        $stockTakeInput['model']       = $row[0];
        $stockTakeInput['location']    = $row[1];
        $stockTakeInput['upload_date'] = $date;
        $stockTakeInput['upload_by']   = auth()->user()->id;

        $stocktake_inputs[] = $stockTakeInput;
      }
    }

    fclose($file);

    return DB::transaction(function () use ($stocktake_inputs, $request) {
      StockTakeInput1::where('sto_id', $request->input('sto_id'))->delete();
      StockTakeInput2::where('sto_id', $request->input('sto_id'))->delete();
      StockTakeInput1::insert($stocktake_inputs);
      StockTakeInput2::insert($stocktake_inputs);
      return 1;
    });

  }

  public function createManual(Request $request)
  {
    $data['schedule'] = StockTakeSchedule::findOrFail($request->input('sto_id'));

    return view('web.stock-take.stock-take-create-tag.create', $data);
    $input1 = new StockTakeInput1;
    $input2 = new StockTakeInput2;

    $input1->sto_id = $request->input('sto_id');
    $input1->no_tag = $request->input('no_tag');
    $input1->model  = $request->input('model');

  }

  public function getSelect2NoTag1(Request $request)
  {
    $query = StockTakeInput1::select(
      DB::raw('id AS id'),
      DB::raw("no_tag AS text"),
      'log_stocktake_input1.*'
    )
      ->where('sto_id', $request->input('sto_id'))
      ->whereNull('input_date')
    ;

    return get_select2_data($request, $query);
  }

  public function getSelect2NoTag2(Request $request)
  {
    $query = StockTakeInput2::select(
      DB::raw('id AS id'),
      DB::raw("no_tag AS text"),
      'log_stocktake_input2.*'
    )
      ->where('sto_id', $request->input('sto_id'))
      ->whereNull('input_date');

    return get_select2_data($request, $query);
  }

  public function getSelect2Location(Request $request)
  {
    $query = StockTakeInput1::select(
      DB::raw('location AS id'),
      DB::raw("location AS text"),
    )
      ->where('sto_id', $request->input('sto_id'))
      ->groupBy('location')
      ->orderBy('location')
      ;

    return get_select2_data($request, $query);
  }

  public function export(Request $request, $id)
  {
    // $data['pickinglistHeader'] = PickinglistHeader::findOrFail($id);

    $view_print = view('web.stock-take.stock-take-create-tag._print');
    $title      = 'Stock Take Create Tag';

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
      $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(5);
      $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(25);

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
