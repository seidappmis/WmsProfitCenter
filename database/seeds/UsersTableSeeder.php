<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('tr_user_roles')->insert([
      [
        'roles_id'   => 1,
        'roles_name' => 'IT Admin',
      ],
    ]);
    DB::table('users')->insert([
      [
        'username'      => 'administrator',
        'first_name'    => 'admin',
        'last_name'     => 'SEID',
        'status'        => 1,
        'roles_id'      => 1,
        'area'          => 'All',
        'kode_customer' => '10000000',
        'password'      => bcrypt('123456'),
      ],
    ]);
  }
}
