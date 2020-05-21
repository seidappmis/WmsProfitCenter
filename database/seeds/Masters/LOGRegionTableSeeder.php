<?php
namespace Database\Seeds\Masters;

use DB;
use Illuminate\Database\Seeder;

class LOGRegionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('log_region')->insert([
	      [
	        'region'      => 'JABODETABEK',
	      ],
	      [
	        'region'      => 'JAWA',
	      ],
	      [
	        'region'      => 'KALIMANTAN',
	      ],
	      [
	        'region'      => 'SULAWESI',
	      ],
	      [
	        'region'      => 'SUMATERA',
	      ],
	    ]);
    }
}
