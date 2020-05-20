<?php
namespace Database\Seeds\Masters;

use DB;
use Illuminate\Database\Seeder;

class WMSModelMaterialGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('wms_model_material_group')->insert([
	      [
	        'code'     		  => 'BG',
	        'description'     => 'F3 LED Lightning',
	        'business_unit'   => 'BU-F3',
	      ],
	      [
	        'code'     		  => 'BJ',
	        'description'     => 'C1 Energy Solution Japan',
	        'business_unit'   => 'BU-C1',
	      ],
	      [
	        'code'     		  => 'BP',
	        'description'     => 'C1 LED Energy Solution Overseas',
	        'business_unit'   => 'BU-C1',
	      ],
	      [
	        'code'     		  => 'EG',
	        'description'     => 'B3 Laundry',
	        'business_unit'   => 'BU-B3',
	      ],
	      [
	        'code'     		  => 'MA',
	        'description'     => 'G1 DVD/BD',
	        'business_unit'   => 'BU-G1',
	      ],
	      [
	        'code'     		  => 'MH',
	        'description'     => 'G1 CRT TV/VTR',
	        'business_unit'   => 'BU-G1',
	      ],
	      [
	        'code'     		  => 'MK',
	        'description'     => 'D2 Projector',
	        'business_unit'   => 'BU-D2',
	      ],
	      [
	        'code'     		  => 'MS',
	        'description'     => 'G1 LCD TV_Asia',
	        'business_unit'   => 'BU-G1',
	      ],
	      [
	        'code'     		  => 'MT',
	        'description'     => 'G1 General Audio',
	        'business_unit'   => 'BU-G1',
	      ],
	    ]);
    }
}
