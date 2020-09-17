<?php
namespace Database\Seeds\Masters;

use DB;
use Illuminate\Database\Seeder;

class WMSBranchDriverTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $file = fopen('database/seeds/source_files/wms_branch_driver.csv', "r");

    $branch_drivers = [];

    while (!feof($file)) {
      $row = fgetcsv($file);

      if (!empty($row[0])) {
        $branch_driver['driver_id']            = $row[0];
        $branch_driver['driver_name']          = $row[1];
        $branch_driver['expedition_code']      = $row[2];
        $branch_driver['driving_license_type'] = $row[3];
        $branch_driver['driving_license_no']   = $row[4];
        $branch_driver['ktp_no']               = $row[5];
        $branch_driver['phone1']               = $row[6];
        $branch_driver['phone2']               = $row[7];
        $branch_driver['photo_name']           = $row[8];
        $branch_driver['remarks1']             = $row[9];
        $branch_driver['remarks2']             = $row[10];
        $branch_driver['remarks3']             = $row[11];
        $branch_driver['active_status']        = $row[16];
        $branch_driver['kode_cabang']          = $row[17];

        $branch_drivers[] = $branch_driver;
      }
    }

    fclose($file);

    DB::table('wms_branch_driver')->insert($branch_drivers);
  }
}
