<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\IncomingManualDetail;
use App\Models\IncomingManualHeader;
use App\Models\InventoryStorage;
use App\Models\MasterModel;
use App\Models\MovementTransactionLog;
use App\Models\MovementTransactionType;
use App\Models\StorageMaster;
use DataTables;
use DB;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class IncomingImportOEMController extends Controller
{
  public function index(Request $request)
  {
    if ($request->ajax()) {
      $query = IncomingManualHeader::where('area', $request->input('area'));

      if (!auth()->user()->cabang->hq) {
        $query->where('kode_cabang', auth()->user()->cabang->kode_cabang);
      }

      $datatables = DataTables::of($query)
        ->addIndexColumn() //DT_RowIndex (Penomoran)
        ->editColumn('document_date', function ($data) {
          return format_tanggal_wms($data->document_date);
        })
        ->addColumn('status', function ($data) {
          return ($data->details->count() == 0) ? '<span class="red-text">Items not found</span>' : 'Total Items ' . $data->details->count();
        })
        ->addColumn('action_view', function ($data) {
          $action = get_button_view(url('incoming-import-oem/' . $data->arrival_no));
          return $action;
        })
        ->addColumn('action_submit_to_inventory', function ($data) {
          $action = '';
          if (!$data->submit && $data->details->count() > 0) {
            $action = get_button_edit('#', 'Submit to Inventory', 'btn-submit-to-inventory');
          }
          return $action;
        })
        ->addColumn('action_delete', function ($data) {
          $action = '';
          if (!$data->submit) {
            $action = get_button_delete();
          }
          return $action;
        })
        ->addColumn('action_print', function ($data) {
          $action = '';
          $action = get_button_print();
          return $action;
        })
        ->rawColumns(['action_view', 'action_submit_to_inventory', 'action_delete', 'action_print', 'status'])
      ;

      return $datatables->make(true);
    }
    return view('web.incoming.incoming-import-oem.index');
  }

  public function create(Request $request)
  {
    $data = [];
    if (auth()->user()->cabang->hq) {
      $data['area'] = Area::findOrFail($request->get('area'));
    }
    return view('web.incoming.incoming-import-oem.create', $data);
  }

  /**
   * Submit to Inventory Function
   *
   * 1. UPDATE IncomingManualHeader
   *
   * 2. Generate data di table wms_movement_transaction_log
   * Movement type 101 `Add Stock from OEM/IMPORT/OTHERS`
   *
   * 3. CREATE OR UPDATE STOCK wms_inventory_monitoring
   *
   *
   * @param  [type] $id [description]
   * @return [type]     [description]
   */
  public function submitToInventory($id)
  {
    return DB::transaction(function () use ($id) {
      $incomingManualHeader = IncomingManualHeader::findOrFail($id);

      $incomingManualHeader->submit      = 1;
      $incomingManualHeader->submit_date = date('Y-m-d H:i:s');
      $incomingManualHeader->submit_by   = auth()->user()->id;

      $rs_storage = [];

      // Type 101 Action INCREASE
      $mvt_master_id               = 3;
      $movement_transaction_type   = MovementTransactionType::find($mvt_master_id);
      $rs_movement_transaction_log = [];

      $date_now = date('Y-m-d H:i:s');

      foreach ($incomingManualHeader->details as $key => $v_detail) {
        // Get Storage Data
        if (empty($rs_storage[$v_detail->storage_id])) {
          $rs_storage[$v_detail->storage_id] = StorageMaster::find($v_detail->storage_id);
        }

        // Update Or Create Inventory Stroage data
        InventoryStorage::updateOrCreate(
          // Condition
          [
            'storage_id' => $v_detail->storage_id,
            'model_name' => $v_detail->model,
          ],
          // Data Update
          [
            'ean_code'       => $v_detail->model_data->ean_code,
            'quantity_total' => DB::raw('IF(ISNULL(quantity_total), 0, quantity_total) + ' . $v_detail->qty),
            'cbm_total'      => DB::raw('IF(ISNULL(cbm_total), 0, cbm_total) + ' . $v_detail->total_cbm),
            'last_updated'   => $date_now,
          ]
        );

        // Add Movement Transaction Log
        $movement_transaction_log['log_id']                = Uuid::uuid4()->toString();
        $movement_transaction_log['arrival_no']            = $incomingManualHeader->arrival_no;
        $movement_transaction_log['mvt_master_id']         = $mvt_master_id;
        $movement_transaction_log['inventory_movement']    = 'Stock ' . $movement_transaction_type->action;
        $movement_transaction_log['movement_code']         = $movement_transaction_type->movement_code;
        $movement_transaction_log['transactions_desc']     = 'Add Stock from OEM/IMPORT/OTHERS';
        $movement_transaction_log['storage_location_from'] = '';
        $movement_transaction_log['storage_location_to']   = $rs_storage[$v_detail->storage_id]->sto_loc_code_long;
        $movement_transaction_log['storage_location_code'] = '& ' . $movement_transaction_log['storage_location_to'];
        $movement_transaction_log['eancode']               = $v_detail->model_data->ean_code;
        $movement_transaction_log['model']                 = $v_detail->model;
        $movement_transaction_log['quantity']              = $v_detail->qty;
        $movement_transaction_log['created_at']            = $date_now;
        $movement_transaction_log['created_by']            = auth()->user()->id;
        $movement_transaction_log['flow_id']               = '';
        $movement_transaction_log['kode_cabang']           = auth()->user()->cabang->kode_cabang;

        $rs_movement_transaction_log[] = $movement_transaction_log;
      }

      MovementTransactionLog::insert($rs_movement_transaction_log);

      $incomingManualHeader->save();

      return $incomingManualHeader;
    });
  }

  public function show(Request $request, $id)
  {
    $data['incomingManualHeader'] = IncomingManualHeader::findOrFail($id);

    if ($request->ajax()) {
      $query = $data['incomingManualHeader']
        ->details()
        ->select('log_incoming_manual_detail.*', 'log_incoming_manual_header.submit')
        ->leftjoin('log_incoming_manual_header', 'log_incoming_manual_header.arrival_no', '=', 'log_incoming_manual_detail.arrival_no_header')
        ->get();

      $datatables = DataTables::of($query)
        ->addIndexColumn() //DT_RowIndex (Penomoran)
        ->addColumn('storage_location', function ($data) {
          return $data->storage->sto_type_desc;
        })
        ->addColumn('serial_numbers', function ($data) {
          return $data->storage->serial_numbers;
        })
        ->editColumn('created_at', function ($data) {
          return $data->created_at;
        })
        ->addColumn('action', function ($data) {
          $action = '';
          if (!$data->submit) {
            $action .= ' ' . get_button_edit('#', 'Edit');
            $action .= ' ' . get_button_delete();
          }
          return $action;
        });

      return $datatables->make(true);
    }

    return view('web.incoming.incoming-import-oem.view', $data);
  }

  public function store(Request $request)
  {
    $request->validate([
      'po' => 'required',
    ]);

    $incomingManualHeader = new IncomingManualHeader;

    // Arrival_No => TIPE-WAREHOUSE-TANGGAL-Urutan
    $wh_name    = !empty($request->input('area_code')) ? $request->input('area_code') : auth()->user()->cabang->short_description;
    $arrival_no = $request->input('inc_type') . '-WH' . $wh_name . '-' . date('ymd') . '-';

    $prefix_length = strlen($arrival_no);
    $max_no        = DB::select('SELECT MAX(SUBSTR(arrival_no, ?)) AS max_no FROM log_incoming_manual_header WHERE SUBSTR(arrival_no,1,?) = ? ', [$prefix_length + 1, $prefix_length, $arrival_no])[0]->max_no;
    $max_no        = str_pad($max_no + 1, 3, 0, STR_PAD_LEFT);

    $incomingManualHeader->arrival_no          = $arrival_no . $max_no;
    $incomingManualHeader->po                  = $request->input('po');
    $incomingManualHeader->invoice_no          = $request->input('invoice_no');
    $incomingManualHeader->no_gr_sap           = $request->input('no_gr_sap');
    $incomingManualHeader->document_date       = !empty($request->input('document_date')) ? date('Y-m-d', strtotime($request->input('document_date'))) : date('Y-m-d');
    $incomingManualHeader->vendor_name         = $request->input('vendor_name');
    $incomingManualHeader->actual_arrival_date = !empty($request->input('actual_arrival_date')) ? date('Y-m-d', strtotime($request->input('actual_arrival_date'))) : date('Y-m-d');
    $incomingManualHeader->expedition_name     = $request->input('expedition_name');
    $incomingManualHeader->container_no        = $request->input('container_no');
    $incomingManualHeader->area                = $request->input('area');
    $incomingManualHeader->inc_type            = $request->input('inc_type');
    $incomingManualHeader->kode_cabang         = auth()->user()->cabang->kode_cabang;
    $incomingManualHeader->submit              = 0;
    // $incomingManualHeader->submit_date         = $request->input('submit_date');
    // $incomingManualHeader->submit_by           = $request->input('submit_by');

    $incomingManualHeader->save();

    return $incomingManualHeader;

  }

  public function uploadModel(Request $request)
  {
    $request->validate([
      'file_model' => 'required',
    ]);

    $incomingManualHeader = IncomingManualHeader::findOrFail($request->input('arrival_no'));

    $file = fopen($request->file('file_model'), "r");

    $rsUploadedModel = [];
    $rsModels        = [];
    $rsStorages      = [];

    while (!feof($file)) {
      $row = fgetcsv($file);

      if (!empty($row[0])) {
        $model['arrival_no_header'] = $request->input('arrival_no');
        $model['no_gr_sap']         = $incomingManualHeader->no_gr_sap;
        $model['model']             = $row[0];
        $model['qty']               = $row[1];

        if (empty($rsModels[$model['model']])) {
          $checkModel = MasterModel::where('model_name', $model['model'])->first();
          if (empty($checkModel)) {
            return sendError("Model " . $model['model'] . " not found in master model.");
          }
          $rsModels[$model['model']] = $checkModel;
        }

        if (empty($rsStorages[$row[2]])) {
          $checkStorage = StorageMaster::where('sto_loc_code_long', $row[2])->first();
          if (empty($checkStorage)) {
            return sendError("Storage " . $row[2] . " not found in master Storage.");
          }
          $rsStorages[$row[2]] = $checkStorage;
        }

        $model['cbm']         = $rsModels[$model['model']]->cbm;
        $model['total_cbm']   = $model['cbm'] * $model['qty'];
        $model['description'] = $rsModels[$model['model']]->description;
        $model['storage_id']  = $rsStorages[$row[2]]->id;
        $model['kode_cabang'] = $incomingManualHeader->kode_cabang;
        $model['created_at']  = date('Y-m-d H:i:s');
        $model['created_by']  = auth()->user()->id;

        $rsUploadedModel[] = $model;
      }
    }

    if (!empty($rsUploadedModel)) {
      IncomingManualDetail::insert($rsUploadedModel);
    }

    return sendSuccess('Model Uploaded.', $rsUploadedModel);
  }

  public function update(Request $request, $id)
  {
    $request->validate([
      'po' => 'required',
    ]);

    $incomingManualHeader = IncomingManualHeader::find($id);

    $incomingManualHeader->po                  = $request->input('po');
    $incomingManualHeader->invoice_no          = $request->input('invoice_no');
    $incomingManualHeader->no_gr_sap           = $request->input('no_gr_sap');
    $incomingManualHeader->document_date       = date('Y-m-d', strtotime($request->input('document_date')));
    $incomingManualHeader->vendor_name         = $request->input('vendor_name');
    $incomingManualHeader->actual_arrival_date = date('Y-m-d', strtotime($request->input('actual_arrival_date')));
    $incomingManualHeader->expedition_name     = $request->input('expedition_name');
    $incomingManualHeader->container_no        = $request->input('container_no');
    $incomingManualHeader->area                = $request->input('area');
    $incomingManualHeader->inc_type            = $request->input('inc_type');
    $incomingManualHeader->kode_cabang         = auth()->user()->cabang->kode_cabang;
    // $incomingManualHeader->submit              = 0;
    // $incomingManualHeader->submit_date         = $request->input('submit_date');
    // $incomingManualHeader->submit_by           = $request->input('submit_by');

    $incomingManualHeader->save();
    IncomingManualDetail::where('arrival_no_header', $id)->update(['no_gr_sap' => $incomingManualHeader->no_gr_sap]);

    return $incomingManualHeader;

  }

  public function destroy($id)
  {
    try {
      DB::beginTransaction();

      $incomingManualHeader = IncomingManualHeader::findOrFail($id);
      $incomingManualHeader->serial_numbers()->delete(); // has Many Trough details
      $incomingManualHeader->details()->delete();
      $incomingManualHeader->delete();

      DB::commit();

      return true;
    } catch (Exception $e) {
      DB::rollBack();

      return false;
    }
    return IncomingManualHeader::destroy($id);
  }

  public function export(Request $request, $id)
  {
    $data['incomingManualHeader'] = IncomingManualHeader::findOrFail($id);
    $data['request']              = $request->all();

    $view_print = view('web.incoming.incoming-import-oem._print', $data);
    $title      = 'Incoming Import OEM';

    if ($request->input('filetype') == 'html') {

      // request HTML View
      return $view_print;

    } elseif ($request->input('filetype') == 'xls') {

      // Request FILE EXCEL
      $reader      = new \PhpOffice\PhpSpreadsheet\Reader\Html();
      $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

      $spreadsheet = $reader->loadFromString($view_print, $spreadsheet);

      // Set warna background putih
      $spreadsheet->getActiveSheet()->getStyle('A1:K1000')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('ffffff');
      // Set Font
      $spreadsheet->getActiveSheet()->getStyle('A1:K1000')->getFont()->setName('courier New');

      // Atur lebar kolom
      $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(5);
      $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(2);
      $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(20);
      // $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(20);
      $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(5);
      $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(5);
      $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(5);
      $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(5);
      $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(10);
      $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(2);
      $spreadsheet->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);

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
