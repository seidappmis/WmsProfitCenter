<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\InvoiceReceiptDetail;
use App\Models\InvoiceReceiptHeader;
use App\Models\InvoiceReceiptConfirm;
use App\Models\LogManifestDetail;
use App\Models\LogManifestHeader;
use DataTables;
use DB;
use Illuminate\Http\Request;

class ReceiptInvoiceController extends Controller
{
  public function index(Request $request)
  {
    if ($request->ajax()) {
      $query = InvoiceReceiptHeader::all();

      $datatables = DataTables::of($query)
        ->addIndexColumn() //DT_RowIndex (Penomoran)
        ->addColumn('action_view', function ($data) {
          return get_button_view(url('receipt-invoice/' . $data->id));
        })
        ->addColumn('action_delete', function ($data) {
          return empty($data->receiptInvoiceConfirm) ? get_button_delete() : '';
        })
        ->rawColumns(['action_view', 'action_delete']);

      return $datatables->make(true);
    }
    return view('web.invoicing.receipt-invoice.index');
  }

  public function getManifest(Request $request)
  {
    if ($request->ajax()) {
      $from_date = date("Y-m-01", strtotime(str_replace('/', '-', '01/' . $request->input('manifest_date'))));
      $to_date   = date("Y-m-t", strtotime(str_replace('/', '-', '01/' . $request->input('manifest_date'))));

      $query = LogManifestHeader::select(
        'log_manifest_header.*',
        DB::raw('COUNT(DISTINCT(log_manifest_detail.delivery_no)) AS count_of_do'),
        DB::raw('SUM(log_manifest_detail.cbm) AS sum_of_cbm')
      )
        ->leftjoin('log_manifest_detail', 'log_manifest_detail.do_manifest_no', '=', 'log_manifest_header.do_manifest_no')
        ->leftjoin('log_invoice_receipt_detail', function ($join) {
          $join->on('log_invoice_receipt_detail.do_manifest_no', '=', 'log_manifest_detail.do_manifest_no');
          $join->on('log_invoice_receipt_detail.delivery_no', '=', 'log_manifest_detail.delivery_no');
        })
        ->where('log_manifest_header.expedition_code', $request->input('expedition_code'))
        ->whereNotNull('log_manifest_header.expedition_code')
        ->whereBetween(DB::raw('DATE(log_manifest_header.do_manifest_date)'), array($from_date, $to_date))
        ->whereNull('log_invoice_receipt_detail.id')
        ->where('log_manifest_header.status_complete', 1)
        ->groupBy('log_manifest_header.do_manifest_no');

      if (auth()->user()->area != 'All') {
        $query->where('log_manifest_header.area', auth()->user()->area);
      }

      $datatables = DataTables::of($query)
        ->addIndexColumn() //DT_RowIndex (Penomoran)
      ;

      return $datatables->make(true);
    }
  }

  public function create()
  {
    return view('web.invoicing.receipt-invoice.create');
  }

  public function store(Request $request)
  {
    if (empty(json_decode($request->input('data_manifest'), true))) {
      return sendError('No manifest selected.');
    }

    $invoiceReceiptHeader = new InvoiceReceiptHeader;

    $invoiceReceiptHeader->id                   = date("Y-m-d H:i:s");
    $invoiceReceiptHeader->expedition_code      = $request->input('expedition_code');
    $invoiceReceiptHeader->expedition_name      = $request->input('expedition_name');
    $invoiceReceiptHeader->pph                  = 2;
    $invoiceReceiptHeader->ppn                  = 10;
    $invoiceReceiptHeader->amount_ppn           = 0;
    $invoiceReceiptHeader->amount_pph           = 0;
    $invoiceReceiptHeader->amount_before_tax    = 0;
    $invoiceReceiptHeader->amount_after_tax     = 0;
    $invoiceReceiptHeader->invoice_receipt_date = date('Y-m-d', strtotime(str_replace('/', '-', '01/' . $request->input('invoice_receipt_date'))));

    $rsInvoiceReceiptDetail = $this->getPostManifestDetailData($request, $invoiceReceiptHeader);

    try {
      DB::beginTransaction();

      $invoiceReceiptHeader->save();
      InvoiceReceiptDetail::insert($rsInvoiceReceiptDetail);

      $invoiceReceiptHeader->updateAmountInvoice();

      DB::commit();

      return sendSuccess('Receipt Invoice Created.', $invoiceReceiptHeader);
    } catch (Exception $e) {
      DB::rollBack();
    }

    return $rsInvoiceManifestDetail;
  }

