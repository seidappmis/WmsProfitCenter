<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\BeritaAcaraDuringDetail;
use App\Models\DamageGoodsReport;
use App\Models\DamageGoodsReportDetail;
use Illuminate\Http\Request;
use DataTables;
use DB;

class SummaryDamageGoodsReportController extends Controller
{
   public function index(Request $request)
   {
      if ($request->ajax()) {
         $query = DamageGoodsReport::from('dur_dgr AS d')
            ->leftJoin('dur_dgr_detail AS dd', 'dd.dur_dgr_id', '=', 'd.id')
            ->leftJoin('dur_berita_acara_detail AS bad', 'bad.id', '=', 'dd.berita_acara_during_detail_id')
            ->leftJoin('dur_berita_acara AS ba', 'bad.berita_acara_during_id', '=', 'ba.id')
            ->leftJoin('tr_expedition AS e', 'e.code', '=', 'ba.expedition_code')
            ->orderBy('d.created_at', 'DESC')
            ->groupBy('d.id')
            ->select(
               'd.*',
               DB::raw("group_concat(DISTINCT ba.berita_acara_during_no SEPARATOR '|') as berita_acara_group"),
               DB::raw("group_concat(DISTINCT ba.invoice_no SEPARATOR '|') as invoice_group"),
               DB::raw("group_concat(DISTINCT ba.bl_no SEPARATOR '|') as bl_group"),
               DB::raw("group_concat(DISTINCT ba.container_no SEPARATOR '|') as container_group"),
               DB::raw("group_concat(DISTINCT bad.model_name SEPARATOR '|') as model_group"),
               DB::raw("group_concat(DISTINCT e.expedition_name SEPARATOR '|') as expedition_name"),
               DB::raw("group_concat(DISTINCT bad.serial_number SEPARATOR ',') as serial_number_group"),
               DB::raw("group_concat(DISTINCT dd.remark SEPARATOR '|') as remark"),
               DB::raw("group_concat(DISTINCT bad.claim SEPARATOR '|') as claim_group"),
               DB::raw("group_concat(DISTINCT bad.category_damage SEPARATOR '|') as keterangan_group"),
               DB::raw("group_concat(DISTINCT bad.damage SEPARATOR '|') as remark_group"),
               DB::raw("sum(bad.qty) as sum_qty")
            )
            ->whereNotNull('d.submit_date');

         $datatables = DataTables::of($query)
            ->addIndexColumn(); //DT_RowIndex (Penomoran)

         return $datatables->make(true);
      }
      return view('web.during.summary-damage-goods-report.index');
   }

   public function show(Request $request, $id)
   {
      if ($request->ajax()) {
         $query = DamageGoodsReportDetail::from('dur_dgr_detail AS dd')
            ->leftJoin('dur_dgr AS d', 'dd.dur_dgr_id', '=', 'd.id')
            ->leftJoin('dur_berita_acara_detail AS bad', 'bad.id', '=', 'dd.berita_acara_during_detail_id')
            ->leftJoin('dur_berita_acara AS ba', 'bad.berita_acara_during_id', '=', 'ba.id')
            ->leftJoin('tr_expedition AS e', 'e.code', '=', 'ba.expedition_code')
            ->orderBy('dd.created_at', 'DESC')
            ->where('d.id', $id)
            ->select(
               'bad.id',
               'd.dgr_no',
               DB::raw("ba.berita_acara_during_no"),
               DB::raw("ba.invoice_no"),
               DB::raw("ba.bl_no"),
               DB::raw("ba.container_no"),
               DB::raw("bad.model_name"),
               DB::raw("e.expedition_name"),
               DB::raw("bad.serial_number"),
               DB::raw("dd.remark"),
               DB::raw("bad.claim"),
               DB::raw("bad.category_damage"),
               DB::raw("bad.damage"),
               DB::raw("bad.qty")
            );

         $datatables = DataTables::of($query)
            ->addIndexColumn(); //DT_RowIndex (Penomoran)

         return $datatables->make(true);
      };

      $data['dgr'] = DamageGoodsReport::where('id', $id)->first();
      return view('web.during.summary-damage-goods-report.view', $data);
   }

   public function update(Request $req, $id)
   {
      if ($req->ajax()) {
         // parsing from string to array
         $data = json_decode($req->data, true);

         try {
            if (!empty($data)) {

               DB::transaction(function () use (&$data, &$id) {

                  DamageGoodsReport::whereId($id)->update([
                     'updated_by' => auth()->user()->id,
                     'updated_at' => date('Y-m-d H:i:s'),
                  ]);

                  foreach ($data as $key => $value) {
                     // update berita acara detail _
                     $value['updated_by'] = auth()->user()->id;
                     $value['updated_at'] = date('Y-m-d H:i:s');

                     BeritaAcaraDuringDetail::whereId($key)->update($value);
                  }
               });
            }

            return sendSuccess('Data Successfully Updated.', []);
         } catch (\Exception $e) {
            return sendError($e->getMessage());
         }
      }
   }

