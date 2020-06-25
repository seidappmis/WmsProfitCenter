<?php
namespace Database\Seeds\Masters;

use DB;
use Illuminate\Database\Seeder;

class TRExpeditionTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $file = fopen('database/seeds/source_files/tr_expedition.csv', "r");

    $tr_expeditions = [];

    while (!feof($file)) {
      $row = fgetcsv($file);

      $expedition['id']              = $row[0];
      $expedition['expedition_name'] = $row[1];
      $expedition['npwp']            = $row[2];
      $expedition['code']            = $row[3];
      $expedition['address']         = $row[4];
      $expedition['sap_vendor_code'] = $row[5];
      $expedition['contact_person']  = $row[6];
      $expedition['phone_number_1']  = $row[7];
      $expedition['phone_number_2']  = $row[8];
      $expedition['fax_number']      = $row[9];
      $expedition['bank']            = $row[10];
      $expedition['currency']        = $row[11];
      $expedition['remark1']         = $row[12];
      $expedition['remark2']         = $row[13];
      $expedition['remark3']         = $row[14];
      $expedition['status_active']   = $row[19];

      if (!empty($expedition['id'])) {
        $tr_expeditions[] = $expedition;
      }
    }

    fclose($file);

    DB::table('tr_expedition')->insert($tr_expeditions);
  }
}