  public function update(Request $request, $id)
  {
    $invoiceReceiptHeader = InvoiceReceiptHeader::findOrFail($id);

    $invoiceReceiptHeader->invoice_receipt_date = date('Y-m-d', strtotime(str_replace('/', '-', '01/' . $request->input('invoice_receipt_date'))));
    $invoiceReceiptHeader->save();

    if (empty(json_decode($request->input('data_manifest'), true))) {
      return sendError('No manifest selected.');
    }

    $rsInvoiceReceiptDetail = $this->getPostManifestDetailData($request, $invoiceReceiptHeader);

    try {
      DB::beginTransaction();

      InvoiceReceiptDetail::insert($rsInvoiceReceiptDetail);
      $invoiceReceiptHeader->updateAmountInvoice();

      DB::commit();

      return sendSuccess('Receipt Invoice updated.', $invoiceReceiptHeader);
    } catch (Exception $e) {
      DB::rollBack();
    }

    return $rsInvoiceManifestDetail;
  }

  public function updateManifestRitase(Request $request, $id, $do_manifest_no){
    $details = InvoiceReceiptDetail::where('id_header', $id)->where('do_manifest_no', $do_manifest_no)->get();

    if (empty($details)) {
      return sendError('Manifest Not found');
    }

    InvoiceReceiptDetail::where('id_header', $id)->where('do_manifest_no', $do_manifest_no)->update([
      'ritase_amount' => $request->input('ritase_amount') / count($details)
    ]);

    return sendSuccess('Ritase Updated!', $details);
  }

