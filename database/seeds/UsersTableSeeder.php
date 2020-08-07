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
    $this->seedModuls();
    $this->seedUserRoles();
    $this->seedUserRolesDetail();
    $this->seedUsers();
    $this->call(Database\Seeds\Masters\WMSUsersGrantCabang::class);
    // DB::table('tr_user_roles')->insert([
    //   [
    //     'roles_id'   => 1,
    //     'roles_name' => 'IT Admin',
    //   ],
    // ]);
    // DB::table('users')->insert([
    //   [
    //     'username'      => 'administrator',
    //     'first_name'    => 'admin',
    //     'last_name'     => 'SEID',
    //     'status'        => 1,
    //     'roles_id'      => 1,
    //     'area'          => 'All',
    //     'kode_customer' => '10000000',
    //     'password'      => bcrypt('123456'),
    //   ],
    // ]);
  }

  protected function seedUsers()
  {
    $file = fopen('database/seeds/source_files/tr_users.csv', "r");

    $tr_users = [];

    $password = bcrypt('123456');

    while (!feof($file)) {
      $row = fgetcsv($file);

      if (!empty($row[0])) {
        $user['username']      = $row[0];
        $user['first_name']    = $row[1];
        $user['last_name']     = $row[2];
        $user['password']      = $password;
        $user['roles_id']      = $row[4];
        $user['status']        = $row[5];
        $user['area']          = $row[6];
        $user['kode_customer'] = $row[9];

        $tr_users[] = $user;
      }
    }

    fclose($file);

    DB::table('users')->insert($tr_users);
  }

  protected function seedUserRoles()
  {
    $file = fopen('database/seeds/source_files/tr_userroles.csv', "r");

    $tr_user_roles = [];

    while (!feof($file)) {
      $row = fgetcsv($file);

      if (!empty($row[0])) {
        $user_role['roles_id']   = $row[0];
        $user_role['roles_name'] = $row[1];

        $tr_user_roles[] = $user_role;
      }
    }

    fclose($file);

    DB::table('tr_user_roles')->insert($tr_user_roles);
  }

  protected function seedUserRolesDetail()
  {
    $file = fopen('database/seeds/source_files/tr_userroles_detail.csv', "r");

    $tr_user_roles_detail = [];

    while (!feof($file)) {
      $row = fgetcsv($file);

      if (!empty($row[0])) {

        $user_role['id']       = $row[0];
        $user_role['roles_id'] = $row[1];
        $user_role['modul_id'] = $row[2];
        $user_role['view']     = $row[3];
        $user_role['edit']     = $row[4];
        $user_role['delete']   = $row[5];

        $tr_user_roles_detail[] = $user_role;
      }
    }

    fclose($file);

    DB::table('tr_user_roles_detail')->insert($tr_user_roles_detail);
  }

  protected function seedModuls()
  {
    $file = fopen('database/seeds/source_files/tr_modules.csv', "r");

    $tr_modules = [];

    while (!feof($file)) {
      $row = fgetcsv($file);

      if (!empty($row[0])) {

        $modul['id']         = $row[0];
        $modul['modul_name'] = $row[1];
        $modul['modul_link'] = strtolower($row[2]);
        $modul['group_name'] = $row[3];
        $modul['order_menu'] = $row[4];

        $tr_modules[] = $modul;
      }
    }

    fclose($file);

    DB::table('tr_modules')->insert($tr_modules);
  }
}
