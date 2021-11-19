<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\FinishGoodTicket;
use Illuminate\Http\Request;

class BarcodeController extends Controller{

	public function upload(Request $request){
		$data = $request->post('data', []);
		try {
			foreach ($data as &$d) {
				$d['created_at'] = date('Y-m-d H:i:s');
			}
			FinishGoodTicket::insert($data);
			return [
				'status' => 'success',
				'message' => "Sukses insert data barcode",
			];
		} catch (\Throwable $th) {
			return [
				'status' => 'failed',
				'message' => $th->getMessage(),
			];
		}
	}

}