<?php

namespace App\Http\Controllers\Web;

use DB;
use DataTables;
use App\Models\MarineCargo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DamageGoodsReport;

class MarineCargoController extends Controller
{
   public function index(Request $request)
   {
      if ($request->ajax()) {
         $query = MarineCargo::leftJoin('dur_dgr AS d', 'd.id', '=', 'dur_marine_cargo.dur_dgr_id')
            ->orderBy('dur_marine_cargo.created_at', 'DESC')
            ->select('dur_marine_cargo.*')
            ->get();

         $datatables = DataTables::of($query)
            ->addIndexColumn() //DT_RowIndex (Penomoran)
         ;

         return $datatables->make(true);
      };
      return view('web.during.marine-cargo.index');
   }


   public function create()
   {
      // display create page
      return view('web.during.marine-cargo.create');
   }

   public function Postcreate(Request $req)
   {
      // proses create
      if ($req->ajax()) {
         try {
            $data = $req->all();
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = auth()->user()->id;

            DB::transaction(function () use (&$data) {
               MarineCargo::insert($data);
            });
            return sendSuccess('Data Successfully Created.', []);
         } catch (\Exception $e) {
            return sendError($e->getMessage());
         }
      };
   }

   function view($id)
   {
      $data['data'] = MarineCargo::where('id', $id)->first();

      return view('web.during.marine-cargo.view', $data);
   }

   function getSelect2DGR(Request $req)
   {
      $query = DamageGoodsReport::select(
         'dur_dgr.id',
         'dur_dgr.dgr_no AS text',
         DB::raw("group_concat(DISTINCT ba.ship_name SEPARATOR ', ') as ship_name"),
      )
         ->leftJoin('dur_dgr_detail AS dd', 'dd.dur_dgr_id', '=', 'dur_dgr.id')
         ->leftJoin('dur_berita_acara_detail AS bad', 'bad.id', '=', 'dd.berita_acara_during_detail_id')
         ->leftJoin('dur_berita_acara AS ba', 'bad.berita_acara_during_id', '=', 'ba.id')
         ->where('dur_dgr.dgr_no', 'not like', '%/NG%')
         ->Where('dur_dgr.dgr_no', 'not like', '%/MH%')
         ->groupBy('dur_dgr.id');

      return get_select2_data($req, $query);
   }
}
