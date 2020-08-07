<?php
namespace Database\Seeds\Masters;

use DB;
use Illuminate\Database\Seeder;

class WMSMasterStorageTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $file = fopen('database/seeds/source_files/wms_master_storage.csv', "r");

    $master_storages = [];

    while (!feof($file)) {
      $row = fgetcsv($file);

      if (!empty($row[0])) {
        $storage['id']                 = $row[0];
        $storage['kode_cabang']        = $row[1];
        $storage['sto_loc_code_short'] = $row[2];
        $storage['sto_loc_code_long']  = $row[3];
        $storage['sto_type_id']        = $row[4];
        $storage['sto_type_desc']      = $row[5];
        $storage['total_max_pallet']   = $row[6];
        $storage['intransit']          = $row[11];
        $storage['used_space']         = $row[12];
        $storage['space_wh']           = $row[13];
        $storage['hand_pallet_space']  = $row[14];

        $master_storages[] = $storage;
      }
    }

    fclose($file);

    DB::table('wms_master_storage')->insert($master_storages);
  }
}
