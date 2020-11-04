<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\InventoryStorage;
use DataTables;
use Illuminate\Http\Request;

class ReportStockInventoryController extends Controller
{
  public function index(Request $request)
  {
    if ($request->ajax()) {
      $query = $this->getData($request);

      $datatables = DataTables::of($query)
        ->addIndexColumn() //DT_RowIndex (Penomoran)
      ;

      return $datatables->make(true);
    }

    return view('web.report.report-stock-inventory.index');
  }

  protected function getData($request)
  {
    $query = InventoryStorage::selectRaw('wms_inventory_storage.*, log_cabang.kode_customer, log_cabang.long_description, wms_master_storage.sto_loc_code_long')
      ->leftjoin('wms_master_storage', 'wms_master_storage.id', '=', 'wms_inventory_storage.storage_id')
      ->leftjoin('log_cabang', 'log_cabang.kode_cabang', '=', 'wms_master_storage.kode_cabang')
      ->where('log_cabang.kode_cabang', $request->input('cabang'))
    ;

    if (!empty($request->input('model'))) {
      $query->where('model_name', $request->input('model'));
    }

    if (!empty($request->input('location'))) {
      $query->where('storage_id', $request->input('location'));
    }

    return $query;
  }

  public function export(Request $request)
  {
    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet       = $spreadsheet->getActiveSheet();

    $col = 'A';
    $sheet->setCellValue(($col++) . '1', 'NO');
    $sheet->setCellValue(($col++) . '1', 'Branch Code');
    $sheet->setCellValue(($col++) . '1', 'Branch');
    $sheet->setCellValue(($col++) . '1', 'Model');
    $sheet->setCellValue(($col++) . '1', 'SLOC');
    $sheet->setCellValue(($col) . '1', 'QTY');
    // getPHPSpreadsheetTitleStyle() ada di wms Helper
    $sheet->getStyle('A1:' . ($col) . '1')->applyFromArray(getPHPSpreadsheetTitleStyle());

    $data = $this->getData($request)->get();

    $row = 2;
    foreach ($data as $key => $value) {
      $col = 'A';
      $sheet->setCellValue(($col++) . $row, ($key + 1));
      $sheet->setCellValue(($col++) . $row, $value->kode_customer);
      $sheet->setCellValue(($col++) . $row, $value->long_description);
      $sheet->setCellValue(($col++) . $row, $value->model_name);
      $sheet->setCellValue(($col++) . $row, $value->sto_loc_code_long);
      $sheet->setCellValue(($col++) . $row, $value->quantity_total);
      $row++;
    }

    $sheet->getColumnDimension('A')->setAutoSize(true);
    $sheet->getColumnDimension('B')->setAutoSize(true);
    $sheet->getColumnDimension('C')->setAutoSize(true);
    $sheet->getColumnDimension('D')->setAutoSize(true);
    $sheet->getColumnDimension('E')->setAutoSize(true);
    $sheet->getColumnDimension('F')->setAutoSize(true);

    $title = 'Report Stock Inventory ';

    if ($request->input('file_type') == 'pdf') {
      $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Mpdf');
      header('Content-Type: application/pdf');
      header('Content-Disposition: attachment;filename="' . $title . '.pdf"');
      header('Cache-Control: max-age=0');
    } else {
      $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment; filename="' . $title . '.xls"');
    }

    $writer->save("php://output");
  }
}
