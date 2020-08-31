<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\WMSBranchManifestDetail;
use App\Models\WMSBranchManifestFreightCost;
use App\Models\WMSBranchManifestHeader;
use DataTables;
use DB;
use Illuminate\Http\Request;

class BranchInvoicingController extends Controller
{
  public function index(Request $request)
  {
    if ($request->ajax()) {
      $query = WMSBranchManifestFreightCost::selectRaw("
          group_id,
          GROUP_CONCAT(do_manifest_no SEPARATOR ', ') AS manifest_no,
          GROUP_CONCAT(expedition_name SEPARATOR ', ') AS expedition_name
        ")
        ->where('kode_cabang_pembuat', auth()->user()->cabang->kode_cabang)
        ->groupBy('group_id')
      ;

      $datatables = DataTables::of($query)
        ->addIndexColumn() //DT_RowIndex (Penomoran)
        ->addColumn('action', function ($data) {
          $action = '';
          $action .= ' ' . get_button_view(url('branch-invoicing/' . $data->group_id));
          return $action;
        });

      return $datatables->make(true);
    }

    return view('web.invoicing.branch-invoicing.index');
  }

  public function getManifestData(Request $request)
  {
    $query = WMSBranchManifestHeader::select(
      'wms_branch_manifest_header.*',
      DB::raw('COUNT(wms_branch_manifest_detail.delivery_no) AS count_of_do'),
      DB::raw('SUM(wms_branch_manifest_detail.cbm) AS sum_of_cbm')
    )
      ->leftjoin('wms_branch_manifest_detail', 'wms_branch_manifest_detail.do_manifest_no', '=', 'wms_branch_manifest_header.do_manifest_no')
      ->leftjoin('wms_branch_manifest_freight_cost', function ($join) {
        $join->on('wms_branch_manifest_detail.do_manifest_no', '=', 'wms_branch_manifest_freight_cost.do_manifest_no');
        $join->on('wms_branch_manifest_detail.delivery_no', '=', 'wms_branch_manifest_freight_cost.delivery_no');
        $join->on('wms_branch_manifest_detail.model', '=', 'wms_branch_manifest_freight_cost.model');
      })
      ->where('wms_branch_manifest_header.do_manifest_no', 'like', '%' . $request->input('search')['value'] . '%')
      ->whereNull('wms_branch_manifest_freight_cost.group_id')
      ->groupBy('wms_branch_manifest_header.do_manifest_no')
    ;

    if (empty($request->input('search')['value'])) {
      $query->whereRaw('1=2');
    }

    $datatables = DataTables::of($query)
      ->addIndexColumn() //DT_RowIndex (Penomoran)
      ->addColumn('action', function ($data) {
        $action = '<span class="waves-effect waves-light indigo btn-small btn-select-manifest" data-id="' . $data->do_manifest_no . '">SELECT</span>';
        return $action;
      });

    return $datatables->make(true);
  }

  public function getManifestDetails(Request $request)
  {
    $details = WMSBranchManifestDetail::select(
      'wms_branch_manifest_detail.*',
      'wms_branch_manifest_header.do_manifest_date'
    )
      ->leftjoin('wms_branch_manifest_header', 'wms_branch_manifest_detail.do_manifest_no', '=', 'wms_branch_manifest_header.do_manifest_no')
      ->where('wms_branch_manifest_detail.do_manifest_no', $request->input('do_manifest_no'))->get();

    return sendSuccess('Manifest Retrive.', $details);
  }

  public function show($group_id)
  {
    $data['group_id']        = $group_id;
    $data['rs_freight_cost'] = WMSBranchManifestFreightCost::where('group_id', $group_id)->get();
    return view('web.invoicing.branch-invoicing.show', $data);
  }

  public function store(Request $request)
  {
    $rs_freight_cost = [];
    foreach ($request->input('detail_id') as $key => $value) {
      $freight_cost    = [];
      $manifest_detail = WMSBranchManifestDetail::select(
        'wms_branch_manifest_detail.*',
        'wms_branch_manifest_header.do_manifest_date',
        'wms_branch_manifest_header.driver_name',
        'wms_branch_manifest_header.vehicle_number',
        'wms_branch_manifest_header.vehicle_code_type',
        'wms_branch_manifest_header.vehicle_description',
        'wms_branch_manifest_header.destination_name_driver',
        'wms_branch_manifest_header.destination_number_driver'
      )
        ->leftjoin('wms_branch_manifest_header', 'wms_branch_manifest_detail.do_manifest_no', '=', 'wms_branch_manifest_header.do_manifest_no')
        ->where('id', $value)
        ->first();

      $freight_cost['delivery_no']               = $manifest_detail->delivery_no;
      $freight_cost['model']                     = $manifest_detail->model;
      $freight_cost['group_id']                  = $request->input('group_id');
      $freight_cost['do_manifest_no']            = $manifest_detail->do_manifest_no;
      $freight_cost['do_manifest_date']          = $manifest_detail->do_manifest_date;
      $freight_cost['expedition_name']           = $manifest_detail->expedition_name;
      $freight_cost['driver_name']               = $manifest_detail->driver_name;
      $freight_cost['vehicle_number']            = $manifest_detail->vehicle_number;
      $freight_cost['vehicle_code_type']         = $manifest_detail->vehicle_code_type;
      $freight_cost['vehicle_description']       = $manifest_detail->vehicle_description;
      $freight_cost['destination_number_driver'] = $manifest_detail->destination_number_driver;
      $freight_cost['destination_name_driver']   = $manifest_detail->destination_name_driver;
      $freight_cost['sold_to']                   = $manifest_detail->sold_to;
      $freight_cost['sold_to_street']            = $manifest_detail->sold_to_street;
      $freight_cost['sold_to_code']              = $manifest_detail->sold_to_code;
      $freight_cost['ship_to']                   = $manifest_detail->ship_to;
      $freight_cost['ship_to_code']              = $manifest_detail->ship_to_code;
      $freight_cost['city_name']                 = $manifest_detail->city_name;
      $freight_cost['do_date']                   = $manifest_detail->do_date;
      $freight_cost['container_no']              = $manifest_detail->container_no;
      $freight_cost['seal_no']                   = $manifest_detail->seal_no;
      $freight_cost['checker']                   = $manifest_detail->checker;
      $freight_cost['pdo_no']                    = $manifest_detail->pdo_no;
      $freight_cost['kode_cabang_pembuat']       = $manifest_detail->kode_cabang;
      $freight_cost['kode_cabang_penerima']      = $manifest_detail->kode_cabang;
      $freight_cost['cbm_unit']                  = $manifest_detail->cbm / $manifest_detail->quantity;
      $freight_cost['quantity']                  = $manifest_detail->quantity;
      $freight_cost['cbm_total']                 = $manifest_detail->cbm;
      $freight_cost['cost_per_cbm']              = $request->input('cost_per_cbm')[$key];
      $freight_cost['cost_per_coli']             = $request->input('cost_per_coli')[$key];
      $freight_cost['cost_per_trip']             = $request->input('cost_per_trip')[$key];
      $freight_cost['cost_total']                = $this->getCostTotal($freight_cost);
      $freight_cost['created_at']                = date('Y-m-d H:i:s');
      $freight_cost['created_by']                = auth()->user()->id;

      $rs_freight_cost[] = $freight_cost;
    }

    WMSBranchManifestFreightCost::insert($rs_freight_cost);

    return sendSuccess('Freight Cost saved', $rs_freight_cost);
  }

  protected function getCostTotal($freight_cost)
  {
    return $freight_cost['cbm_total'] * $freight_cost['cost_per_cbm'] + $freight_cost['cbm_total'] * $freight_cost['cost_per_coli'] + $freight_cost['cost_per_trip'];
  }

  public function update(Request $request)
  {
    $freight_cost_temp = WMSBranchManifestFreightCost::where('do_manifest_no', $request->input('do_manifest_no'))
      ->where('model', $request->input('model'))
      ->where('delivery_no', $request->input('delivery_no'))
      ->first();

    $freight_cost                  = [];
    $freight_cost['cbm_total']     = $freight_cost_temp->cbm_total;
    $freight_cost['cost_per_cbm']  = $request->input('cost_per_cbm');
    $freight_cost['cost_per_coli'] = $request->input('cost_per_coli');
    $freight_cost['cost_per_trip'] = $request->input('cost_per_trip');
    $freight_cost['cost_total']    = $this->getCostTotal($freight_cost);

    WMSBranchManifestFreightCost::where('do_manifest_no', $request->input('do_manifest_no'))
      ->where('model', $request->input('model'))
      ->where('delivery_no', $request->input('delivery_no'))
      ->update($freight_cost);

    return sendSuccess('Freight Cost for DO ' . $request->input('delivery_no') . ' and Model ' . $request->input('model') . ' has been update', $freight_cost);
  }

  public function destroy(Request $request)
  {
    $delete = WMSBranchManifestFreightCost::where('do_manifest_no', $request->input('do_manifest_no'))
      ->where('model', $request->input('model'))
      ->where('delivery_no', $request->input('delivery_no'))
      ->delete();

    return sendSuccess('Item Deleted.', $delete);
  }

  public function export(Request $request, $id)
  {
    // $data['pickinglistHeader'] = PickinglistHeader::findOrFail($id);

    $view_print = view('web.invoicing.branch-invoicing._print');
    $title      = 'Branch Invoicing';

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
      $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
      $spreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);

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