  protected function getPostManifestDetailData($request, $invoiceReceiptHeader)
  {
    $rs_do_manifest_no = [];
    foreach (json_decode($request->input('data_manifest'), true) as $key => $value) {
      $rs_do_manifest_no[] = $value['do_manifest_no'];
    }

    $rs_manifest_detail = LogManifestDetail::select(
      'log_manifest_detail.delivery_no',
      'log_manifest_detail.do_manifest_no',
      'log_manifest_detail.do_date',
      'log_manifest_detail.model',
      'log_manifest_detail.region',
      'log_manifest_detail.area',
      'log_manifest_detail.kode_cabang',
      'log_manifest_detail.code_sales',
      'log_manifest_detail.city_name',
      'log_manifest_detail.city_code',
      'log_manifest_detail.ship_to',
      'log_manifest_detail.ship_to_code',
      'log_manifest_detail.sold_to',
      'log_manifest_detail.sold_to_code',
      'log_manifest_detail.sold_to_street',
      'log_manifest_header.do_manifest_date',
      'log_manifest_header.vehicle_code_type',
      'log_manifest_header.vehicle_number',
      'log_manifest_header.vehicle_description',
      'log_manifest_header.driver_name',
      DB::raw('SUM(log_manifest_detail.quantity) AS quantity'),
      DB::raw('SUM(log_manifest_detail.cbm) AS cbm_do'),
      DB::raw('SUM(log_manifest_detail.nilai_cbm) AS nilai_cbm'),
      DB::raw('log_manifest_detail.nilai_ritase AS nilai_ritase'),
      DB::raw('log_manifest_detail.nilai_ritase2 AS nilai_ritase2'),
      DB::raw('log_cabang.short_description AS short_description_cabang'),
      DB::raw('log_manifest_header.cbm AS cbm_vehicle'),
      DB::raw('log_manifest_header.city_code AS city_code_header'),
      DB::raw('log_manifest_header.city_name AS city_name_header')
    )
      ->leftjoin('log_manifest_header', 'log_manifest_header.do_manifest_no', '=', 'log_manifest_detail.do_manifest_no')
      ->leftjoin('log_cabang', 'log_cabang.kode_cabang', '=', 'log_manifest_detail.kode_cabang')
      ->whereIn('log_manifest_detail.do_manifest_no', $rs_do_manifest_no)
      ->groupBy(['do_manifest_no', 'delivery_no'])
      ->get();

    $rsInvoiceReceiptDetail = [];
    foreach ($rs_manifest_detail as $key => $value) {
      $invoiceManifestDetail['id_header']           = $invoiceReceiptHeader->id;
      $invoiceManifestDetail['delivery_no']         = $value->delivery_no;
      $invoiceManifestDetail['do_manifest_no']      = $value->do_manifest_no;
      $invoiceManifestDetail['do_manifest_date']    = $value->do_manifest_date;
      $invoiceManifestDetail['do_date']             = $value->do_date;
      $invoiceManifestDetail['model']               = $value->model;
      $invoiceManifestDetail['vehicle_code_type']   = $value->vehicle_code_type;
      $invoiceManifestDetail['vehicle_number']      = $value->vehicle_number;
      $invoiceManifestDetail['vehicle_description'] = $value->vehicle_description;
      $invoiceManifestDetail['driver_name']         = $value->driver_name;
      $invoiceManifestDetail['sold_to']             = $value->sold_to;
      $invoiceManifestDetail['sold_to_code']        = $value->sold_to_code;
      $invoiceManifestDetail['sold_to_street']      = $value->sold_to_street;
      $invoiceManifestDetail['ship_to']             = $value->ship_to;
      $invoiceManifestDetail['quantity']            = $value->quantity;
      $invoiceManifestDetail['ship_to_code']        = $value->ship_to_code;
      $invoiceManifestDetail['city_code']           = $value->city_code;
      $invoiceManifestDetail['city_name']           = $value->city_name;
      $invoiceManifestDetail['city_code_header']    = $value->city_code_header;
      $invoiceManifestDetail['city_name_header']    = $value->city_name_header;
      $invoiceManifestDetail['cbm_vehicle']         = $value->cbm_vehicle;
      $invoiceManifestDetail['cbm_do']              = $value->cbm_do;
      $invoiceManifestDetail['cbm_amount']          = $value->nilai_cbm;
      $invoiceManifestDetail['freight_cost_cbm']    = 1;
      $invoiceManifestDetail['freight_cost']        = $invoiceManifestDetail['cbm_amount'] / $value->cbm_do;
      $invoiceManifestDetail['ritase_amount']       = $value->nilai_ritase / count($rs_manifest_detail);
      $invoiceManifestDetail['ritase2_amount']      = $value->nilai_ritase2 / count($rs_manifest_detail);
      $invoiceManifestDetail['code_sales']          = $value->code_sales;
      $invoiceManifestDetail['lead_time']           = 0;
      $invoiceManifestDetail['multidro_amount']     = 0;
      $invoiceManifestDetail['unloading_amount']    = 0;
      $invoiceManifestDetail['overstay_amount']     = 0;
      $invoiceManifestDetail['kode_cabang']         = $value->kode_cabang;
      $invoiceManifestDetail['region']              = $value->region;
      $invoiceManifestDetail['area']                = $value->area;
      $invoiceManifestDetail['acc_code']            = date('My', strtotime($value->do_manifest_date)) . '-' . $value->short_description_cabang . '-' . $value->code_sales;

      $rsInvoiceReceiptDetail[] = $invoiceManifestDetail;
    }

    return $rsInvoiceReceiptDetail;
  }

