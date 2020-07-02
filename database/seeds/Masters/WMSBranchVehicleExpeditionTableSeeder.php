<?php
namespace Database\Seeds\Masters;

use DB;
use Illuminate\Database\Seeder;

class WMSBranchVehicleExpeditionTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $file = fopen('database/seeds/source_files/wms_branch_vehicle_expedition.csv', "r");

    $wms_branch_vehicle_expeditions = [];

    while (!feof($file)) {
      $row = fgetcsv($file);

      $branch_vehicle_expedition['id']                         = $row[0];
      $branch_vehicle_expedition['vehicle_code_type']          = $row[1];
      $branch_vehicle_expedition['expedition_code']            = $row[2];
      $branch_vehicle_expedition['vehicle_number']             = $row[3];
      $branch_vehicle_expedition['vehicle_detail_description'] = $row[4];
      $branch_vehicle_expedition['remark1']                    = $row[9];
      $branch_vehicle_expedition['remark2']                    = $row[10];
      $branch_vehicle_expedition['remark3']                    = $row[11];
      $branch_vehicle_expedition['destination']                = $row[12];
      $branch_vehicle_expedition['status_active']              = $row[13];

      if (!empty($branch_vehicle_expedition['id'])) {
        $wms_branch_vehicle_expeditions[] = $branch_vehicle_expedition;
      }
    }

    fclose($file);

    DB::table('wms_branch_vehicle_expedition')->insert($wms_branch_vehicle_expeditions);
  }
}
