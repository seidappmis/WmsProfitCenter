<?php
namespace Database\Seeds\Masters;

use DB;
use Illuminate\Database\Seeder;

class TRAreaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tr_area')->insert([
	      [
	        'area'      => 'All',
	        'code'      => null,
	      ],
	      [
	        'area'      => 'KARAWANG',
	        'code'      => 'KRW',
	      ],
	      [
	        'area'      => 'SURABAYA HUB',
	        'code'      => 'SBY',
	      ],
	      [
	        'area'      => 'SWADAYA',
	        'code'      => 'JKT',
	      ],
	    ]);
    }
}
