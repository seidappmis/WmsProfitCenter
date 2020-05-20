<?php
namespace Database\Seeds\Masters;

use DB;
use Illuminate\Database\Seeder;

class WMSModelCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('wms_model_category')->insert([
	      [
	        'category_name'     => 'AC',
	      ],
	      [
	        'category_name'     => 'AP',
	      ],
	      [
	        'category_name'     => 'AU',
	      ],
	      [
	        'category_name'     => 'CB',
	      ],
	      [
	        'category_name'     => 'HA',
	      ],
	      [
	        'category_name'     => 'MO',
	      ],
	      [
	        'category_name'     => 'SH',
	      ],
	      [
	        'category_name'     => 'TV',
	      ],
	      [
	        'category_name'     => 'WM',
	      ],
	    ]);
    }
}
