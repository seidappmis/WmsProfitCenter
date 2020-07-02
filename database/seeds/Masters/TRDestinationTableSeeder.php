<?php
namespace Database\Seeds\Masters;

use DB;
use Illuminate\Database\Seeder;

class TRDestinationTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $file = fopen('database/seeds/source_files/tr_destination.csv', "r");

    $tr_destinations = [];

    while (!feof($file)) {
      $row = fgetcsv($file);

      $destination['destination_number']      = $row[0];
      $destination['destination_description'] = $row[1];
      $destination['region']                  = $row[2];
      $destination['kode_cabang']             = ($row[7] == 'NULL') ? NULL : $row[7];

      if (!empty($destination['destination_number'])) {
        $tr_destinations[] = $destination;
      }
    }

    fclose($file);

    DB::table('tr_destination')->insert($tr_destinations);
  }
}
