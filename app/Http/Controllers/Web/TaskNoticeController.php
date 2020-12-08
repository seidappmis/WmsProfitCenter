<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\LogReturnSuratTugasActual;
use App\Models\LogReturnSuratTugasHeader;
use App\Models\LogReturnSuratTugasPlan;
use DataTables;
use DB;
use Illuminate\Http\Request;

class TaskNoticeController extends Controller
{
  public function index(Request $request)
  {
    if ($request->ajax()) {
      $query = LogReturnSuratTugasHeader::select(
        'log_return_surat_tugas_plan.*',
        DB::raw('COUNT(log_return_surat_tugas_plan.id_detail_plan) AS count_of_plan')
      )
        ->leftjoin('log_return_surat_tugas_plan', 'log_return_surat_tugas_header.id_header', '=', 'log_return_surat_tugas_plan.id_header')
        ->where('log_return_surat_tugas_plan.area', auth()->user()->area)
        ->groupBy('log_return_surat_tugas_plan.id_header');

      $datatables = DataTables::of($query)
        ->addIndexColumn() //DT_RowIndex (Penomoran)
        ->addColumn('task_notice_no', function ($data) {
          return '';
        })
        ->addColumn('action', function ($data) {
          $action = '';
          $action .= ' ' . get_button_view(url('task-notice/' . $data->id_header), 'View');
          $action .= ' ' . get_button_print('#', 'Print ST', 'btn-print-st');
          $action .= ' ' . get_button_print('#', 'Print DO Return', 'btn-print-do-return');
          return $action;
        })
        ->rawColumns(['do_status', 'action']);

      return $datatables->make(true);
    }

    return view('web.return.task-notice.index');
  }

  public function show(Request $request, $id)
  {
    $suratTugasHeader = LogReturnSuratTugasHeader::findOrFail($id);

    if ($request->ajax()) {
      $query = $suratTugasHeader->plans;

      $datatables = DataTables::of($query)
        ->addIndexColumn() //DT_RowIndex (Penomoran)
        ->addColumn('count_of_actual', function ($data) {
          return $data->actual->count();
        })
        ->addColumn('action', function ($data) {
          $action = '';
          $action .= ' ' . get_button_view('#', 'View');
          return $action;
        })
        ->rawColumns(['do_status', 'action']);

      return $datatables->make(true);
    }

    $data['suratTugasHeader'] = $suratTugasHeader;
    return view('web.return.task-notice.view', $data);
  }

  public function store(Request $request)
  {
    $request->validate([
      'file_task_notice' => 'required',
    ]);

    $file           = fopen($request->file('file_task_notice'), "r");
    $title          = true; // Untuk Penada Baris pertama adalah Judul
    $rs_plan        = [];
    $rs_no_document = [];

    try {
      DB::beginTransaction();

      while (!feof($file)) {
        $row = fgetcsv($file);
        if ($title) {
          $title = false;
          continue; // Skip baris judul
        }

        if (!empty($row[1])) {
          $plan['area']              = !empty($request->input('area')) ? $request->input('area') : auth()->user()->area;
          $plan['date']              = date('Y-m-d');
          $plan['no']                = $row[1];
          $plan['no_document']       = $row[2];
          $plan['costumer_po']       = $row[3];
          $plan['expedition_code']   = $row[4];
          $plan['expedition']        = $row[5];
          $plan['vehicle_no']        = $row[6];
          $plan['driver']            = $row[7];
          $plan['model']             = $row[8];
          $plan['model_description'] = $row[9];
          $plan['qty']               = $row[10];
          $plan['cbm']               = $row[11];
          $plan['description']       = $row[12];
          $plan['costumer_code']     = $row[13];
          $plan['costumer_name']     = $row[14];
          $plan['location']          = $row[15];
          $plan['document']          = $row[16];
          $plan['return_date']       = $row[17];
          $plan['lead_time']         = $row[18];
          $plan['no_so']             = $row[19];
          $plan['category']          = $row[20];
          $plan['no_app']            = $row[21];
          $plan['no_do']             = $row[22];
          $plan['remark']            = strtoupper($row[23]);
          $plan['upload_date']       = date('Y-m-d H:i:s');
          $plan['upload_by']         = auth()->user()->id;

          if (empty($rs_no_document[$plan['no_document']])) {
            $header              = new LogReturnSuratTugasHeader;
            $header->area        = !empty($request->input('area')) ? $request->input('area') : auth()->user()->area;
            $header->date        = date('Y-m-d');
            $header->no_document = $plan['no_document'];
            $header->customer_po = $plan['costumer_po'];
            $header->upload_date = date('Y-m-d H:i:s');
            $header->upload_by   = auth()->user()->id;

            $header->save();

            $rs_no_document[$plan['no_document']] = $header;
          }

          $plan['id_header'] = $rs_no_document[$plan['no_document']]->id_header;

          $rs_plan[] = $plan;
        }
      }

      LogReturnSuratTugasPlan::insert($rs_plan);

      $data['rs_plan']        = $rs_plan;
      $data['rs_no_document'] = $rs_no_document;

      DB::commit();

      return sendSuccess('Task Notice submited.', $data);
    } catch (Exception $e) {
      DB::rollBack();
    }
  }

