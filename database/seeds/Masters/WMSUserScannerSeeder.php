<?php

namespace Database\Seeds\Masters;

use Illuminate\Database\Seeder;
use DB;

class WMSUserScannerSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $file = fopen('database/seeds/source_files/wms_user_scanner.csv', "r");

    $user_scanners = [];

    while (!feof($file)) {
      $row = fgetcsv($file);

      if (!empty($row[0])) {
        $user_scanner['userid']        = $row[0];
        $user_scanner['roles']         = $row[1];
        $user_scanner['status_active'] = $row[4];

        $user_scanners[] = $user_scanner;
      }
    }

    fclose($file);

    DB::table('wms_user_scanner')->insert($user_scanners);
  }
}