  public function show(Request $request, $id)
  {
    $invoiceReceiptHeader = InvoiceReceiptHeader::findOrFail($id);

    $data['invoiceReceiptHeader'] = $invoiceReceiptHeader;

    if ($request->ajax()) {
      // $amountInvoice = $data['invoiceReceiptHeader']->getAmountInvoice();

      $query = $data['invoiceReceiptHeader']->details()->select(
        'log_invoice_receipt_detail.do_manifest_no',
        'log_invoice_receipt_detail.do_manifest_date',
        'log_invoice_receipt_detail.vehicle_number',
        'log_invoice_receipt_detail.vehicle_description',
        'log_invoice_receipt_detail.city_name',
        DB::raw('SUM(cbm_do) AS cbm_do'),
        DB::raw('SUM(cbm_amount) AS cbm_amount'),
        DB::raw('SUM(ritase_amount) AS ritase_amount'),
        DB::raw('SUM(ritase2_amount) AS ritase2_amount'),
        DB::raw('SUM(multidro_amount) AS multidro_amount'),
        DB::raw('SUM(unloading_amount) AS unloading_amount'),
        DB::raw('SUM(overstay_amount) AS overstay_amount'),
        DB::raw('COUNT(DISTINCT(delivery_no)) AS count_of_do')
      )
        ->groupBy('do_manifest_no');

      $datatables = DataTables::of($query)
        ->addIndexColumn() //DT_RowIndex (Penomoran)
        ->editColumn('cbm_amount', function ($data) {
          return !empty($data->cbm_amount) ? thousand_reformat($data->cbm_amount) : 0;
        })
        ->editColumn('ritase_amount', function ($data) {
          return !empty($data->ritase_amount) ? thousand_reformat($data->ritase_amount) : 0;
        })
        ->editColumn('ritase2_amount', function ($data) {
          return !empty($data->ritase2_amount) ? thousand_reformat($data->ritase2_amount) : 0;
        })
        ->editColumn('multidro_amount', function ($data) {
          return !empty($data->multidro_amount) ? thousand_reformat($data->multidro_amount) : 0;
        })
        ->editColumn('unloading_amount', function ($data) {
          return !empty($data->unloading_amount) ? thousand_reformat($data->unloading_amount) : 0;
        })
        ->editColumn('overstay_amount', function ($data) {
          return !empty($data->overstay_amount) ? thousand_reformat($data->overstay_amount) : 0;
        })
        ->addColumn('total', function ($data) {
          return thousand_reformat($data->cbm_amount + $data->ritase_amount + $data->ritase2_amount + $data->multidro_amount + $data->unloading_amount + $data->overstay_amount);
        })
        ->addColumn('action_view', function ($data) {
          return get_button_view(url('receipt-invoice/' . $data->id));
        })
        ->addColumn('action_delete', function ($data) use ($invoiceReceiptHeader) {
          return empty($invoiceReceiptHeader->receiptInvoiceConfirm) ? get_button_delete() : '';
        })
        ->rawColumns(['action_view', 'action_delete']);

      return $datatables->with('invoiceReceiptHeader', $data['invoiceReceiptHeader'])->make(true);
    }

    return view('web.invoicing.receipt-invoice.view', $data);
  }

  public function destroy($id)
  {
    $header = InvoiceReceiptHeader::findOrFail($id);
    try {
      DB::beginTransaction();
      InvoiceReceiptDetail::where('id_header', $id)->delete();
      $header->delete();
      DB::commit();

      return sendSuccess('Receipt Invoice Deleted.', $header);
    } catch (Exception $e) {
      DB::rollback();
    }
  }

  public function submitToAccounting($id)
  {
    $header = InvoiceReceiptHeader::findOrFail($id);

    $confirm = new InvoiceReceiptConfirm;

    $confirm->invoice_receipt_id = $header->invoice_receipt_id;
    $confirm->expedition_name = $header->expedition_name;
    $confirm->invoice_date = $header->invoice_receipt_date;
    $confirm->confirm_by = auth()->user()->username;
    $confirm->confirm_date = date('Y-m-d H:i:s');

    $confirm->save();

    return sendSuccess('Success submit to accounting.', $confirm);
  }

