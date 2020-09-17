<?php
namespace Database\Seeds\Masters;

use DB;
use Illuminate\Database\Seeder;

class LOGFreightCostTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $file = fopen('database/seeds/source_files/log_freight_cost.csv', "r");

    $log_freight_costs = [];

    while (!feof($file)) {
      $row = fgetcsv($file);

      if (!empty($row[0])) {
        $freight_cost['id']                = $row[0];
        $freight_cost['area']              = $row[1];
        $freight_cost['city_code']         = $row[2];
        $freight_cost['expedition_code']   = $row[3];
        $freight_cost['vehicle_code_type'] = $row[4];
        $freight_cost['ritase']            = $row[5];
        $freight_cost['ritase2']           = $row[6];
        $freight_cost['cbm']               = $row[7];
        $freight_cost['ambil_sendiri']     = $row[8];
        $freight_cost['leadtime']          = $row[9];

        $log_freight_costs[] = $freight_cost;
      }
    }

    fclose($file);

    DB::table('log_freight_cost')->insert($log_freight_costs);
  }
}
