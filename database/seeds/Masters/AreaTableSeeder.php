<?php

use Illuminate\Database\Seeder;

class AreaTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('areas')->insert([
      [
        'id'                => 1,
        'storage_type'      => '1st Class',
        'storage_rank'      => 1,
        'storage_intransit' => 0,
      ],
    ]);
  }
}