  public function destroyManifest($id, $do_manifest_no)
  {
    $invoiceReceiptHeader = InvoiceReceiptHeader::findOrFail($id);

    $detail = InvoiceReceiptDetail::where('id_header', $id)->where('do_manifest_no', $do_manifest_no);
    $detail->delete();

    $invoiceReceiptHeader->updateAmountInvoice();

    return sendSuccess('Manifest deleted.', $detail);
  }

  public function updateReceiptInvoice(Request $request, $id)
  {
    $request->validate([
      // 'kwitansi_no' => 'required',
    ]);

    $invoiceReceiptHeader = InvoiceReceiptHeader::findOrFail($id);

    $invoiceReceiptHeader->kwitansi_no = $request->input('kwitansi_no');

    if (empty($invoiceReceiptHeader->invoice_receipt_id)) {
      $kode   = auth()->user()->area == 'All' ? 'INV' : auth()->user()->area_data->code;
      $prefix = $kode . '-FAKTUR-' . date('ymd') . '-N';

      $prefix_length = strlen($prefix);
      $max_no        = DB::select('SELECT MAX(SUBSTR(invoice_receipt_id, ?)) AS max_no FROM log_invoice_receipt_header WHERE SUBSTR(invoice_receipt_id,1,?) = ? ', [$prefix_length + 2, $prefix_length, $prefix])[0]->max_no;
      $max_no        = str_pad($max_no + 1, 2, 0, STR_PAD_LEFT);

      $invoice_receipt_id = $prefix . $max_no;

      $invoiceReceiptHeader->invoice_receipt_id = $invoice_receipt_id;
    }

    $invoiceReceiptHeader->save();

    return sendSuccess("Create Receipt ID " . $invoiceReceiptHeader->invoice_receipt_id . " success.", $invoiceReceiptHeader);
  }

  public function updatePPN(Request $request, $id)
  {

    $invoiceReceiptHeader = InvoiceReceiptHeader::findOrFail($id);

    // $invoiceReceiptHeader->kwitansi_no      = $request->input('kwitansi_no');
    $invoiceReceiptHeader->amount_pph       = str_replace(',', '', $request->input('amount_pph'));
    $invoiceReceiptHeader->amount_ppn       = str_replace(',', '', $request->input('amount_ppn'));
    $invoiceReceiptHeader->amount_after_tax = $invoiceReceiptHeader->amount_before_tax + $invoiceReceiptHeader->amount_pph + $invoiceReceiptHeader->amount_ppn;

    $invoiceReceiptHeader->save();

    return sendSuccess("Update PPN success.", $invoiceReceiptHeader);
  }

  public function updateRemarks(Request $request, $id){
    $invoiceReceiptHeader = InvoiceReceiptHeader::findOrFail($id);

    $invoiceReceiptHeader->remarks       = $request->input('remarks');

    $invoiceReceiptHeader->save();

    return sendSuccess("Remarks Updated.", $invoiceReceiptHeader);
  }

  public function createReceiptNo($id)
  {
    $invoiceReceiptHeader = InvoiceReceiptHeader::findOrFail($id);

    $max_no = DB::select('SELECT MAX(SUBSTR(invoice_receipt_no, 1, 3)) AS max_no FROM log_invoice_receipt_header where YEAR(invoice_receipt_date) = ? AND MONTH(invoice_receipt_date) = ?', [date('Y'), date('m')])[0]->max_no;

    $max_no = str_pad($max_no + 1, 3, 0, STR_PAD_LEFT);

    $invoice_receipt_no = $max_no . '/' . getRomawi(date('m')) . '/DIST.SLOG/KU.SEID/' . date('y');

    $invoiceReceiptHeader->invoice_receipt_no   = $invoice_receipt_no;
    $invoiceReceiptHeader->invoice_receipt_date = date('Y-m-d');

    $invoiceReceiptHeader->save();

    return sendSuccess("Create Receipt No " . $invoiceReceiptHeader->invoice_receipt_no . " success.", $invoiceReceiptHeader);
  }

