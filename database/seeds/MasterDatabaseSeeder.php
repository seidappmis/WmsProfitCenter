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
    $this->call(Database\Seeds\Masters\TRGateTableSeeder::class);
    $this->call(Database\Seeds\Masters\TRVehicleTypeGroupTableSeeder::class);
    $this->call(Database\Seeds\Masters\TRVehicleTypeDetailTableSeeder::class);
    $this->call(Database\Seeds\Masters\TRExpeditionTableSeeder::class);
    $this->call(Database\Seeds\Masters\TRVehicleExpeditionTableSeeder::class);
    $this->call(Database\Seeds\Masters\TRDriverTableSeeder::class);
    $this->call(Database\Seeds\Masters\TRWorkflowTableSeeder::class);
    $this->call(Database\Seeds\Masters\TRDestinationTableSeeder::class);
    $this->call(Database\Seeds\Masters\WMSStorageTypesTableSeeder::class);
    $this->call(Database\Seeds\Masters\WMSModelCategorySeeder::class);
    $this->call(Database\Seeds\Masters\WMSModelMaterialGroupSeeder::class);
    $this->call(Database\Seeds\Masters\WMSModelTypeSeeder::class);
    $this->call(Database\Seeds\Masters\LOGRegionTableSeeder::class);
    $this->call(Database\Seeds\Masters\LogCabangTableSeeder::class);
    $this->call(Database\Seeds\Masters\LOGDestinationCityTableSeeder::class);
    $this->call(Database\Seeds\Masters\LOGFreightCostTableSeeder::class);
    $this->call(Database\Seeds\Masters\MasterVendorTableSeeder::class);
    $this->call(Database\Seeds\Masters\WMSBranchExpeditionTableSeeder::class);
    $this->call(Database\Seeds\Masters\WMSBranchVehicleExpeditionTableSeeder::class);
    $this->call(Database\Seeds\Masters\WMSBranchDriverTableSeeder::class);
    $this->call(Database\Seeds\Masters\WMSDestinationCityBranchTableSeeder::class);
    $this->call(Database\Seeds\Masters\WMSMasterMovementTypeSeeder::class);
    $this->call(Database\Seeds\Masters\WMSMasterModelSeeder::class);
    $this->call(Database\Seeds\Masters\WMSMasterStorageTableSeeder::class);
  }
}
