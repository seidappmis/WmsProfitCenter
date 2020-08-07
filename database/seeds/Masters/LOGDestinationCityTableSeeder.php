<?php
namespace Database\Seeds\Masters;

use DB;
use Illuminate\Database\Seeder;

class LOGDestinationCityTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $file = fopen('database/seeds/source_files/log_destination_city.csv', "r");

    $log_destination_citys = [];

    while (!feof($file)) {
      $row = fgetcsv($file);

      if (!empty($row[0])) {

        $destination_city['city_code'] = $row[0];
        $destination_city['city_name'] = $row[1];

        $log_destination_citys[] = $destination_city;
      }
    }

    fclose($file);

    DB::table('log_destination_city')->insert($log_destination_citys);
  }
}
