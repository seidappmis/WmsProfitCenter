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
    DB::table('master_vendor')->insert([
      [
        'vendor_code' => '10ED03',
        'vendor_name' => 'DAEWOO ELECTRONICS (M) SDN.BHD.',
        'description' => 'DAEWOO ELECTRONICS (M) SDN.BHD.',
        'vendor_address'     => 'LOT 8,JLN PKNK, 1/2 SUNGAI PETANI INDUSTRIAL ESTATE',
      ],
      [
        'vendor_code' => '10EE04',
        'vendor_name' => 'ELECTROTEMP TECHNOLOGIES CHINA INC.',
        'description' => 'ELECTROTEMP TECHNOLOGIES CHINA INC.',
        'vendor_address'     => 'NO.9 YAN SHAN HE N.ROAD, NINGBO, ZHEJIANG, BEILUN DISTRICT',
      ],
      [
        'vendor_code' => '10EF03',
        'vendor_name' => 'FEDERAL ELECTRIC CORP.,LTD.',
        'description' => 'FEDERAL ELECTRIC CORP.,LTD.',
        'vendor_address'     => '64/1 MOO 4 KINGKAEW ROAD,',
      ],
    ]);
  }
}
