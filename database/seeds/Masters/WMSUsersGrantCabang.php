<?php
namespace Database\Seeds\Masters;

use DB;
use Illuminate\Database\Seeder;

class WMSUsersGrantCabang extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $file = fopen('database/seeds/source_files/wms_users_grant_cabang.csv', "r");

    $users_grant_cabangs = [];

    while (!feof($file)) {
      $row = fgetcsv($file);

      if (!empty($row[0])) {
        $users_grant_cabang['userid']            = $row[0];
        $users_grant_cabang['kode_cabang_grant'] = $row[1];
        $users_grant_cabangs[]                   = $users_grant_cabang;
      }
    }

    fclose($file);

    DB::table('wms_users_grant_cabang')->insert($users_grant_cabangs);
  }
}
