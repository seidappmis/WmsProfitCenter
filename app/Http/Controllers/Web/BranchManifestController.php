<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\LMBHeader;
use App\Models\ManualConcept;
use App\Models\WMSBranchManifestDetail;
use App\Models\WMSBranchManifestHeader;
use DataTables;
use DB;
use Illuminate\Http\Request;

class BranchManifestController extends Controller
{
  public function index(Request $request)
  {
    if ($request->ajax()) {
      $query = WMSBranchManifestHeader::all();

      $datatables = DataTables::of($query)
        ->addIndexColumn() //DT_RowIndex (Penomoran)
        ->addColumn('picking_no', function ($data) {
          return $data->picking->picking_no;
        })
        ->addColumn('status', function ($data) {
          return $data->status();
        })
        ->addColumn('action', function ($data) {
          $action = '';
          $action .= ' ' . get_button_view(url('branch-manifest/' . $data->driver_register_id . '/edit'), 'View');
          return $action;
        })
        ->rawColumns(['do_status', 'action']);

      return $datatables->make(true);
    }

    return view('web.outgoing.branch-manifest.index');
  }

  public function truckWaitingManifest(Request $request)
  {
    if ($request->ajax()) {
      $query = LMBHeader::noManifestLMBHeader()
        ->where('wms_lmb_header.kode_cabang', auth()->user()->cabang->kode_cabang)
        ->get();

      $datatables = DataTables::of($query)
        ->addIndexColumn() //DT_RowIndex (Penomoran)
        ->addColumn('picking_no', function ($data) {
          return $data->picking->picking_no;
        })
        ->addColumn('action', function ($data) {
          $action = '';
          $action .= ' ' . get_button_view(url('branch-manifest/' . $data->driver_register_id . '/create-manifest'), 'Create');
          return $action;
        })
        ->rawColumns(['do_status', 'action']);

      return $datatables->make(true);
    }
  }

  public function createManifest($lmb_id)
  {
    $data['lmbHeader'] = LMBHeader::find($lmb_id);

    return view('web.outgoing.branch-manifest.create', $data);
  }

  public function store(Request $request)
  {
    $request->validate([
      'driver_register_id' => 'required',
    ]);

    $manifestHeader = new WMSBranchManifestHeader;

    // DO MANIFEST NO => KODEAREA-ymd-URUT
    $prefix = auth()->user()->cabang->short_description . '-' . date('ymd');

    $prefix_length = strlen($prefix);
    $max_no        = DB::select('SELECT MAX(SUBSTR(do_manifest_no, ?)) AS max_no FROM log_manifest_header WHERE SUBSTR(do_manifest_no,1,?) = ? ', [$prefix_length + 2, $prefix_length, $prefix])[0]->max_no;
    $max_no        = str_pad($max_no + 1, 3, 0, STR_PAD_LEFT);

    $do_manifest_no = $prefix . '-' . $max_no;

    $manifestHeader->driver_register_id          = $request->input('driver_register_id');
    $manifestHeader->do_manifest_no              = $do_manifest_no;
    $manifestHeader->expedition_code             = $request->input('expedition_code');
    $manifestHeader->expedition_name             = $request->input('expedition_name');
    $manifestHeader->driver_id                   = $request->input('driver_id');
    $manifestHeader->driver_name                 = $request->input('driver_name');
    $manifestHeader->vehicle_number              = $request->input('vehicle_number');
    $manifestHeader->vehicle_code_type           = $request->input('vehicle_code_type');
    $manifestHeader->vehicle_description         = $request->input('vehicle_description');
    $manifestHeader->do_manifest_date            = $request->input('do_manifest_date');
    $manifestHeader->do_manifest_time            = date('Y-m-d H:i:s');
    $manifestHeader->destination_number_driver   = $request->input('destination_number_driver');
    $manifestHeader->destination_name_driver     = $request->input('destination_name_driver');
    $manifestHeader->city_code                   = $request->input('city_code');
    $manifestHeader->city_name                   = $request->input('city_name');
    $manifestHeader->container_no                = $request->input('container_no');
    $manifestHeader->seal_no                     = $request->input('seal_no');
    $manifestHeader->checker                     = $request->input('checker');
    $manifestHeader->pdo_no                      = $request->input('pdo_no');
    $manifestHeader->kode_cabang                 = auth()->user()->cabang->kode_cabang;
    $manifestHeader->status_complete             = 0;
    $manifestHeader->urut_manifest               = 1;
    $manifestHeader->tcs                         = 0;
    $manifestHeader->ambil_sendiri               = 0;
    $manifestHeader->id_freight_cost             = $request->input('id_freight_cost');
    $manifestHeader->ritase                      = 0;
    $manifestHeader->cbm                         = 0;
    $manifestHeader->manifest_return             = 0;
    $manifestHeader->manifest_type               = 'Regular';
    $manifestHeader->status_inv_recieve          = 0;
    $manifestHeader->have_lcl                    = 0;
    $manifestHeader->lcl_from_driver_register_id = $request->input('lcl_from_driver_register_id');
    $manifestHeader->lcl_from_manifest_no        = $request->input('lcl_from_manifest_no');
    $manifestHeader->lcl_created_date            = $request->input('lcl_created_date');
    $manifestHeader->lcl_created_by              = $request->input('lcl_created_by');
    $manifestHeader->have_resend                 = 0;
    $manifestHeader->manifest_resend             = 0;
    $manifestHeader->r_from_manifest             = $request->input('r_from_manifest');
    $manifestHeader->r_driver_register_id        = $request->input('r_driver_register_id');
    $manifestHeader->r_created_date              = $request->input('r_create_date');
    $manifestHeader->r_created_by                = $request->input('r_create_by');

    $manifestHeader->save();

    return $manifestHeader;
  }

