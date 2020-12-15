<?php

namespace App\Http\Controllers\Web;

use DB;
use DataTables;
use App\Models\MarineCargo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
}