  public function exportReceiptNo(Request $request, $id)
  {
    $data['invoiceReceiptHeader'] = InvoiceReceiptHeader::findOrFail($id);
    $data['remarks'] = $request->input('remarks');

    $view_print = view('web.invoicing.receipt-invoice._print_receipt_no', $data);
    $title      = 'receipt_no';

    if ($request->input('filetype') == 'html') {

      // request HTML View
      return $view_print;
    } elseif ($request->input('filetype') == 'xls') {

      // Request FILE EXCEL
      $reader      = new \PhpOffice\PhpSpreadsheet\Reader\Html();
      $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

      $spreadsheet = $reader->loadFromString($view_print, $spreadsheet);

      // Set warna background putih
      $spreadsheet->getActiveSheet()->getStyle('A1:X1000')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('ffffff');
      // Set Font
      $spreadsheet->getActiveSheet()->getStyle('A1:X1000')->getFont()->setName('courier New');

      // Atur lebar kolom
      $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(11);
      $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(11);
      $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(11);
      $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(2.5);
      $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(11);
      $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(11);
      $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(11);
      $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(11);
      $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(11);
      $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(11);
      $spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(11);
      $spreadsheet->getActiveSheet()->getColumnDimension('L')->setWidth(11);
      $spreadsheet->getActiveSheet()->getColumnDimension('M')->setWidth(11);
      $spreadsheet->getActiveSheet()->getColumnDimension('N')->setWidth(11);
      $spreadsheet->getActiveSheet()->getColumnDimension('O')->setWidth(11);
      $spreadsheet->getActiveSheet()->getColumnDimension('P')->setWidth(2.5);
      $spreadsheet->getActiveSheet()->getColumnDimension('Q')->setWidth(11);
      $spreadsheet->getActiveSheet()->getColumnDimension('R')->setWidth(11);
      $spreadsheet->getActiveSheet()->getColumnDimension('S')->setWidth(11);
      $spreadsheet->getActiveSheet()->getColumnDimension('T')->setWidth(11);
      $spreadsheet->getActiveSheet()->getColumnDimension('U')->setWidth(11);
      $spreadsheet->getActiveSheet()->getColumnDimension('V')->setWidth(11);
      $spreadsheet->getActiveSheet()->getColumnDimension('W')->setWidth(11);
      $spreadsheet->getActiveSheet()->getColumnDimension('X')->setWidth(11);

      $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment; filename="' . $title . '.xls"');

      $writer->save("php://output");
    } else if ($request->input('filetype') == 'pdf') {

      // REQUEST PDF
      $mpdf = new \Mpdf\Mpdf([
        'tempDir'       => '/tmp',
        'margin_left'   => 2,
        'margin_right'  => 2,
        'margin_top'    => 5,
        'margin_bottom' => 5,
        'format'        => 'A4',
        'orientation'   => 'L',
      ]);

      $mpdf->WriteHTML($view_print, \Mpdf\HTMLParserMode::HTML_BODY);

      $mpdf->Output($title . '.pdf', "D");
    } else {
      // Parameter filetype tidak valid / tidak ditemukan return 404
      return redirect(404);
    }
  }

