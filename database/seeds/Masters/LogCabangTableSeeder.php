<?php
namespace Database\Seeds\Masters;

use DB;
use Illuminate\Database\Seeder;

class LogCabangTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('log_cabang')->insert([
      [
        'kode_customer'     => '10000000',
        'kode_cabang'       => '10',
        'short_description' => 'HYP',
        'long_description'  => 'PT. SEID HQ JKT',
        'region'            => 'JABODETABEK',
        'type'              => 'BR',
        'hq'                => 1,
        // 'start_wms'         => '',
      ],
    ]);
  }
}