  public function edit($id)
  {
    $data['manifestHeader'] = WMSBranchManifestHeader::findOrFail($id);
    $data['lmbHeader']      = $data['manifestHeader']->lmb;
    $data['doData']         = [];

    return view('web.outgoing.branch-manifest.edit', $data);
  }

  public function assignDO(Request $request, $id)
  {
    $manifestHeader = WMSBranchManifestHeader::findOrFail($id);

    $selected_list = json_decode($request->input('selected_list'), true);

    $rs_manifest_detail = [];
    foreach ($selected_list as $key => $value) {
      // print_r($value);

      $concept = ManualConcept::where('delivery_no', $value['delivery_no'])
        ->where('invoice_no', $value['invoice_no'])
        ->where('model', $value['model'])->first();

      $manifestDetail['do_manifest_no'] = $request->input('do_manifest_no');
      // $manifestDetail['no_urut']             = '';
      $manifestDetail['delivery_no']           = $value['delivery_no'];
      $manifestDetail['delivery_items']        = $value['delivery_items'];
      $manifestDetail['invoice_no']            = $value['invoice_no'];
      $manifestDetail['ambil_sendiri']         = 0;
      $manifestDetail['model']                 = $value['model'];
      $manifestDetail['expedition_code']       = $manifestHeader->expedition_code;
      $manifestDetail['expedition_name']       = $manifestHeader->expedition_name;
      $manifestDetail['sold_to']               = $concept->sold_to;
      $manifestDetail['sold_to_code']          = $concept->sold_to_code;
      $manifestDetail['sold_to_street']        = $concept->sold_to_street;
      $manifestDetail['ship_to']               = $concept->ship_to;
      $manifestDetail['ship_to_code']          = $concept->ship_to_code;
      $manifestDetail['city_code']             = $request->input('city_code');
      $manifestDetail['city_name']             = $request->input('city_name');
      $manifestDetail['do_date']               = $manifestHeader->do_manifest_date;
      $manifestDetail['quantity']              = $value['quantity'];
      $manifestDetail['cbm']                   = $value['cbm'];
      $manifestDetail['do_internal']           = $request->input('do_internal');
      $manifestDetail['reservasi_no']          = $request->input('reservasi_no');
      $manifestDetail['nilai_ritase']          = '';
      $manifestDetail['nilai_ritase2']         = '';
      $manifestDetail['nilai_cbm']             = '';
      $manifestDetail['code_sales']            = $concept->code_sales;
      $manifestDetail['tcs']                   = '';
      $manifestDetail['do_return']             = '';
      $manifestDetail['status_confirm']        = '';
      $manifestDetail['confirm_date']          = '';
      $manifestDetail['confirm_by']            = '';
      $manifestDetail['lead_time']             = '';
      $manifestDetail['kode_cabang']           = substr($value['kode_customer'], 0, 2);
      $manifestDetail['region']                = '';
      $manifestDetail['actual_time_arrival']   = '';
      $manifestDetail['actual_unloading_date'] = '';
      $manifestDetail['doc_do_return_date']    = '';
      $manifestDetail['do_reject']             = 0;

      $rs_manifest_detail[] = $manifestDetail;
    }

    $manifestHeader->tcs = 1;

    try {
      DB::beginTransaction();

      $manifestHeader->save();
      WMSBranchManifestDetail::insert($rs_manifest_detail);

      DB::commit();

      return sendSuccess('Success submit to logsys', $manifestHeader);
    } catch (Exception $e) {
      DB::rollBack();
    }

  }

  public function export(Request $request, $id)
  {
    $data['branchManifestHeader'] = WMSBranchManifestHeader::find($id);

    $view_print = view('web.outgoing.branch-manifest._print', $data);
    $title      = 'Branch Manifest';

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
      $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(20);
      $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(5);
      $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(5);
      $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(5);
      $spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
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
}
