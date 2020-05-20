<?php
namespace Database\Seeds\Masters;

use DB;
use Illuminate\Database\Seeder;

class WMSModelTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('wms_model_type')->insert([
	      [
	        'model_type'     	  => 'IMPORT',
	        'model_type_desc'     => 'IMPORT',
	      ],
	      [
	        'model_type'     	  => 'LOCAL',
	        'model_type_desc'     => 'LOCAL',
	      ],
	      [
	        'model_type'     	  => 'OEM',
	        'model_type_desc'     => 'OEM',
	      ],
	      [
	        'model_type'     	  => 'OTHERS',
	        'model_type_desc'     => 'OTHERS',
	      ],
	    ]);
    }
}
