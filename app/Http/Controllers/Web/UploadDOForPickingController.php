<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\ManualConcept;
use App\Models\MasterCabang;
use App\Models\MasterModel;
use DataTables;
use DB;
use Illuminate\Http\Request;

class UploadDOForPickingController extends Controller
{
  public function index(Request $request)
  {
    if ($request->ajax()) {
      $query = ManualConcept::select(
        'wms_manual_concept.*',
        DB::raw('"" AS line_no')
      )
        ->leftjoin('wms_pickinglist_detail', function ($join) {
          $join->on('wms_pickinglist_detail.invoice_no', '=', 'wms_manual_concept.invoice_no');
          $join->on('wms_pickinglist_detail.delivery_no', '=', 'wms_manual_concept.delivery_no');
        })
        ->whereNull('wms_pickinglist_detail.id') // Ambil yang belum masuk picking list
        ->where('kode_cabang', auth()->user()->cabang->kode_cabang);

      $datatables = DataTables::of($query)
        ->addIndexColumn() //DT_RowIndex (Penomoran)
        ->addColumn('action', function ($data) {
          $action = '';
          $action .= ' ' . get_button_delete();
          return $action;
        });

      return $datatables->make(true);
    }
    return view('web.picking.upload-do-for-picking.index');
  }

  public function upload(Request $request)
  {
    $request->validate([
      'file-do' => 'required',
    ]);

    $file = fopen($request->file('file-do'), "r");

    $title         = true; // Untuk Penada Baris pertama adalah Judul
    $rs_do         = [];
    $rs_model      = [];
    $rs_code_sales = [];

    $check_manual_concept = DB::table('wms_manual_concept');

    while (!feof($file)) {
      $row = fgetcsv($file);
      if ($title) {
        $title = false;
        continue; // Skip baris judul
      }

      if (!empty($row[5])) {
        $do = [];

        $do['invoice_no']                = $row[5];
        $do['delivery_no']               = $row[1];
        $do['delivery_items']            = $row[4];
        $do['do_date']                   = $row[2];
        $do['kode_customer']             = $row[7];
        $do['long_description_customer'] = $row[8];
        $do['model']                     = $row[9];
        // $do['ean_code']                  = '';
        $do['quantity'] = $row[10];
        $do['cbm']      = $row[15];
        // $do['code_sales']  = 'DS';
        $do['area']        = auth()->user()->area;
        $do['kode_cabang'] = auth()->user()->cabang->kode_cabang;
        // $do['split_date']                = '';
        // $do['split_by']                  = '';
        $do['remarks']    = '-';
        $do['created_by'] = auth()->user()->id;
        $do['created_at'] = date('Y-m-d H:i:s');

        // CEK database
        $check_manual_concept->orWhere(function ($query) use ($do) {
          $query->where('invoice_no', $do['invoice_no'])
            ->where('delivery_no', $do['delivery_no'])
            ->where('delivery_items', $do['delivery_items'])
          ;
        });

        if (empty($rs_model[$do['model']])) {
          $model = MasterModel::where('model_name', $do['model'])->first();

          $rs_model[$do['model']] = $model;
        }

        if (empty($rs_code_sales[$do['kode_customer']])) {
          $cabang                              = MasterCabang::where('kode_customer', $do['kode_customer'])->first();
          $rs_code_sales[$do['kode_customer']] = empty($cabang) ? 'DS' : 'BR';
        }

        $do['code_sales'] = $rs_code_sales[$do['kode_customer']];

        $do['ean_code'] = !empty($rs_model[$do['model']]) ? $rs_model[$do['model']]->ean_code : '';

        $rs_do[] = $do;
      }
    }

    $check = $check_manual_concept->orderBy('delivery_no', 'desc')->limit(1)->get();
    if (!empty($check)) {
      return sendError('Failed Upload ' . $check[0]->delivery_no . ' AND ' . $check[0]->delivery_items . ' Already EXIST.');
    }

    ManualConcept::insert($rs_do);

    return $rs_do;
  }

  public function destroy(Request $request)
  {
    return ManualConcept::where('invoice_no', $request->input('invoice_no'))
      ->where('delivery_no', $request->input('delivery_no'))
      ->where('delivery_items', $request->input('delivery_items'))
      ->delete();
  }

  public function destroySelectedItem(Request $request)
  {
    $data_do = json_decode($request->input('data_do'), true);

    foreach ($data_do as $key => $value) {
      ManualConcept::where('invoice_no', $value['invoice_no'])
        ->where('delivery_no', $value['delivery_no'])
        ->where('delivery_items', $value['delivery_items'])
        ->delete();
    }

    return true;

  }
}
