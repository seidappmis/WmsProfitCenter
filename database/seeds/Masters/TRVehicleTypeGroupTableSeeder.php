<?php
namespace Database\Seeds\Masters;

use DB;
use Illuminate\Database\Seeder;

class TRVehicleTypeGroupTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $file = fopen('database/seeds/source_files/tr_vehicle_type_group.csv', "r");

    $tr_vehicle_type_groups = [];

    while (!feof($file)) {
      $row = fgetcsv($file);

      $vehicle_type_group['id']         = $row[0];
      $vehicle_type_group['group_name'] = $row[1];

      if (!empty($vehicle_type_group['id'])) {
        $tr_vehicle_type_groups[] = $vehicle_type_group;
      }
    }

    fclose($file);

    DB::table('tr_vehicle_type_group')->insert($tr_vehicle_type_groups);
  }
}
