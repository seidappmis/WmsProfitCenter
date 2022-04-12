<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\BeritaAcara;
use App\Models\BeritaAcaraDetail;
use App\Models\ClaimNote;
use App\Models\ClaimNoteDetail;
use App\Models\MasterModel;
use DataTables;
use DB;
use Illuminate\Http\Request;

class SummaryClaimNoteController extends Controller
{
   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index(Request $request)
   {
      if ($request->ajax()) {
         $claimNoteSubQuery = ClaimNoteDetail::select(
            'claim_note_id',
            DB::raw("sum(1) as unit"),
            DB::raw("sum(qty) as sum_qty"),
            DB::raw("sum( if(clm_claim_notes.claim = 'unit', price * 111 / 100, price) ) as sum_price"),
            DB::raw("sum( if(clm_claim_notes.claim = 'unit', price * 111 / 100, price) *qty) as sub_total")
         )
            ->leftJoin('clm_claim_notes', 'clm_claim_notes.id', '=', 'clm_claim_note_detail.claim_note_id')
            // ->leftJoin('wms_master_model AS m', 'm.model_name', '=', 'nd.model_name')
            ->groupBy('claim_note_id');
         $query = ClaimNote::from('clm_claim_notes AS n')
            ->leftJoin('clm_claim_note_detail AS nd', 'nd.claim_note_id', '=', 'n.id')
            ->leftJoin('clm_berita_acara_detail AS bad', 'bad.id', '=', 'nd.berita_acara_detail_id')
            ->leftJoin('clm_berita_acara AS ba', 'bad.berita_acara_id', '=', 'ba.id')
            ->leftJoin('tr_expedition AS e', 'e.code', '=', 'ba.expedition_code')
            ->joinSub($claimNoteSubQuery, 'ns', function ($join) {
               $join->on('n.id', '=', 'ns.claim_note_id');
            })
            ->orderBy('n.created_at', 'DESC')
            // ->groupBy('n.id')
            ->groupBy('n.id')
            ->select(
               'n.*',
               DB::raw("group_concat(DISTINCT bad.berita_acara_no SEPARATOR ', ') as berita_acara_group"),
               // DB::raw("group_concat(DISTINCT e.expedition_name SEPARATOR ', ') as expedition_name"),
               // 'e.expedition_name',
               'ba.date_of_receipt',
               'nd.destination',
               'ns.unit',
               'ns.sum_price',
               'ns.sub_total',
               'ns.sum_qty',
               DB::raw("group_concat(DISTINCT ba.expedition_name SEPARATOR ', ') as expedition_name"),
               DB::raw("group_concat(DISTINCT ba.driver_name SEPARATOR ', ') as driver_name"),
               DB::raw("group_concat(DISTINCT ba.vehicle_number SEPARATOR ', ') as vehicle_number"),
               DB::raw("group_concat(DISTINCT bad.do_no SEPARATOR ', ') as do_no"),
               DB::raw("group_concat(DISTINCT bad.model_name SEPARATOR ', ') as model_name"),
               DB::raw("group_concat(DISTINCT bad.serial_number SEPARATOR ', ') as serial_number"),
               DB::raw("group_concat(DISTINCT bad.qty SEPARATOR ', ') as qty"),
               DB::raw("group_concat(DISTINCT bad.description SEPARATOR ', ') as description"),
               DB::raw("group_concat(DISTINCT ba.created_at SEPARATOR ', ') as reporting_date"),
            )
            ->whereIn('ba.kode_cabang', auth()->user()->getStringGrantCabangShortDesc())
            ->whereNotNull('n.submit_date');
         // dd($claimNoteSubQuery->get());
         $datatables = DataTables::of($query)
            ->addIndexColumn(); //DT_RowIndex (Penomoran)

         return $datatables->make(true);
      }

      // return  view('web.claim.claim-notes._print');
      // return auth()->user()->cabang->short_description;
      return view('web.claim.summary-claim-notes.index');
   }

   /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function show(Request $request, $id)
   {
      if ($request->ajax()) {
         $query = ClaimNote::from('clm_claim_notes AS n')
            ->leftJoin('clm_claim_note_detail AS nd', 'nd.claim_note_id', '=', 'n.id')
            ->leftJoin('clm_berita_acara_detail AS bad', 'bad.id', '=', 'nd.berita_acara_detail_id')
            ->leftJoin('clm_berita_acara AS ba', 'bad.berita_acara_id', '=', 'ba.id')
            ->leftJoin('tr_expedition AS e', 'e.code', '=', 'ba.expedition_code')
            ->orderBy('n.created_at', 'DESC')
            ->where('n.id', $id)
            ->select(
               'n.*',
               'e.expedition_name',
               'ba.date_of_receipt',
               'ba.berita_acara_no',
               'nd.destination',
               DB::raw('nd.location AS warehouse'),
               'nd.driver_name',
               'nd.vehicle_number',
               'nd.do_no',
               'nd.model_name',
               'nd.serial_number',
               'nd.description',
               'nd.qty',
               'nd.price',
               'nd.id AS claim_note_detail',
               'bad.photo_url'
            );

         $datatables = DataTables::of($query)
            ->addIndexColumn(); //DT_RowIndex (Penomoran)

         return $datatables->make(true);
      }
      $data['claimNote'] = ClaimNote::where('id', $id)->first();
      return view('web.claim.summary-claim-notes.view', $data);
   }

