<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\BeritaAcaraDetail;
use App\Models\ClaimInsurance;
use App\Models\ClaimInsuranceDetail;
use App\Models\ClaimNote;
use App\Models\ClaimNoteDetail;
use DataTables;
use DB;
use Illuminate\Http\Request;

class SummaryClaimInsuranceController extends Controller
{
   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index(Request $request)
   {
      if ($request->ajax()) {

         $query = ClaimInsurance::from('clm_claim_insurance AS i')
            ->leftJoin('clm_claim_insurance_detail AS id', 'id.claim_insurance_id', '=', 'i.id')
            ->leftJoin('clm_berita_acara_detail AS bad', 'bad.claim_insurance_detail_id', '=', 'id.id')
            ->leftJoin('clm_berita_acara AS ba', 'bad.berita_acara_id', '=', 'ba.id')
            ->leftJoin('tr_expedition AS e', 'e.code', '=', 'ba.expedition_code')
            ->leftJoin('wms_master_model AS m', 'm.model_name', '=', 'id.model_name')
            ->orderBy('i.created_at', 'DESC')
            ->groupBy('i.id')
            ->whereNotNull('i.submit_date')
            ->select(
               'i.id',
               'i.insurance_date',
               'i.payment_date',
               'i.remark',
               'i.summary_remark',
               DB::raw("group_concat(bad.berita_acara_no SEPARATOR ', ') as berita_acara_group"),
               DB::raw('SUM(IF(id.price > 0 , id.price*id.qty , m.price_carton_box*id.qty)) AS total')
            );

         // $query = ClaimInsurance::get();
         $datatables = DataTables::of($query)
            ->editColumn('berita_acara_group', function ($data) {
               $arr = explode(',', $data->berita_acara_group);

               $return  =  [];
               foreach ($arr as $k => $v) {
                  if (!isset($return[trim($v)]))
                     $return[trim($v)] = 1;
               }
               return  implode(', ', array_keys($return));;
            })
            ->addIndexColumn(); //DT_RowIndex (Penomoran)

         return $datatables->make(true);
      }
      return view('web.claim.summary-claim-insurance.index');
   }

   /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function update(Request $req, $id)
   {
      if ($req->ajax()) {
         // parsing from string to array

         try {
            DB::transaction(function () use (&$req, &$id) {

               ClaimInsurance::whereId($id)->update([
                  "payment_date" => !empty($req->payment_date) ? $req->payment_date : '',
                  "summary_remark" => !empty($req->remark) ? $req->remark : '',

                  'updated_by' => auth()->user()->id,
                  'updated_at' => date('Y-m-d H:i:s')
               ]);
            });
            return sendSuccess('Data Successfully Updated.', []);
         } catch (\Exception $e) {
            return sendError($e->getMessage());
         }
      }
   }


   public function delete(Request $req, $id)
   {
      if ($req->ajax()) {
         // parsing from string to array

         try {
            DB::transaction(function () use (&$req, &$id) {

               ClaimInsurance::whereId($id)->update([
                  "payment_date" => null,
                  "remark" => null,
                  "submit_date" => null,
                  "submit_by" => null,

                  'updated_by' => auth()->user()->id,
                  'updated_at' => date('Y-m-d H:i:s')
               ]);
            });
            return sendSuccess('Data Successfully deleted.', []);
         } catch (\Exception $e) {
            return sendError($e->getMessage());
         }
      }
   }

   public function export(Request $request)
   {
      $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
      $sheet       = $spreadsheet->getActiveSheet();

      $sheet->setCellValue('A1', 'Month');
      $sheet->setCellValue('B1', 'NO');
      $sheet->setCellValue('C1', 'Serial Number');
      $sheet->setCellValue('D1', 'Product');
      $sheet->setCellValue('E1', 'Qty');
      $sheet->setCellValue('F1', 'Curr');
      $sheet->setCellValue('G1', 'Price/Unit');
      $sheet->setCellValue('H1', 'Total');
      $sheet->setCellValue('I1', 'Nature of Loss');
      $sheet->setCellValue('J1', 'Location');
      $sheet->setCellValue('K1', 'Remark');
      $sheet->setCellValue('L1', 'Branch');
      $sheet->setCellValue('M1', 'Claim Report');
      $sheet->setCellValue('N1', 'Payment Date');
      $sheet->setCellValue('O1', 'Remark');

      // getPHPSpreadsheetTitleStyle() ada di wms Helper
      $sheet->getStyle('A1:O1')->applyFromArray(getPHPSpreadsheetTitleStyle());




      $data =  ClaimInsurance::from('clm_claim_insurance AS i')
         ->leftJoin('clm_claim_insurance_detail AS id', 'id.claim_insurance_id', '=', 'i.id')
         ->leftJoin('clm_berita_acara_detail AS bad', 'bad.claim_insurance_detail_id', '=', 'id.id')
         ->leftJoin('clm_berita_acara AS ba', 'bad.berita_acara_id', '=', 'ba.id')
         ->leftJoin('tr_expedition AS e', 'e.code', '=', 'ba.expedition_code')
         ->leftJoin('wms_master_model AS m', 'm.model_name', '=', 'id.model_name')
         ->leftJoin('log_cabang AS lc', 'lc.short_description', '=', 'ba.kode_cabang')
         ->orderBy('i.created_at', 'DESC')
         ->select(
            'i.*',
            'e.expedition_name',
            'ba.date_of_receipt',
            'ba.berita_acara_no',
            'bad.photo_url',
            'bad.keterangan',
            'id.location',
            'id.driver_name',
            'id.vehicle_number',
            'id.do_no',
            'id.model_name',
            'id.serial_number',
            'id.description',
            'id.qty',
            'id.price',
            'id.id AS claim_insurance_detail',
            'm.price_carton_box',
            'lc.long_description as nama_cabang'
         )
         ->whereIn('i.id', $request->data)
         ->get()->toArray();

      $row = 2;
      foreach ($data as $key => $value) {
         $col = 'A';
         $price = $value['price'];
         if ($value['description'] == 'Carton Box Damage' && empty($value['price'])) {
            $price = $value['price_carton_box'];
         };

         $sheet->setCellValue(($col++) . $row, date('M-Y', strtotime($value['date_of_loss'])));
         $sheet->setCellValue(($col++) . $row, ($key + 1));
         $sheet->setCellValue(($col++) . $row, $value['serial_number']);
         $sheet->setCellValue(($col++) . $row, $value['model_name']);
         $sheet->setCellValue(($col++) . $row, $value['qty']);
         $sheet->setCellValue(($col++) . $row, 'IDR');
         $sheet->setCellValue(($col++) . $row, $price);
         $sheet->setCellValue(($col++) . $row, $price * $value['qty']);
         $sheet->setCellValue(($col++) . $row, $value['description']);
         $sheet->setCellValue(($col++) . $row, $value['location']);
         $sheet->setCellValue(($col++) . $row, $value['remark']);
         $sheet->setCellValue(($col++) . $row, $value['nama_cabang']);
         $sheet->setCellValue(($col++) . $row, $value['claim_report']);
         $sheet->setCellValue(($col++) . $row, !empty($value['payment_date']) ? format_tanggal_jam_wms($value['payment_date']) : '-');
         $sheet->setCellValue(($col++) . $row, $value['summary_remark']);
         $row++;
      }

      $colResize = 'C';
      while ($colResize != $col) {
         $sheet->getColumnDimension($colResize++)->setAutoSize(true);
      }

      $title = 'Summary Claim Insurance';

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
