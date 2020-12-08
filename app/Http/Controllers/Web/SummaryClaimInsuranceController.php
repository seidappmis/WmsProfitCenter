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
                  "remark" => !empty($req->remark) ? $req->remark : '',

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
}
