<?php
namespace Database\Seeds\Masters;

use DB;
use Illuminate\Database\Seeder;

class WMSMasterModelSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $file = fopen('database/seeds/source_files/wms_master_model.csv', "r");

    $master_models = [];

    while (!feof($file)) {
      $row = fgetcsv($file);

      if (!empty($row[0])) {

        $model['id']               = $row[0];
        $model['model_name']       = $row[1];
        $model['ean_code']         = $row[2];
        $model['cbm']              = $row[3];
        $model['material_group']   = $row[4];
        $model['category']         = $row[5];
        $model['model_type']       = $row[6];
        $model['pcs_ctn']          = $row[7];
        $model['ctn_plt']          = $row[8];
        $model['max_pallet']       = $row[9];
        $model['description']      = $row[10];
        $model['price1']           = $row[15];
        $model['price2']           = $row[16];
        $model['price3']           = $row[17];
        $model['model_from_apbar'] = $row[18];

        $master_models[] = $model;
      }
    }

    fclose($file);

    DB::table('wms_master_model')->insert($master_models);
  }
}