  public function update(Request $request)
  {
    $data['vehicle_no'] = $request->input('vehicle_no');
    $data['expedition'] = $request->input('expedition');
    $data['driver']     = $request->input('driver');
    if (!empty($request->input('allocation'))) {
      $data['allocation'] = $request->input('allocation');
    }
    if (!empty($request->input('admin_warehouse'))) {
      $data['admin_warehouse'] = $request->input('admin_warehouse');
    }
    if (!empty($request->input('security'))) {
      $data['security'] = $request->input('security');
    }
    if (!empty($request->input('checker'))) {
      $data['checker'] = $request->input('checker');
    }
    if (!empty($request->input('wh'))) {
      $data['wh'] = $request->input('wh');
    }

    LogReturnSuratTugasPlan::where('id_header', $request->input('id_header'))->update($data);

    return sendSuccess('Data updated.', $data);
  }

  public function destroy(Request $request)
  {

    try {
      DB::beginTransaction();

      $data_header = json_decode($request->input('data_header'), true);

      foreach ($data_header as $key => $value) {
        $actual = LogReturnSuratTugasActual::where('id_header', $value['id_header'])->first();

        if (!empty($actual)) {
          return sendError('Data Already Exist In Actual !');
        }

        LogReturnSuratTugasPlan::where('id_header', $value['id_header'])
          ->delete();
        LogReturnSuratTugasHeader::where('id_header', $value['id_header'])->delete();
      }

      DB::commit();

      return sendSuccess('Task Notice Deleted.', []);
    } catch (Exception $e) {
      DB::rollback();
    }
  }

  public function updateActual(Request $request)
  {
    $actual = LogReturnSuratTugasActual::findOrFail($request->input('id_detail_actual'));

    $actual->model         = $request->input('model');
    $actual->qty           = $request->input('qty');
    $actual->serial_number = $request->input('serial_number');
    $actual->no_so         = $request->input('no_so');
    $actual->no_do         = $request->input('no_do');
    $actual->no_po         = $request->input('no_po');
    $actual->rr            = $request->input('rr');
    $actual->kondisi       = $request->input('kondisi');
    $actual->remark        = $request->input('remark');
    $actual->modify_date   = date('Y-m-d H:i:s');
    $actual->modify_by     = auth()->user()->id;

    $actual->save();

    return sendSuccess('Data Actual updated.', $actual);
  }

  public function destroyActual(Request $request)
  {
    LogReturnSuratTugasActual::destroy($request->input('id_detail_actual'));

    return sendSuccess('This Actual has been deleted.', []);
  }

  public function getActual(Request $request)
  {
    $actuals = LogReturnSuratTugasActual::where('id_detail_plan', $request->input('id_detail_plan'))->get();
    return sendSuccess('Data Actual Retrive.', $actuals);
  }

  public function storeActual(Request $request)
  {
    $plan = LogReturnSuratTugasPlan::findOrFail($request->input('id_detail_plan'));

    $actual = new LogReturnSuratTugasActual;

    $actual->id_header      = $request->input('id_header');
    $actual->id_detail_plan = $request->input('id_detail_plan');
    $actual->area           = $plan->area;
    $actual->date           = $plan->date;
    $actual->no_document    = $plan->no_document;
    $actual->costumer_po    = $plan->costumer_po;
    $actual->model          = $request->input('model');
    $actual->qty            = $request->input('qty');
    $actual->serial_number  = $request->input('serial_number');
    $actual->no_so          = $request->input('no_so');
    $actual->no_do          = $request->input('no_do');
    $actual->no_po          = $request->input('no_po');
    $actual->ceck           = 'OK';
    $actual->rr             = $request->input('rr');
    $actual->kondisi        = $request->input('kondisi');
    $actual->remark         = $request->input('remark');
    $actual->modify_date    = date('Y-m-d H:i:s');
    $actual->modify_by     = auth()->user()->id;

    $actual->save();

    return sendSuccess('Task Notice Actual Success', $actual);
  }

  //Export ST
  public function exportSt(Request $request, $id)
  {
    $data['request'] = $request->all();
    $data['header']  = LogReturnSuratTugasHeader::findOrFail($id);

    $view_print = view('web.return.task-notice._print_st', $data);
    $title      = 'Task Notice ST';

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
      $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(5);
      $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(5);
      $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(5);
      $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(20);
      $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(5);
      $spreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(5);
      $spreadsheet->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('L')->setWidth(5);
      $spreadsheet->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('N')->setWidth(5);
      $spreadsheet->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('P')->setWidth(5);
      $spreadsheet->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);

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

  // ExportDoReturn
  public function exportDoReturn(Request $request, $id)
  {
    $data['request'] = $request->all();
    $data['header']  = LogReturnSuratTugasHeader::findOrFail($id);

    $view_print = view('web.return.task-notice._print_do_return', $data);
    $title      = 'Task Notice DO Return';

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
      $spreadsheet->getDefaultStyle()->getFont()->setName('Arial');

      // Atur lebar kolom
      $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(10);
      $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(15);
      $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(5);
      $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(5);
      $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(5);
      $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(20);
      $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(5);
      $spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(15);
      $spreadsheet->getActiveSheet()->getColumnDimension('L')->setWidth(20);

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
