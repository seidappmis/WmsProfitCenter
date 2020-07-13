<?php
namespace Database\Seeds\Masters;

use DB;
use Illuminate\Database\Seeder;

class TRDriverTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $file = fopen('database/seeds/source_files/tr_driver.csv', "r");

    $tr_drivers = [];

    while (!feof($file)) {
      $row = fgetcsv($file);

      $driver['driver_id']            = $row[0];
      $driver['driver_name']          = $row[1];
      $driver['expedition_code']      = $row[2];
      $driver['driving_license_type'] = $row[3];
      $driver['driving_license_no']   = $row[4];
      $driver['ktp_no']               = $row[5];
      $driver['phone1']               = $row[6];
      $driver['phone2']               = $row[7];
      $driver['photo_name']           = $row[8];
      $driver['remarks1']             = $row[9];
      $driver['remarks2']             = $row[10];
      $driver['remarks3']             = $row[11];
      $driver['active_status']        = $row[16];

      if (!empty($driver['driver_id'])) {
        $tr_drivers[] = $driver;
      }
    }

    fclose($file);

    DB::table('tr_driver')->insert($tr_drivers);
  }
}