   public function export(Request $request)
   {
      $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
      $sheet       = $spreadsheet->getActiveSheet();


      $col = 'A';
      $sheet->setCellValue(($col++) . '1', 'No');
      $sheet->setCellValue(($col++) . '1', 'Date');
      $sheet->setCellValue(($col++) . '1', 'No Doc');
      $sheet->setCellValue(($col++) . '1', 'No Berita Acara');
      $sheet->setCellValue(($col++) . '1', 'No Invoice');
      $sheet->setCellValue(($col++) . '1', 'B/L No');
      $sheet->setCellValue(($col++) . '1', 'Vendor');
      $sheet->setCellValue(($col++) . '1', 'Model');
      $sheet->setCellValue(($col++) . '1', 'Qty');
      $sheet->setCellValue(($col++) . '1', 'No Serie');
      $sheet->setCellValue(($col++) . '1', 'Keterangan');
      $sheet->setCellValue(($col) . '1', 'Remarks');

      // getPHPSpreadsheetTitleStyle() ada di wms Helper
      $sheet->getStyle('A1:' . ($col) . '1')->applyFromArray(getPHPSpreadsheetTitleStyle());




      $data = DamageGoodsReport::from('dur_dgr AS d')
         ->leftJoin('dur_dgr_detail AS dd', 'dd.dur_dgr_id', '=', 'd.id')
         ->leftJoin('dur_berita_acara_detail AS bad', 'bad.id', '=', 'dd.berita_acara_during_detail_id')
         ->leftJoin('dur_berita_acara AS ba', 'bad.berita_acara_during_id', '=', 'ba.id')
         ->leftJoin('tr_expedition AS e', 'e.code', '=', 'ba.expedition_code')
         ->orderBy('d.created_at', 'DESC')
         ->groupBy('d.id')
         ->select(
            'd.*',
            DB::raw("group_concat(DISTINCT ba.berita_acara_during_no SEPARATOR '\n') as berita_acara_group"),
            DB::raw("group_concat(DISTINCT ba.invoice_no SEPARATOR '\n') as invoice_group"),
            DB::raw("group_concat(DISTINCT ba.bl_no SEPARATOR '\n') as bl_group"),
            DB::raw("group_concat(DISTINCT ba.container_no SEPARATOR '\n') as container_group"),
            DB::raw("group_concat(DISTINCT bad.model_name SEPARATOR '\n') as model_group"),
            DB::raw("group_concat(DISTINCT e.expedition_name SEPARATOR '\n') as expedition_name"),
            DB::raw("group_concat(DISTINCT bad.serial_number SEPARATOR '\n') as serial_number_group"),
            DB::raw("group_concat(DISTINCT dd.remark SEPARATOR '\n') as remark"),
            DB::raw("group_concat(DISTINCT bad.claim SEPARATOR '\n') as claim_group"),
            DB::raw("group_concat(DISTINCT ba.category_damage SEPARATOR '\n') as keterangan_group"),
            DB::raw("group_concat(DISTINCT bad.damage SEPARATOR '\n') as remark_group"),
            DB::raw("sum(bad.qty) as sum_qty")
         )
         ->whereNotNull('d.submit_date')
         ->whereIn('d.id', $request->data)
         ->get();

      $row = 2;
      foreach ($data as $key => $value) {
         $col = 'A';
         $sheet->setCellValue(($col++) . $row, ($key + 1));
         $sheet->setCellValue(($col++) . $row, date('Y-m-d', strtotime($value->submit_date)));
         $sheet->setCellValue(($col++) . $row, $value->dgr_no);
         $sheet->setCellValue(($col++) . $row, $value->berita_acara_group);
         $sheet->setCellValue(($col++) . $row, $value->invoice_group);
         $sheet->setCellValue(($col++) . $row, $value->bl_group);
         $sheet->setCellValue(($col++) . $row, $value->vendor);
         $sheet->setCellValue(($col++) . $row, $value->model_group);
         $sheet->setCellValue(($col++) . $row, $value->sum_qty);
         $sheet->setCellValue(($col++) . $row, $value->serial_number);
         $sheet->setCellValue(($col++) . $row, $value->keterangan_group);
         $sheet->setCellValue(($col++) . $row, $value->remark_group);
         $row++;
      }

      $colResize = 'C';
      while ($colResize != $col) {
         $sheet->getColumnDimension($colResize++)->setAutoSize(true);
      }

      $title = 'Summary Damage Goods Report';

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
