<?php
namespace Database\Seeds\Masters;

use DB;
use Illuminate\Database\Seeder;

class TRGateTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $file = fopen('database/seeds/source_files/tr_gate.csv', "r");

    $tr_gates = [];

    while (!feof($file)) {
      $row = fgetcsv($file);

      if (!empty($row[0])) {
        $gate['id']              = $row[0];
        $gate['gate_number']     = $row[1];
        $gate['description']     = $row[2];
        $gate['area']            = $row[3];
        $gate['vehicle_type_id'] = $row[4];

        $tr_gates[] = $gate;
      }
    }

    fclose($file);

    DB::table('tr_gate')->insert($tr_gates);
  }
}
