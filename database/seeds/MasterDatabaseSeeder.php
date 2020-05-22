<?php

use Illuminate\Database\Seeder;

class MasterDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(Database\Seeds\Masters\TRAreaTableSeeder::class);
        $this->call(Database\Seeds\Masters\WMSStorageTypesTableSeeder::class);
        $this->call(Database\Seeds\Masters\WMSModelCategorySeeder::class);
        $this->call(Database\Seeds\Masters\WMSModelMaterialGroupSeeder::class);
        $this->call(Database\Seeds\Masters\WMSModelTypeSeeder::class);
        $this->call(Database\Seeds\Masters\LOGRegionTableSeeder::class);
        $this->call(Database\Seeds\Masters\LogCabangTableSeeder::class);
    }
}
