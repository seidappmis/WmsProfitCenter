<?php
namespace Database\Seeds\Masters;

use DB;
use Illuminate\Database\Seeder;

class WMSBranchExpeditionTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $file = fopen('database/seeds/source_files/wms_branch_expedition.csv', "r");

    $wms_branch_expeditions = [];

    while (!feof($file)) {
      $row = fgetcsv($file);

      if (!empty($row[0])) {
        $branch_expedition['id']              = $row[0];
        $branch_expedition['initial']         = $row[1];
        $branch_expedition['expedition_name'] = $row[2];
        $branch_expedition['npwp']            = $row[3];
        $branch_expedition['code']            = $row[4];
        $branch_expedition['address']         = $row[5];
        $branch_expedition['sap_vendor_code'] = $row[6];
        $branch_expedition['contact_person']  = $row[7];
        $branch_expedition['phone_number_1']  = $row[8];
        $branch_expedition['phone_number_2']  = $row[9];
        $branch_expedition['fax_number']      = $row[10];
        $branch_expedition['bank']            = $row[11];
        $branch_expedition['currency']        = $row[12];
        $branch_expedition['remark1']         = $row[13];
        $branch_expedition['remark2']         = $row[14];
        $branch_expedition['remark3']         = $row[15];
        $branch_expedition['status_active']   = $row[20];
        $branch_expedition['kode_cabang']     = $row[21];

        $wms_branch_expeditions[] = $branch_expedition;
      }
    }

    fclose($file);

    DB::table('wms_branch_expedition')->insert($wms_branch_expeditions);
  }
}
