<?php
namespace Database\Seeds\Masters;

use DB;
use Illuminate\Database\Seeder;

class WMSStorageTypesTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('storage_types')->insert([
      [
        'id'                => 1,
        'storage_type'      => '1st Class',
        'storage_rank'      => 1,
        'storage_intransit' => 0,
      ],
      [
        'id'                => 2,
        'storage_type'      => 'Return All',
        'storage_rank'      => 2,
        'storage_intransit' => 0,
      ],
      [
        'id'                => 3,
        'storage_type'      => 'Intransit BR',
        'storage_rank'      => 3,
        'storage_intransit' => 1,
      ],
      [
        'id'                => 4,
        'storage_type'      => 'Intransit DS',
        'storage_rank'      => 4,
        'storage_intransit' => 1,
      ],
      [
        'id'                => 5,
        'storage_type'      => '2nd Class Insurance',
        'storage_rank'      => 2,
        'storage_intransit' => 0,
      ],
      [
        'id'                => 6,
        'storage_type'      => '2nd Class Transporter',
        'storage_rank'      => 2,
        'storage_intransit' => 0,
      ],
      [
        'id'                => 7,
        'storage_type'      => '2nd Class Dispose',
        'storage_rank'      => 2,
        'storage_intransit' => 0,
      ],
      [
        'id'                => 8,
        'storage_type'      => '2nd Class Direct for Sale',
        'storage_rank'      => 2,
        'storage_intransit' => 0,
      ],
      [
        'id'                => 9,
        'storage_type'      => '2nd Class Display',
        'storage_rank'      => 2,
        'storage_intransit' => 0,
      ],
      [
        'id'                => 10,
        'storage_type'      => '2nd Class Refurbish',
        'storage_rank'      => 2,
        'storage_intransit' => 0,
      ],
      [
        'id'                => 11,
        'storage_type'      => '2nd Class Waiting SO Return',
        'storage_rank'      => 2,
        'storage_intransit' => 0,
      ],
      [
        'id'                => 13,
        'storage_type'      => 'Return Not Process Yet',
        'storage_rank'      => 2,
        'storage_intransit' => 0,
      ],
    ]);
  }
}