  public function exportReceiptInvoice(Request $request, $id)
  {
    $data['invoiceReceiptHeader'] = InvoiceReceiptHeader::findOrFail($id);
    $data['request']              = $request;

    // echo "<pre>";
    // print_r($data['invoiceReceiptHeader']->getPrintReceiptData());
    // echo "</pre>";
    // return;

    $view_print = view('web.invoicing.receipt-invoice._print_receipt_invoice', $data);
    $title      = 'receipt_invoice';

    if ($request->input('filetype') == 'html') {

      // request HTML View
      // return $view_print;
      // REQUEST PDF
      $mpdf = new \Mpdf\Mpdf([
        'tempDir'       => '/tmp',
        'margin_left'   => 2,
        'margin_right'  => 2,
        'margin_top'    => 35,
        'margin_bottom' => 5,
        'format'        => 'A4',
        'orientation'   => 'L',
      ]);

      $mpdf->shrink_tables_to_fit = 1;
      $mpdf->WriteHTML($view_print, \Mpdf\HTMLParserMode::HTML_BODY);

      $mpdf->Output();
      return;
    } elseif ($request->input('filetype') == 'xls') {

      // Request FILE EXCEL
      $reader      = new \PhpOffice\PhpSpreadsheet\Reader\Html();
      $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

      $spreadsheet = $reader->loadFromString($view_print, $spreadsheet);

      // Set warna background putih
      $spreadsheet->getActiveSheet()->getStyle('A1:X1000')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('ffffff');
      // Set Font
      $spreadsheet->getActiveSheet()->getStyle('A1:X1000')->getFont()->setName('courier New');

      // Atur lebar kolom
      $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(6);
      $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(1);
      $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(3);
      $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(20);
      $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(2.3);
      $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(10.3);
      $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(10.3);
      $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(6.2);
      $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(14);
      $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(15);
      $spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(13);
      $spreadsheet->getActiveSheet()->getColumnDimension('L')->setWidth(12);
      $spreadsheet->getActiveSheet()->getColumnDimension('M')->setWidth(20);
      $spreadsheet->getActiveSheet()->getColumnDimension('N')->setWidth(13.7);
      $spreadsheet->getActiveSheet()->getColumnDimension('O')->setWidth(11);
      $spreadsheet->getActiveSheet()->getColumnDimension('P')->setWidth(12.4);
      $spreadsheet->getActiveSheet()->getColumnDimension('Q')->setWidth(17.4);
      $spreadsheet->getActiveSheet()->getColumnDimension('R')->setWidth(15.5);
      $spreadsheet->getActiveSheet()->getColumnDimension('S')->setWidth(10.8);
      $spreadsheet->getActiveSheet()->getColumnDimension('T')->setWidth(26);
      $spreadsheet->getActiveSheet()->getColumnDimension('U')->setWidth(17.5);
      $spreadsheet->getActiveSheet()->getColumnDimension('V')->setWidth(14.1);
      $spreadsheet->getActiveSheet()->getColumnDimension('W')->setWidth(6.7);
      $spreadsheet->getActiveSheet()->getColumnDimension('X')->setWidth(12);

      $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment; filename="' . $title . '.xls"');

      $writer->save("php://output");
    } else if ($request->input('filetype') == 'pdf') {

      // REQUEST PDF
      $mpdf = new \Mpdf\Mpdf([
        'tempDir'       => '/tmp',
        'margin_left'   => 2,
        'margin_right'  => 2,
        'margin_top'    => 35,
        'margin_bottom' => 5,
        'format'        => 'A4',
        'orientation'   => 'L',
      ]);

      $mpdf->shrink_tables_to_fit = 1;
      $mpdf->WriteHTML($view_print, \Mpdf\HTMLParserMode::HTML_BODY);

      $mpdf->Output($title . '.pdf', "D");
    } else {
      // Parameter filetype tidak valid / tidak ditemukan return 404
      return redirect(404);
    }
  }

