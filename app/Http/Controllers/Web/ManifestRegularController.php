<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Concept;
use App\Models\FreightCost;
use App\Models\LMBHeader;
use App\Models\LogManifestDetail;
use App\Models\LogManifestHeader;
use App\Models\MasterCabang;
use App\Models\MasterModel;
use DataTables;
use DB;
use Illuminate\Http\Request;

class ManifestRegularController extends Controller
{
  public function index(Request $request)
  {
    if ($request->ajax()) {
      $query = LogManifestHeader::select('log_manifest_header.*')
        ->where('city_name', '<>', 'Ambil Sendiri')
      ;

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
          $action .= ' ' . get_button_view(url('manifest-regular/' . $data->do_manifest_no . '/edit'), 'View');
          return $action;
        })
        ->rawColumns(['do_status', 'action']);

      return $datatables->make(true);
    }

    return view('web.outgoing.manifest-regular.index');
  }

  public function listDO(Request $request, $do_manifest_no)
  {
    if ($request->ajax()) {
      $query = LogManifestDetail::select('log_manifest_detail.*')
        ->where('do_manifest_no', $do_manifest_no)
      ;

      $datatables = DataTables::of($query)
        ->addIndexColumn() //DT_RowIndex (Penomoran)
        ->addColumn('desc', function ($data) {
          return $data->getDesc();
        })
        ->addColumn('action', function ($data) {
          $action = '';
          $action .= ' ' . get_button_delete();
          return $action;
        })
        ->rawColumns(['do_status', 'action']);

      return $datatables->make(true);
    }
  }

  public function truckWaitingManifest(Request $request)
  {
    if ($request->ajax()) {
      $query = LMBHeader::noManifestLMBHeader()
        ->where('wms_lmb_header.expedition_code', '<>', 'AS')
        ->get();

      $datatables = DataTables::of($query)
        ->addIndexColumn() //DT_RowIndex (Penomoran)
        ->addColumn('picking_no', function ($data) {
          return $data->picking->picking_no;
        })
        ->addColumn('action', function ($data) {
          $action = '';
          $action .= ' ' . get_button_view(url('manifest-regular/' . $data->driver_register_id . '/create-manifest'), 'Create');
          return $action;
        })
        ->rawColumns(['do_status', 'action']);

      return $datatables->make(true);
    }
  }

  public function createManifest($lmb_id)
  {
    $data['lmbHeader'] = LMBHeader::find($lmb_id);

    return view('web.outgoing.manifest-regular.create', $data);
  }

  public function store(Request $request)
  {
    $request->validate([
      'driver_register_id' => 'required',
    ]);

    $manifestHeader = new LogManifestHeader;

    // DO MANIFEST NO => KODEAREA-ymd-URUT
    $prefix = auth()->user()->area_data->code . '-' . date('ymd');

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
    $manifestHeader->area                        = auth()->user()->area;
    $manifestHeader->status_complete             = 0;
    $manifestHeader->urut_manifest               = 1;
    $manifestHeader->tcs                         = 0;
    $manifestHeader->ambil_sendiri               = 0;
    $manifestHeader->ritase                      = 0;
    $manifestHeader->cbm                         = 0;
    $manifestHeader->manifest_return             = 0;
    $manifestHeader->manifest_type               = 'NORMAL';
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
    $manifestHeader->r_create_date               = $request->input('r_create_date');
    $manifestHeader->r_create_by                 = $request->input('r_create_by');

    $freightCost = FreightCost::where('area', $manifestHeader->area)
      ->where('vehicle_code_type', $manifestHeader->vehicle_code_type)
      ->where('expedition_code', $manifestHeader->expedition_code)
      ->where('city_code', $manifestHeader->city_code)
      ->first();

    $manifestHeader->id_freight_cost = $freightCost->id;

    $manifestHeader->save();

    return $manifestHeader;
  }

  public function destroyDO(Request $request)
  {
    $detail = LogManifestDetail::findOrFail($request->input('id'));

    $detail->delete();

    return sendSuccess('DO deleted.', $detail);
  }

  public function edit($id)
  {
    $data['manifestHeader'] = LogManifestHeader::findOrFail($id);
    $data['lmbHeader']      = $data['manifestHeader']->lmb;
    $data['doData']         = [];

    return view('web.outgoing.manifest-regular.edit', $data);
  }

  public function assignDO(Request $request, $id)
  {
    $manifestHeader = LogManifestHeader::findOrFail($id);

    $selected_list = json_decode($request->input('selected_list'), true);

    $rs_manifest_detail = [];
    foreach ($selected_list as $key => $value) {
      // print_r($value);

      $concept = Concept::where('delivery_no', $value['delivery_no'])
        ->where('invoice_no', $value['invoice_no'])
        ->where('model', $value['model'])->first();

      $manifestDetail['do_manifest_no'] = $request->input('do_manifest_no');
      // $manifestDetail['no_urut']             = '';
      $manifestDetail['delivery_no']     = $value['delivery_no'];
      $manifestDetail['delivery_items']  = $value['delivery_items'];
      $manifestDetail['invoice_no']      = $value['invoice_no'];
      $manifestDetail['line_no']         = $value['line_no'];
      $manifestDetail['ambil_sendiri']   = 0;
      $manifestDetail['model']           = $value['model'];
      $manifestDetail['expedition_code'] = $manifestHeader->expedition_code;
      $manifestDetail['expedition_name'] = $manifestHeader->expedition_name;
      $manifestDetail['sold_to']         = $concept->sold_to;
      $manifestDetail['sold_to_code']    = $concept->sold_to_code;
      $manifestDetail['sold_to_street']  = $concept->sold_to_street;
      $manifestDetail['ship_to']         = $concept->ship_to;
      $manifestDetail['ship_to_code']    = $concept->ship_to_code;
      $manifestDetail['city_code']       = $manifestHeader->city_code;
      $manifestDetail['city_name']       = $manifestHeader->city_name;
      $manifestDetail['do_date']         = $manifestHeader->do_manifest_date;
      $manifestDetail['quantity']        = $value['quantity'];
      $manifestDetail['cbm']             = $value['cbm'];
      $manifestDetail['area']            = $manifestHeader->area;
      $manifestDetail['do_internal']     = $request->input('do_internal');
      $manifestDetail['reservasi_no']    = $request->input('reservasi_no');
      // $manifestDetail['nilai_ritase']        = '';
      // $manifestDetail['nilai_ritase2']       = '';
      // $manifestDetail['nilai_cbm']           = '';
      $manifestDetail['code_sales'] = $concept->code_sales;
      $manifestDetail['tcs']        = 1;
      // $manifestDetail['multidro']            = '';
      // $manifestDetail['unloading']           = '';
      // $manifestDetail['overstay']            = '';
      // $manifestDetail['do_return']           = '';
      // $manifestDetail['status_confirm']      = '';
      // $manifestDetail['confirm_date']        = '';
      // $manifestDetail['confirm_by']          = '';
      // $manifestDetail['lead_time']           = '';
      $manifestDetail['base_price']  = '';
      $manifestDetail['kode_cabang'] = substr($value['kode_customer'], 0, 2);
      $manifestDetail['region']      = '';
      // $manifestDetail['remarks']             = '';
      // $manifestDetail['actual_time_arrival'] = '';
      // $manifestDetail['actual_loading_date'] = '';
      // $manifestDetail['doc_do_return_date']  = '';
      $manifestDetail['status_ds_done'] = 0;
      $manifestDetail['do_reject']      = 0;

      $rs_manifest_detail[] = $manifestDetail;
    }

    $manifestHeader->tcs = 1;

    try {
      DB::beginTransaction();

      LogManifestDetail::insert($rs_manifest_detail);
      // if ($manifestHeader->lmb->do_details->count() == 0) {
      //   $manifestHeader->status_complete = 1;
      // }

      $manifestHeader->save();
      DB::commit();

      return sendSuccess('Success submit to logsys', $manifestHeader);

    } catch (Exception $e) {
      DB::rollBack();
    }
  }

  public function uploadDO(Request $request, $do_manifest_no)
  {
    $request->validate([
      'file-do' => 'required',
    ]);

    $manifestHeader = LogManifestHeader::findOrFail($do_manifest_no);

    $file = fopen($request->file('file-do'), "r");

    $title         = true; // Untuk Penada Baris pertama adalah Judul
    $rs_do         = [];
    $rs_model      = [];
    $rs_code_sales = [];

    while (!feof($file)) {
      $row = fgetcsv($file);
      if ($title) {
        $title = false;
        continue; // Skip baris judul
      }

      if (!empty($row[5])) {
        $do = [];

        $do['invoice_no']     = $row[5];
        $do['delivery_no']    = $row[1];
        $do['delivery_items'] = $row[4];
        $do['line_no']        = $row[4];
        $do['do_date']        = $row[2];
        $do['sold_to_code']   = $row[7];
        $do['sold_to']        = $row[8];
        $do['ship_to_code']   = $row[7];
        $do['ship_to']        = $row[8];
        $do['model']          = $row[9];
        $do['quantity']       = $row[10];
        $do['cbm']            = $row[15];
        $do['area']           = auth()->user()->area;
        // $do['kode_cabang']     = auth()->user()->cabang->kode_cabang;
        $do['kode_cabang']   = substr($do['sold_to_code'], 0, 2);
        $do['remarks']       = '-';
        $do['created_by']    = auth()->user()->id;
        $do['created_at']    = date('Y-m-d H:i:s');
        $do['ambil_sendiri'] = 0;
        $do['tcs']           = 0;
        if ($request->input('type') == 'return') {
          $do['do_return'] = 1;
        }
        $do['expedition_code'] = $manifestHeader->expedition_code;
        $do['expedition_name'] = $manifestHeader->expedition_name;
        $do['city_code']       = $request->input('ship_to');
        $do['city_name']       = $request->input('city_name');
        $do['do_date']         = $manifestHeader->do_manifest_date;
        $do['do_manifest_no']  = $manifestHeader->do_manifest_no;
        $do['do_internal']     = $request->input('do_internal');
        $do['reservasi_no']    = $request->input('reservasi_no');

        if (empty($rs_model[$do['model']])) {
          $model = MasterModel::where('model_name', $do['model'])->first();

          $rs_model[$do['model']] = $model;
        }

        if (empty($rs_code_sales[$do['sold_to_code']])) {
          $cabang                             = MasterCabang::where('kode_customer', $do['sold_to_code'])->first();
          $rs_code_sales[$do['sold_to_code']] = empty($cabang) ? 'DS' : 'BR';
        }

        $do['code_sales'] = $rs_code_sales[$do['sold_to_code']];

        // $do['ean_code'] = !empty($rs_model[$do['model']]) ? $rs_model[$do['model']]->ean_code : '';

        $rs_do[] = $do;
      }
    }

    LogManifestDetail::insert($rs_do);

    return sendSuccess('DO Uploaded', $rs_do);
  }

  public function export(Request $request, $id)
  {
    $data['manifestHeader'] = LogManifestHeader::findOrFail($id);

    $rs_details = [];
    foreach ($data['manifestHeader']->details as $key => $value) {
      $rs_details[$value->ship_to_code . $value->ship_to . $value->do_internal]['data']     = $value;
      $rs_details[$value->ship_to_code . $value->ship_to . $value->do_internal]['models'][] = $value;
    }

    $data['rs_details'] = $rs_details;

    $view_print = view('web.outgoing.manifest-regular._print', $data);
    $title      = 'Manifest Reguler';

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
}
