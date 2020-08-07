<?php
namespace Database\Seeds\Masters;

use DB;
use Illuminate\Database\Seeder;

class TRVehicleTypeDetailTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $file = fopen('database/seeds/source_files/tr_vehicle_type_detail.csv', "r");

    $tr_vehicle_type_details = [];

    while (!feof($file)) {
      $row = fgetcsv($file);

      if (!empty($row[0])) {
        $vehicle_type_detail['id']                  = $row[0];
        $vehicle_type_detail['vehicle_code_type']   = $row[1];
        $vehicle_type_detail['vehicle_description'] = $row[2];
        $vehicle_type_detail['vehicle_group_id']    = $row[3];
        $vehicle_type_detail['cbm_min']             = $row[4];
        $vehicle_type_detail['cbm_max']             = $row[5];
        $vehicle_type_detail['sap_description']     = $row[6];
        $vehicle_type_detail['vehicle_merk']        = $row[11];
        $vehicle_type_detail['urut']                = $row[12];

        $tr_vehicle_type_details[] = $vehicle_type_detail;
      }
    }

    fclose($file);

    DB::table('tr_vehicle_type_detail')->insert($tr_vehicle_type_details);
  }
}
