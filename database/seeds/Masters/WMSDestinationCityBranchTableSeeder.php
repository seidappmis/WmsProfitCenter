<?php
namespace Database\Seeds\Masters;

use DB;
use Illuminate\Database\Seeder;

class WMSDestinationCityBranchTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $file = fopen('database/seeds/source_files/wms_destinationcity_branch.csv', "r");

    $destinationcity_branchs = [];

    while (!feof($file)) {
      $row = fgetcsv($file);

      $destinationcity_branch['id']          = $row[0];
      $destinationcity_branch['kode_cabang'] = $row[1];
      $destinationcity_branch['city_name']   = $row[2];

      if (!empty($destinationcity_branch['id'])) {
        $destinationcity_branchs[] = $destinationcity_branch;
      }
    }

    fclose($file);

    DB::table('wms_destinationcity_branch')->insert($destinationcity_branchs);
  }
}
