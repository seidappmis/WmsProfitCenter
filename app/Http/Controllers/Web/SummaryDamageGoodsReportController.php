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
               DB::raw("group_concat(DISTINCT ba.category_damage SEPARATOR '|') as keterangan_group"),
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
}
