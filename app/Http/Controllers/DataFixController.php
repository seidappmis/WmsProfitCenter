<?php
namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataFixController extends Controller{

	public function lmb_detail(Request $request){
		try{
			$lmb = '`wms_lmb_detail`';
			$pkg = '`wms_pickinglist_header`';
			$affected = DB::update("UPDATE $lmb, $pkg
			SET $lmb.driver_register_id = $pkg.driver_register_id
			WHERE $lmb.picking_id = $pkg.id AND $lmb.driver_register_id <> $pkg.driver_register_id");
			echo "$affected rows updated in $lmb table <br/><br/>";
		}catch(Exception $e){
			echo $e->getMessage() . '<br/><br/>';
		}
	}

}