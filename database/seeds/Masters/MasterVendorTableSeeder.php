<?php
namespace Database\Seeds\Masters;

use DB;
use Illuminate\Database\Seeder;

class MasterVendorTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $file = fopen('database/seeds/source_files/wms_master_vendor.csv', "r");

    $master_vendors = [];

    while (!feof($file)) {
      $row = fgetcsv($file);

      if (!empty($row[0])) {
        $vendor['vendor_code']          = $row[0];
        $vendor['vendor_name']          = $row[1];
        $vendor['description']          = $row[2];
        $vendor['vendor_address']       = $row[3];
        $vendor['contact_person_name']  = $row[4];
        $vendor['contact_person_phone'] = $row[5];
        $vendor['contact_person_email'] = $row[6];

        $master_vendors[] = $vendor;
      }
    }

    fclose($file);

    DB::table('master_vendor')->insert($master_vendors);
  }
}
