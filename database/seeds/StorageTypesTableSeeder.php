<?php

use Illuminate\Database\Seeder;

class StorageTypesTableSeeder extends Seeder
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
        'id'                => '1',
        'storage_type'      => '1st Class',
        'storage_rank'      => null,
        'storage_intransit' => null,
      ],
      [
        'id'                => '2',
        'storage_type'      => 'Return All',
        'storage_rank'      => null,
        'storage_intransit' => null,
      ],
      [
        'id'                => '3',
        'storage_type'      => '2nd Class',
        'storage_rank'      => null,
        'storage_intransit' => null,
      ],
    ]);
  }
}