  public function getListDo(Request $request, $id_header)
  {
    $query = InvoiceReceiptDetail::where('id_header', $id_header)
      ->where('do_manifest_no', $request->input('do_manifest_no'));

    $datatables = DataTables::of($query)
      ->addIndexColumn() //DT_RowIndex (Penomoran)
      ->editColumn('cbm_amount', function ($data) {
        return !empty($data->cbm_amount) ? thousand_reformat($data->cbm_amount) : 0;
      })
      ->editColumn('ritase_amount', function ($data) {
        return !empty($data->ritase_amount) ? thousand_reformat($data->ritase_amount) : 0;
      })
      ->editColumn('ritase2_amount', function ($data) {
        return !empty($data->ritase2_amount) ? thousand_reformat($data->ritase2_amount) : 0;
      })
      ->editColumn('multidro_amount', function ($data) {
        return !empty($data->multidro_amount) ? thousand_reformat($data->multidro_amount) : 0;
      })
      ->editColumn('unloading_amount', function ($data) {
        return !empty($data->unloading_amount) ? thousand_reformat($data->unloading_amount) : 0;
      })
      ->editColumn('overstay_amount', function ($data) {
        return !empty($data->overstay_amount) ? thousand_reformat($data->overstay_amount) : 0;
      })
      ->addColumn('total', function ($data) {
        return thousand_reformat($data->cbm_amount + $data->ritase_amount + $data->ritase2_amount + $data->multidro_amount + $data->unloading_amount + $data->overstay_amount);
      })
      ->addColumn('action_view', function ($data) {
        return get_button_view('#!');
      })
      ->addColumn('action_delete', function ($data) {
        return get_button_delete();
      })
      ->rawColumns(['action_view', 'action_delete']);

    return $datatables->make(true);
  }

  public function getDOData(Request $request, $id_header)
  {
    $query = LogManifestDetail::where('do_manifest_no', $request->input('do_manifest_no'))
      ->where('delivery_no', $request->input('delivery_no'))
      ->get();

    return sendSuccess('Success retrive data', $query);
  }

  public function updateDOData(Request $request, $id_header)
  {
    $invoiceReceiptHeader = InvoiceReceiptHeader::findOrFail($id_header);

    $detail = InvoiceReceiptDetail::findOrFail($request->input('id'));

    $detail->multidro_amount  = $request->input('multidro_amount');
    $detail->unloading_amount = $request->input('unloading_amount');
    $detail->overstay_amount  = $request->input('overstay_amount');
    $detail->ritase2_amount   = $request->input('ritase2_amount');

    $detail->freight_cost = $request->input('freight_cost');
    $detail->cbm_amount   = $detail->cbm_do * $detail->freight_cost;

    $detail->save();
    $invoiceReceiptHeader->updateAmountInvoice();

    return sendSuccess('Cost Per DO Updated.', $detail);
  }

  public function updateDODataDetail(Request $request, $id_header, $manifest_detail_id)
  {
    // dd($request->all(), $id_header, $manifest_detail_id);
    $invoiceReceiptHeader = InvoiceReceiptHeader::findOrFail($id_header);

    $invoiceReceiptDetail = InvoiceReceiptDetail::findOrFail($request->input('id'));
    $manifestDetail       = LogManifestDetail::findOrFail($manifest_detail_id);

    // update cbm do
    $invoiceReceiptDetail->cbm_do = $invoiceReceiptDetail->cbm_do - $manifestDetail->cbm + ($request->input('cbm') * $manifestDetail->quantity);

    $manifestDetail->cbm = $request->input('cbm') * $manifestDetail->quantity;

    $invoiceReceiptDetail->cbm_amount -= $manifestDetail->nilai_cbm;

    $manifestDetail->nilai_cbm = $manifestDetail->cbm * $manifestDetail->base_price;
    $invoiceReceiptDetail->cbm_amount += $manifestDetail->nilai_cbm;

    try {
      DB::beginTransaction();

      $manifestDetail->save();
      $invoiceReceiptDetail->save();
      $invoiceReceiptHeader->updateAmountInvoice();

      DB::commit();

      return sendSuccess('DO Detail Updated.', $invoiceReceiptDetail);
    } catch (Exception $e) {
      DB::rollback();
    }
  }
}