   public function update(Request $req, $id)
   {
      if ($req->ajax()) {
         // parsing from string to array

         try {
            DB::transaction(function () use (&$req, &$id) {

               Claimnote::whereId($id)->update([
                  "send_to_management" => !empty($req->send_to_management) ? $req->send_to_management : '',
                  "approval_start_date" => !empty($req->approval_start_date) ? $req->approval_start_date : '',
                  "approval_finish_date" => !empty($req->approval_finish_date) ? $req->approval_finish_date : '',
                  "so_issue_date" => !empty($req->so_issue_date) ? $req->so_issue_date : '',
                  "date_picking_expedition" => !empty($req->date_picking_expedition) ? $req->date_picking_expedition : '',
                  "dn_issue" => !empty($req->dn_issue) ? $req->dn_issue : '',
                  "remarks" => !empty($req->remarks) ? $req->remarks : '',

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

   public function export(Request $request)
   {

      $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
      $sheet       = $spreadsheet->getActiveSheet();

      $sheet->setCellValue('A1', 'NO')->mergeCells('A1:A2');
      $sheet->setCellValue('B1', 'Berita Acara No')->mergeCells('B1:B2');
      $sheet->setCellValue('C1', 'Claim Note')->mergeCells('C1:C2');
      $sheet->setCellValue('D1', 'Date Of Incident')->mergeCells('D1:D2');
      $sheet->setCellValue('E1', 'Reporting Date')->mergeCells('E1:E2');
      $sheet->setCellValue('F1', 'Expedition Name')->mergeCells('F1:F2');
      $sheet->setCellValue('G1', 'Driver')->mergeCells('G1:G2');
      $sheet->setCellValue('H1', 'Vehicle No')->mergeCells('H1:H2');
      $sheet->setCellValue('I1', 'Destination')->mergeCells('I1:I2');
      $sheet->setCellValue('J1', 'Do No')->mergeCells('J1:J2');
      $sheet->setCellValue('K1', 'Model')->mergeCells('K1:K2');
      $sheet->setCellValue('L1', 'Serial No')->mergeCells('L1:L2');
      $sheet->setCellValue('M1', 'Qty')->mergeCells('M1:M2');
      $sheet->setCellValue('N1', 'Damage Descritption')->mergeCells('N1:N2');
      $sheet->setCellValue('O1', 'Claim')->mergeCells('O1:O2');
      $sheet->setCellValue('P1', 'Price')->mergeCells('P1:P2');
      $sheet->setCellValue('Q1', 'Total')->mergeCells('Q1:Q2');
      $sheet->setCellValue('R1', 'Send to Management')->mergeCells('R1:R2');
      $sheet->setCellValue('S1', 'Approval Date')->mergeCells('S1:T1');
      $sheet->setCellValue('U1', 'Admin Prces');
      $sheet->setCellValue('V1', 'Date Picking Expedition')->mergeCells('V1:V2');
      $sheet->setCellValue('W1', 'Admin Prces');
      $sheet->setCellValue('X1', 'Remarks')->mergeCells('X1:X2');

      $sheet->setCellValue('S2', 'Start');
      $sheet->setCellValue('T2', 'Finish');
      $sheet->setCellValue('U2', 'SO Issue Date');
      $sheet->setCellValue('W2', 'DN Issue');

      // getPHPSpreadsheetTitleStyle() ada di wms Helper
      $sheet->getStyle('A1:X2')->applyFromArray(getPHPSpreadsheetTitleStyle());


      $claimNoteSubQuery = ClaimNoteDetail::select(
         'claim_note_id',
         DB::raw("sum(1) as unit"),
         DB::raw("sum(qty) as sum_qty"),
         DB::raw("sum( if(clm_claim_notes.claim = 'unit', price * 111 / 100, price) ) as sum_price"),
         DB::raw("sum( if(clm_claim_notes.claim = 'unit', price * 111 / 100, price) *qty) as sub_total")
      )
         ->leftJoin('clm_claim_notes', 'clm_claim_notes.id', '=', 'clm_claim_note_detail.claim_note_id')
         ->groupBy('claim_note_id');
      $data = ClaimNote::from('clm_claim_notes AS n')
         ->leftJoin('clm_claim_note_detail AS nd', 'nd.claim_note_id', '=', 'n.id')
         ->leftJoin('clm_berita_acara_detail AS bad', 'bad.id', '=', 'nd.berita_acara_detail_id')
         ->leftJoin('clm_berita_acara AS ba', 'bad.berita_acara_id', '=', 'ba.id')
         ->leftJoin('tr_expedition AS e', 'e.code', '=', 'ba.expedition_code')
         ->joinSub($claimNoteSubQuery, 'ns', function ($join) {
            $join->on('n.id', '=', 'ns.claim_note_id');
         })
         ->orderBy('n.created_at', 'DESC')
         // ->groupBy('n.id')
         ->groupBy('n.id')
         ->select(
            'n.*',
            DB::raw("group_concat(DISTINCT bad.berita_acara_no SEPARATOR ', ') as berita_acara_group"),
            // DB::raw("group_concat(DISTINCT e.expedition_name SEPARATOR ', ') as expedition_name"),
            // 'e.expedition_name',
            'ba.date_of_receipt',
            'nd.destination',
            'ns.unit',
            'ns.sum_price',
            'ns.sub_total',
            'ns.sum_qty',
            DB::raw("group_concat(DISTINCT ba.expedition_name SEPARATOR ', ') as expedition_name"),
            DB::raw("group_concat(DISTINCT ba.driver_name SEPARATOR ', ') as driver_name"),
            DB::raw("group_concat(DISTINCT ba.vehicle_number SEPARATOR ', ') as vehicle_number"),
            DB::raw("group_concat(DISTINCT bad.do_no SEPARATOR ', ') as do_no"),
            DB::raw("group_concat(DISTINCT bad.model_name SEPARATOR ', ') as model_name"),
            DB::raw("group_concat(DISTINCT bad.serial_number SEPARATOR ', ') as serial_number"),
            DB::raw("group_concat(DISTINCT bad.qty SEPARATOR ', ') as qty"),
            DB::raw("group_concat(DISTINCT bad.description SEPARATOR ', ') as description"),
            DB::raw("group_concat(DISTINCT ba.created_at SEPARATOR ', ') as reporting_date"),
         )
         ->whereNotNull('n.submit_date')
         ->whereIn('n.id', $request->data)
         ->get();

      $row = 3;
      foreach ($data as $key => $value) {
         $col = 'A';
         $sheet->setCellValue(($col++) . $row, ($key + 1));
         $sheet->setCellValue(($col++) . $row, $value->berita_acara_group);
         $sheet->setCellValue(($col++) . $row, $value->claim_note_no);
         $sheet->setCellValue(($col++) . $row, format_tanggal_jam_wms($value->created_at));
         $sheet->setCellValue(($col++) . $row, format_tanggal_jam_wms($value->date_of_receipt));
         $sheet->setCellValue(($col++) . $row, $value->expedition_name);
         $sheet->setCellValue(($col++) . $row, $value->driver_name);
         $sheet->setCellValue(($col++) . $row, $value->vehicle_number);
         $sheet->setCellValue(($col++) . $row, $value->vehicle_number);
         $sheet->setCellValue(($col++) . $row, $value->do_no);
         $sheet->setCellValue(($col++) . $row, $value->model_name);
         $sheet->setCellValue(($col++) . $row, $value->serial_number);
         $sheet->setCellValue(($col++) . $row, $value->sum_qty);
         $sheet->setCellValue(($col++) . $row, $value->description);
         $sheet->setCellValue(($col++) . $row, $value->claim);
         $sheet->setCellValue(($col++) . $row, $value->sum_price);
         $sheet->setCellValue(($col++) . $row, $value->sub_total);
         $sheet->setCellValue(($col++) . $row, format_tanggal_jam_wms($value->send_to_management));
         $sheet->setCellValue(($col++) . $row, format_tanggal_jam_wms($value->approval_start_date));
         $sheet->setCellValue(($col++) . $row, format_tanggal_jam_wms($value->approval_finish_date));
         $sheet->setCellValue(($col++) . $row, format_tanggal_jam_wms($value->so_issue_date));
         $sheet->setCellValue(($col++) . $row, format_tanggal_jam_wms($value->date_picking_expedition));
         $sheet->setCellValue(($col++) . $row, $value->dn_issue);
         $sheet->setCellValue(($col++) . $row, $value->remarks);
         $row++;
      }

      $colResize = 'A';
      while ($colResize != $col) {
         $sheet->getColumnDimension($colResize++)->setAutoSize(true);
      }

      $title = 'Summary Claim Notes';

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
