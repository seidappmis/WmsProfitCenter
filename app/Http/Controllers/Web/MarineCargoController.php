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
            $data['notice_of_claim_no'] = MarineCargo::getNoticeOfClaimNo();
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
      $data['marineCargo'] = MarineCargo::findOrFail($id);

      return view('web.during.marine-cargo.view', $data);
   }

   public function destroy($id)
   {
      return sendSuccess('Data Deleted', MarineCargo::destroy($id));
   }

   public function exportClaimNote(Request $request, $id)
   {
      $marineCargo = MarineCargo::findOrFail($id);

      $cartonBoxs = [];
      $units = [];
      foreach ($marineCargo->details() as $key => $value) {
         if ($value->claim == 'carton-box') {
            $cartonBoxs[] = $value;
         } else {
            $units[] = $value;
         }
      }

      $view_print =  view('web.during.marine-cargo.print-claim-note', [
         'marineCargo' => $marineCargo,
         'cartonBoxs' => $cartonBoxs,
         'units' => $units,
      ]);

      $title = 'Claim Note Marine Cargo';

      if ($request->input('filetype') == 'html') {

         // return $view_print;
         // request HTML View
         $mpdf = new \Mpdf\Mpdf([
            'tempDir'       => '/tmp',
            'margin_left'   => 15,
            'margin_right'  => 15,
            'margin_top'    => 20,
            'margin_bottom' => 20,
            'format'        => 'A4',
         ]);
         $mpdf->shrink_tables_to_fit = 1;
         $mpdf->WriteHTML($view_print);

         $mpdf->Output();
         return;
      } else if ($request->input('filetype') == 'xls') {

         // Request FILE EXCEL
         $reader      = new \PhpOffice\PhpSpreadsheet\Reader\Html();
         $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

         $spreadsheet = $reader->loadFromString($view_print, $spreadsheet);


         $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(4.08);
         $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(30.08);
         $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(2.08);
         $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(40.08);
         $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(2.08);

         $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
         header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
         header('Content-Disposition: attachment; filename="' . $title . '.xls"');

         $writer->save("php://output");
      } else if ($request->input('filetype') == 'pdf') {
         $mpdf = new \Mpdf\Mpdf([
            'tempDir'       => '/tmp',
            'margin_left'   => 15,
            'margin_right'  => 15,
            'margin_top'    => 20,
            'margin_bottom' => 20,
            'format'        => 'A4',
         ]);
         $mpdf->shrink_tables_to_fit = 1;
         $mpdf->WriteHTML($view_print);

         $mpdf->Output($title . '.pdf', "D");
      } else {
         // Parameter filetype tidak valid / tidak ditemukan return 404
         return redirect(404);
      }
   }

   public function exportNoticeOfClaim(Request $request, $id)
   {
      $marineCargo = MarineCargo::findOrFail($id);

      $view_print =  view('web.during.marine-cargo.print-notice-of-claim', [
         'marineCargo' => $marineCargo
      ]);

      $title = 'Notice of Claim';

      if ($request->input('filetype') == 'html') {

         // return $view_print;
         // request HTML View
         $mpdf = new \Mpdf\Mpdf([
            'tempDir'       => '/tmp',
            'margin_left'   => 15,
            'margin_right'  => 15,
            'margin_top'    => 10,
            'margin_bottom' => 10,
            'format'        => 'A4',
         ]);
         $mpdf->shrink_tables_to_fit = 1;
         $mpdf->WriteHTML($view_print);

         $mpdf->Output();
         return;
      } else if ($request->input('filetype') == 'xls') {

         // Request FILE EXCEL
         $reader      = new \PhpOffice\PhpSpreadsheet\Reader\Html();
         $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

         $spreadsheet = $reader->loadFromString($view_print, $spreadsheet);


         $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(4.08);
         $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(30.08);
         $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(2.08);
         $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(40.08);
         $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(2.08);

         $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
         header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
         header('Content-Disposition: attachment; filename="' . $title . '.xls"');

         $writer->save("php://output");
      } else if ($request->input('filetype') == 'pdf') {
         $mpdf = new \Mpdf\Mpdf([
            'tempDir'       => '/tmp',
            'margin_left'   => 15,
            'margin_right'  => 15,
            'margin_top'    => 10,
            'margin_bottom' => 10,
            'format'        => 'A4',
         ]);
         $mpdf->shrink_tables_to_fit = 1;
         $mpdf->WriteHTML($view_print);

         $mpdf->Output($title . '.pdf', "D");
      } else {
         // Parameter filetype tidak valid / tidak ditemukan return 404
         return redirect(404);
      }
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
