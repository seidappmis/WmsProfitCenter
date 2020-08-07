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
    $file = fopen('database/seeds/source_files/log_cabang.csv', "r");

    $log_cabangs = [];

    while (!feof($file)) {
      $row = fgetcsv($file);

      if (!empty($row[0])) {
        $cabang['kode_customer']     = $row[0];
        $cabang['kode_cabang']       = $row[1];
        $cabang['short_description'] = $row[2];
        $cabang['long_description']  = $row[3];
        $cabang['type']              = $row[4];
        $cabang['region']            = $row[9];
        $cabang['hq']                = $row[10];

        $log_cabangs[] = $cabang;
      }
    }

    fclose($file);

    DB::table('log_cabang')->insert($log_cabangs);

    // DB::table('log_cabang')->insert([
    //   [
    //     'kode_customer'     => '10000000',
    //     'kode_cabang'       => '10',
    //     'short_description' => 'HYP',
    //     'long_description'  => 'PT. SEID HQ JKT',
    //     'region'            => 'JABODETABEK',
    //     'type'              => 'BR',
    //     'hq'                => 1,
    //     // 'start_wms'         => '',
    //   ],
    //   [
    //     'kode_customer'     => '11000000',
    //     'kode_cabang'       => '11',
    //     'short_description' => 'JKT',
    //     'long_description'  => 'PT. SEID CAB. JAKARTA',
    //     'region'            => 'JABODETABEK',
    //     'type'              => 'BR',
    //     'hq'                => 1,
    //     // 'start_wms'         => '',
    //   ],
    //   [
    //     'kode_customer'     => '12000000',
    //     'kode_cabang'       => '12',
    //     'short_description' => 'JF',
    //     'long_description'  => 'PT. SEID CAB. JAKARTA',
    //     'region'            => 'JABODETABEK',
    //     'type'              => 'BR',
    //     'hq'                => 0,
    //     // 'start_wms'         => '',
    //   ],
    //   [
    //     'kode_customer'     => '13000000',
    //     'kode_cabang'       => '13',
    //     'short_description' => 'BDG',
    //     'long_description'  => 'PT. SEID CAB. BANDUNG',
    //     'region'            => 'JAWA',
    //     'type'              => 'BR',
    //     'hq'                => 0,
    //     // 'start_wms'         => '',
    //   ],
    //   [
    //     'kode_customer'     => '14000000',
    //     'kode_cabang'       => '14',
    //     'short_description' => 'CRB',
    //     'long_description'  => 'PT. SEID CAB. CIREBON',
    //     'region'            => 'JAWA',
    //     'type'              => 'BR',
    //     'hq'                => 0,
    //     // 'start_wms'         => '',
    //   ],
    //   [
    //     'kode_customer'     => '15000000',
    //     'kode_cabang'       => '15',
    //     'short_description' => 'SMG',
    //     'long_description'  => 'PT. SEID CAB. SEMARANG',
    //     'region'            => 'JAWA',
    //     'type'              => 'BR',
    //     'hq'                => 0,
    //     // 'start_wms'         => '',
    //   ],
    //   [
    //     'kode_customer'     => '16000000',
    //     'kode_cabang'       => '16',
    //     'short_description' => 'YGY',
    //     'long_description'  => 'PT. SEID CAB. YOGYAKARTA',
    //     'region'            => 'JAWA',
    //     'type'              => 'BR',
    //     'hq'                => 0,
    //     // 'start_wms'         => '',
    //   ],
    // ]);
  }
}
