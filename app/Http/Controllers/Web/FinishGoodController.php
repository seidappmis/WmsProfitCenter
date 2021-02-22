<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\FinishGoodDetail;
use App\Models\FinishGoodHeader;
use App\Models\InventoryStorage;
use App\Models\MasterModel;
use App\Models\MovementTransactionLog;
use App\Models\MovementTransactionType;
use App\Models\StorageMaster;
use DataTables;
use DB;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class FinishGoodController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    if ($request->ajax()) {
      $query = FinishGoodHeader::select(
        'log_finish_good_header.*',
        DB::raw('GROUP_CONCAT(DISTINCT log_finish_good_detail.bar_ticket_header) AS bar_ticket_header')
      )
        ->leftjoin('log_finish_good_detail', 'log_finish_good_detail.receipt_no_header', '=', 'log_finish_good_header.receipt_no')
        ->groupBy('log_finish_good_header.receipt_no')
        ->where('area', $request->input('area'));

      if (!auth()->user()->cabang->hq) {
        $query->where('kode_cabang', auth()->user()->cabang->kode_cabang);
      }

      $datatables = DataTables::of($query)
        ->addIndexColumn() //DT_RowIndex (Penomoran)
        ->addColumn('action_view', function ($data) {
          $action = get_button_view(url('finish-good-production/' . $data->receipt_no));
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
        ->rawColumns(['action_view', 'action_submit_to_inventory', 'action_delete', 'action_print'])
      ;

      return $datatables->make(true);
    }

    return view('web.incoming.finish-good-production.index');
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view('web.incoming.finish-good-production.create');
  }

  public function searchDeliveryTicket(Request $request)
  {
    DB::connection('sqlsrv')->statement('SET ANSI_NULLS, QUOTED_IDENTIFIER, CONCAT_NULL_YIELDS_NULL, ANSI_WARNINGS, ANSI_PADDING ON');

    $sql = DB::connection('sqlsrv')->select(DB::raw("
    SELECT
    Bar_Ticket_Header.HEADER_NAME
    , (Bar_Ticket_Detail.SERIAL_NUMBER.value('count(/cols/fields)', 'int')) AS quantity
    , Bar_Model_Master.EAN_CODE
    , Bar_Model_Master.MODEL
    , Bar_Model_Master.PLANT
    , Bar_Schedule_Header.TIPE
    FROM
    Bar_Ticket_Detail
    LEFT JOIN Bar_Ticket_Header ON Bar_Ticket_Header.ID = Bar_Ticket_Detail.HEADER_ID
    LEFT JOIN Bar_Schedule_Header ON Bar_Schedule_Header.ID = Bar_Ticket_Detail.SCH_ID
    LEFT JOIN Bar_Model_Master ON Bar_Model_Master.SAP_MODEL = Bar_Schedule_Header.SAPMODEL
    WHERE Bar_Model_Master.MODEL != ''
      AND Bar_Model_Master.PLANT = ?
      AND Bar_Ticket_Header.HEADER_NAME LIKE '%" . $request->input('header_name') . "%'
      AND Bar_Schedule_Header.TIPE = ?
    "), [
      $request->input('plant'),
      // $request->input('header_name'),
      strtolower($request->input('tipe')),
    ]);
    
    return $sql;
  }

  public function submitToInventory($id)
  {
    $finishGoodHeader = $this->doSubmitToInventory($id);

    return $finishGoodHeader;
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    // $finishGoodHeader = new FinishGoodHeader;

    $selected_list = json_decode($request->input('selected_list'), true);

    if (empty($selected_list)) {
      return sendError('No item selected.');
    }

    // $selected_list = [
    //   ['HEADER_NAME' => 'HE1', 'MODEL' => '14A20D3', 'quantity' => 2, 'TIPE' => 'IMPORT', 'EAN_CODE' => '8997401917278'],
    //   ['HEADER_NAME' => 'HE2', 'MODEL' => '14A20D3', 'quantity' => 2, 'TIPE' => 'IMPORT', 'EAN_CODE' => '8997401917278'],
    //   ['HEADER_NAME' => 'HE3', 'MODEL' => '14A20D3', 'quantity' => 2, 'TIPE' => 'IMPORT', 'EAN_CODE' => '8997401917278'],
    //   ['HEADER_NAME' => 'HE4', 'MODEL' => '14A20D3', 'quantity' => 2, 'TIPE' => 'IMPORT', 'EAN_CODE' => '8997401917278'],
    //   ['HEADER_NAME' => 'HE5', 'MODEL' => '14A20D3', 'quantity' => 2, 'TIPE' => 'IMPORT', 'EAN_CODE' => '8997401917278'],
    //   ['HEADER_NAME' => 'HE6', 'MODEL' => '14A20D3', 'quantity' => 2, 'TIPE' => 'IMPORT', 'EAN_CODE' => '8997401917278'],
    //   ['HEADER_NAME' => 'HE7', 'MODEL' => '14A20D3', 'quantity' => 2, 'TIPE' => 'IMPORT', 'EAN_CODE' => '8997401917278'],
    //   ['HEADER_NAME' => 'HE8', 'MODEL' => '14A20D3', 'quantity' => 2, 'TIPE' => 'IMPORT', 'EAN_CODE' => '8997401917278'],
    //   ['HEADER_NAME' => 'HE9', 'MODEL' => '14A20D3', 'quantity' => 2, 'TIPE' => 'IMPORT', 'EAN_CODE' => '8997401917278'],
    //   ['HEADER_NAME' => 'HE10', 'MODEL' => '14A20D3', 'quantity' => 2, 'TIPE' => 'IMPORT', 'EAN_CODE' => '8997401917278']
    // ];

    // Receipt_No => ARV-WAREHOUSE-TANGGAL-Urutan
    $area       = auth()->user()->area;
    $receipt_no = 'ARV' . '-WH' . auth()->user()->area_data->code . '-' . date('ymd') . '-';

    $prefix_length = strlen($receipt_no);
    $max_no        = DB::select('SELECT MAX(SUBSTR(receipt_no, ?)) AS max_no FROM log_finish_good_header WHERE SUBSTR(receipt_no,1,?) = ? ', [$prefix_length + 1, $prefix_length, $receipt_no])[0]->max_no;
    $max_no = $max_no + 1;
    // $max_no        = str_pad($max_no + 1, 3, 0, STR_PAD_LEFT);

    $warehouse = 'SHARP ' . $area . ' W/H';
    $supplier  = $request->input('plant');

    $rs_finishGoodHeader = [];

    // Finish Good Detail
    $details = [];
    foreach ($selected_list as $key => $value) {
      $detail['bar_ticket_header'] = $value['HEADER_NAME'];

      $checkDetailTicket = FinishGoodDetail::where('bar_ticket_header', $detail['bar_ticket_header'])->first();
      if (!empty($checkDetailTicket)) {
        return sendError('Ticket No. '. $detail['bar_ticket_header'] . ' already exists!');
      } 
      
      if (empty($rs_finishGoodHeader[$detail['bar_ticket_header']])) {
        $finishGoodHeader['receipt_no']  = $receipt_no . str_pad($max_no++, 3, 0, STR_PAD_LEFT);
        $finishGoodHeader['warehouse']   = $warehouse;
        $finishGoodHeader['supplier']    = $supplier;
        $finishGoodHeader['area']        = $area;
        $finishGoodHeader['kode_cabang'] = auth()->user()->cabang->kode_cabang;
        $finishGoodHeader['submit']      = 0;
        $finishGoodHeader['created_at']  = date('Y-m-d H:i:s');
        $finishGoodHeader['created_by']  = auth()->user()->id;

        $rs_finishGoodHeader[$detail['bar_ticket_header']] = $finishGoodHeader;
        // $max_no++;
      }
      $detail['receipt_no_header'] = $rs_finishGoodHeader[$detail['bar_ticket_header']]['receipt_no'];
      $detail['model']             = $value['MODEL'];
      $detail['quantity']          = $value['quantity'];
      $detail['print_type']        = $value['TIPE'];
      $detail['ean_code']          = $value['EAN_CODE'];
      $detail['kode_cabang']       = auth()->user()->cabang->kode_cabang;
      $detail['storage_id']        = $request->input('storage_id');
      $detail['created_at']        = date('Y-m-d H:i:s');
      $detail['created_by']        = auth()->user()->id;

      $details[] = $detail;
    }

    try {
      DB::beginTransaction();

      FinishGoodDetail::insert($details);
      FinishGoodHeader::insert(array_values($rs_finishGoodHeader));

      if ($request->input('tipe_submit') == 'submit-to-inventory') {
        foreach ($rs_finishGoodHeader as $key => $value) {
          $this->doSubmitToInventory($value['receipt_no']);
        }
      }

      DB::commit();

      return sendSuccess('Data Created.', $finishGoodHeader);

    } catch (Exception $e) {
      DB::rollBack();
    }
  }

  protected function doSubmitToInventory($receipt_no)
  {
    $finishGoodHeader = FinishGoodHeader::findOrFail($receipt_no);

    $rs_storage = [];
    $rs_models  = [];

    // Type 101 Action INCREASE
    $mvt_master_id               = 5;
    $movement_transaction_type   = MovementTransactionType::find($mvt_master_id);
    $rs_movement_transaction_log = [];

    $date_now = date('Y-m-d H:i:s');

    foreach ($finishGoodHeader->details as $key => $v_detail) {
      // Get Storage Data
      if (empty($rs_storage[$v_detail->storage_id])) {
        $rs_storage[$v_detail->storage_id] = StorageMaster::find($v_detail->storage_id);
      }

      if (empty($rs_models[$v_detail->ean_code])) {
        $rs_models[$v_detail->ean_code] = MasterModel::where('ean_code', $v_detail->ean_code)->first();
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
          'ean_code'       => $v_detail->ean_code,
          'quantity_total' => DB::raw('IF(ISNULL(quantity_total), 0, quantity_total) + ' . $v_detail->quantity),
          'cbm_total'      => DB::raw('IF(ISNULL(cbm_total), 0, cbm_total) + ' . $rs_models[$v_detail->ean_code]->cbm * $v_detail->quantity),
          'last_updated'   => $date_now,
        ]
      );

      // Add Movement Transaction Log
      $movement_transaction_log['log_id']                = Uuid::uuid4()->toString();
      $movement_transaction_log['arrival_no']            = $finishGoodHeader->receipt_no;
      $movement_transaction_log['mvt_master_id']         = $mvt_master_id;
      $movement_transaction_log['inventory_movement']    = 'Stock ' . $movement_transaction_type->action;
      $movement_transaction_log['movement_code']         = $movement_transaction_type->movement_code;
      $movement_transaction_log['transactions_desc']     = 'Add Stock from Production';
      $movement_transaction_log['storage_location_from'] = '';
      $movement_transaction_log['storage_location_to']   = $rs_storage[$v_detail->storage_id]->sto_loc_code_long;
      $movement_transaction_log['storage_location_code'] = '& ' . $movement_transaction_log['storage_location_to'];
      $movement_transaction_log['eancode']               = $v_detail->ean_code;
      $movement_transaction_log['model']                 = $v_detail->model;
      $movement_transaction_log['quantity']              = $v_detail->quantity;
      $movement_transaction_log['created_at']            = $date_now;
      $movement_transaction_log['created_by']            = auth()->user()->id;
      $movement_transaction_log['flow_id']               = '';
      $movement_transaction_log['kode_cabang']           = auth()->user()->cabang->kode_cabang;

      $rs_movement_transaction_log[] = $movement_transaction_log;
    }

    MovementTransactionLog::insert($rs_movement_transaction_log);
    $finishGoodHeader->submit      = 1;
    $finishGoodHeader->submit_date = date('Y-m-d H:i:s');
    $finishGoodHeader->submit_by   = auth()->user()->id;
    $finishGoodHeader->save();

    return $finishGoodHeader;
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show(Request $request, $id)
  {
    $data['finishGoodHeader'] = FinishGoodHeader::findOrFail($id);

    if ($request->ajax()) {
      $query = $data['finishGoodHeader']
        ->details()
        ->select(
          'log_finish_good_detail.*',
          'wms_master_storage.sto_type_desc'
        )
        ->leftjoin('wms_master_storage', 'wms_master_storage.id', '=', 'log_finish_good_detail.storage_id')
      ;

      $datatables = DataTables::of($query)
        ->addIndexColumn() //DT_RowIndex (Penomoran)
        ->addColumn('action', function ($data) {
          $action = '';
          //$action .= ' ' . get_button_edit(url('master-area/' . $data->area . '/edit'));
          //$action .= ' ' . get_button_delete();
          return $action;
        });

      return $datatables->make(true);
    }
    return view('web.incoming.finish-good-production.view', $data);
    // return view('web.incoming.finish-good-production.view');
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    try {
      DB::beginTransaction();

      $finishGoodHeader = FinishGoodHeader::findOrFail($id);
      $finishGoodHeader->details()->delete();
      $finishGoodHeader->delete();

      DB::commit();

      return true;
    } catch (Exception $e) {
      DB::rollBack();

      return false;
    }
    return sendSuccess($finishGoodHeader);
  }

  public function export(Request $request, $id)
  {
    $data['finishGoodHeader'] = finishGoodHeader::findOrFail($id);
    $data['request'] = $request->all();

    $view_print = view('web.incoming.finish-good-production._print', $data);
    $title      = 'Finish Good Production';

    if ($request->input('filetype') == 'html') {

      // request HTML View
      return $view_print;

    } elseif ($request->input('filetype') == 'xls') {

      // Request FILE EXCEL
      $reader      = new \PhpOffice\PhpSpreadsheet\Reader\Html();
      $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

      $spreadsheet = $reader->loadFromString($view_print, $spreadsheet);

      // Set warna background putih
      $spreadsheet->getActiveSheet()->getStyle('A1:M1000')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('ffffff');
      // Set Font
      $spreadsheet->getActiveSheet()->getStyle('A1:M1000')->getFont()->setName('courier New');

      // Atur lebar kolom
      $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(5);
      $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(2);
      $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(20);
      // $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(20);
      $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(10);
      $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(10);
      $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(5);
      $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(5);
      $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(10);
      $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(2);
      $spreadsheet->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);

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
