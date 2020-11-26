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
            DB::raw("sum( if(clm_claim_notes.claim = 'unit', price * 110 / 100, price) ) as sum_price"),
            DB::raw("sum( if(clm_claim_notes.claim = 'unit', price * 110 / 100, price) *qty) as sub_total")
         )
         ->leftJoin('clm_claim_notes', 'clm_claim_notes.id', '=', 'clm_claim_note_detail.claim_note_id')
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
               DB::raw("group_concat(DISTINCT e.expedition_name SEPARATOR ', ') as expedition_name"),
               // 'e.expedition_name',
               'ba.date_of_receipt',
               'nd.destination',
               'ns.unit',
               'ns.sum_price',
               'ns.sub_total'
            )
            ->whereNotNull('n.submit_date');
         // dd($query->get());

         $datatables = DataTables::of($query)
            ->addIndexColumn(); //DT_RowIndex (Penomoran)

         return $datatables->make(true);
      }

      // return  view('web.claim.claim-notes._print');
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
                  "dn_issue_date" => !empty($req->dn_issue_date) ? $req->dn_issue_date : '',
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
}
