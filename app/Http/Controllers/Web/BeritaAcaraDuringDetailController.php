<?php

namespace App\Http\Controllers\Web;

use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Models\BeritaAcaraDuringDetail;
use Illuminate\Http\Request;
use DataTables;
use DB;

class BeritaAcaraDuringDetailController extends Controller
{
   public function prosesCreate(Request $req, $id)
   {
      // proses create
      if ($req->ajax()) {

         try {
            $data                  = new BeritaAcaraDuringDetail;
            $data->berita_acara_during_id = $id;
            $data->model_name = $req->model_name;
            $data->qty = $req->qty;
            $data->pom = $req->pom;
            $data->serial_number = $req->serial_number;
            $data->damage = $req->damage;

            if ($req->hasFile('photo_serial_number')) {
               $name = uniqid() . '.' . pathinfo($req->file('photo_serial_number')->getClientOriginalName(), PATHINFO_EXTENSION);
               $path = Storage::putFileAs('public/berita-acara-during/files/photo-serial-number', $req->file('photo_serial_number'), $name);
               $data->photo_serial_number  = 'berita-acara-during/files/photo-serial-number/' . $name;
            }

            if ($req->hasFile('photo_damage')) {
               $name = uniqid() . '.' . pathinfo($req->file('photo_damage')->getClientOriginalName(), PATHINFO_EXTENSION);
               $path = Storage::putFileAs('public/berita-acara-during/files/photo-damage', $req->file('photo_damage'), $name);
               $data->photo_damage  = 'berita-acara-during/files/photo-damage/' . $name;
            }

            $data->created_at =  date('Y-m-d H:i:s');
            $data->created_by = auth()->user()->id;

            DB::transaction(function () use (&$data) {
               $data->save();
            });

            return sendSuccess('Data Successfully Created.', []);
         } catch (\Exception $e) {
            return sendError($e->getMessage());
         }
      };
   }

   // DataTable claim note Index
   public function list(Request $req)
   {
      if ($req->ajax()) {
         $query = BeritaAcaraDuringDetail::where('berita_acara_during_id', $req->beritaAcaraID)->get();

         $datatables = DataTables::of($query)
            ->addIndexColumn(); //DT_RowIndex (Penomoran)

         return $datatables->make(true);
      }
   }

   public function prosesUpdate(Request $req)
   {
      // proses create
      if ($req->ajax()) {

         try {
            $data                  = BeritaAcaraDuringDetail::whereId($req->id)->first();

            $data->model_name = $req->model_name;
            $data->qty = $req->qty;
            $data->pom = $req->pom;
            $data->serial_number = $req->serial_number;
            $data->damage = $req->damage;

            if ($req->hasFile('photo_serial_number')) {
               $name = uniqid() . '.' . pathinfo($req->file('photo_serial_number')->getClientOriginalName(), PATHINFO_EXTENSION);
               $path = Storage::putFileAs('public/berita-acara-during/files/photo-serial-number', $req->file('photo_serial_number'), $name);
               $data->photo_serial_number  = 'berita-acara-during/files/photo-serial-number/' . $name;
            }

            if ($req->hasFile('photo_damage')) {
               $name = uniqid() . '.' . pathinfo($req->file('photo_damage')->getClientOriginalName(), PATHINFO_EXTENSION);
               $path = Storage::putFileAs('public/berita-acara-during/files/photo-damage', $req->file('photo_damage'), $name);
               $data->photo_damage  = 'berita-acara-during/files/photo-damage/' . $name;
            }

            $data->updated_at =  date('Y-m-d H:i:s');
            $data->updated_by = auth()->user()->id;

            DB::transaction(function () use (&$data) {
               $data->save();
            });

            return sendSuccess('Data Successfully Created.', []);
         } catch (\Exception $e) {
            return sendError($e->getMessage());
         }
      };
   }
}
