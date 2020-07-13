<?php
namespace Database\Seeds\Masters;

use DB;
use Illuminate\Database\Seeder;

class TRVehicleExpeditionTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $file = fopen('database/seeds/source_files/tr_vehicle_expedition.csv', "r");

    $tr_vehicle_expeditions = [];

    while (!feof($file)) {
      $row = fgetcsv($file);

      $vehicle['id']                         = $row[0];
      $vehicle['vehicle_code_type']          = $row[1];
      $vehicle['expedition_code']            = $row[2];
      $vehicle['vehicle_number']             = $row[3];
      $vehicle['vehicle_detail_description'] = $row[4];
      $vehicle['remark1']                    = $row[9];
      $vehicle['remark2']                    = $row[10];
      $vehicle['remark3']                    = $row[11];
      $vehicle['destination']                = $row[12];
      $vehicle['status_active']              = $row[13];

      if (!empty($vehicle['id'])) {
        $tr_vehicle_expeditions[] = $vehicle;
      }
    }

    fclose($file);

    DB::table('tr_vehicle_expedition')->insert($tr_vehicle_expeditions);
  }
}
