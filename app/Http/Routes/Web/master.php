<?php
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\OnlyBranchAccess;

Route::get('storage-master-select2-user-storage-without-intransit', 'Web\StorageMasterController@getSelect2UserStorageWithoutIntransit');
Route::get('storage-master/select2-sto-type', 'Web\StorageMasterController@getSelect2StorageType');
Route::get('master-freight-cost/select2-vehicle', 'Web\MasterFreightCostController@getSelect2Vehicle');
Route::get('master-vendor/select2-vendor-name', 'Web\VendorController@getSelect2VendorName');
  
Route::group(['middleware' => ['auth', 'authorize.module.access']], function () {
  // Master Gate
  Route::get('master-gate/select2-free-gate', 'Web\GateController@getSelect2FreeGate');
  Route::resource('master-gate', 'Web\GateController');

  // Select2 Region
  Route::get('region/select2-region', 'Web\RegionController@getSelect2Region');

  // Master Destination
  Route::get('master-destination/select2-destination', 'Web\MasterDestinationController@getSelect2Destination');
  Route::resource('master-destination', 'Web\MasterDestinationController');

  // Master Vehicle
  Route::get('master-vehicle/select2-vehicle', 'Web\VehicleDetailController@getSelect2Vehicle');
  Route::resource('master-vehicle/{vehicle_group_id}/detail', 'Web\VehicleDetailController');
  Route::resource('master-vehicle', 'Web\VehicleController');

  // Master Expedition
  Route::get('master-expedition/select2-active-expedition', 'Web\MasterExpeditionController@getSelect2ActiveExpedition');
  Route::get('master-expedition/select2-all-expedition', 'Web\MasterExpeditionController@getSelect2AllExpedition');
  Route::get('master-expedition/select2-expedition-destination-city', 'Web\MasterExpeditionController@getSelect2ExpeditionDestinationCity');
  Route::resource('master-expedition', 'Web\MasterExpeditionController');

  // Master Vehicle Expedition
  Route::get('master-vehicle-expedition/select2-vehicle', 'Web\MasterVehicleExpeditionController@getSelect2Vehicle');
  Route::get('master-vehicle-expedition/select2-vehicle-number', 'Web\MasterVehicleExpeditionController@getSelect2VehicleNumber');
  Route::resource('master-vehicle-expedition', 'Web\MasterVehicleExpeditionController');

  // Master Driver
  Route::get('master-driver/select2-driver-expedition', 'Web\MasterDriverController@getSelect2DriverExpedition');
  Route::get('master-driver/select2-branch-driver-expedition', 'Web\MasterDriverController@getSelect2BranchDriverExpedition');
  Route::get('master-driver/select2-driver-name', 'Web\MasterDriverController@getSelect2DriverName');
  Route::resource('master-driver', 'Web\MasterDriverController');

  // Destination City
  Route::get('destination-city/select2-destination-city', 'Web\DestinationCityController@getSelect2DestinationCity');
  Route::get('destination-city/select2-destination-city-with-city-code', 'Web\DestinationCityController@getSelect2DestinationCityWithCityCode');
  Route::resource('destination-city', 'Web\DestinationCityController');

  // Master Freight Cost
  Route::post('master-freight-cost/upload', 'Web\MasterFreightCostController@proses_upload');
  Route::resource('master-freight-cost', 'Web\MasterFreightCostController');

  // Storage Master
  Route::get('storage-master/select2-storage', 'Web\StorageMasterController@getSelect2Storage');
  Route::get('storage-master/select2-storage-cabang', 'Web\StorageMasterController@getSelect2StorageCabang');
  Route::get('storage-master/select2-storage-cabang-id-sto-code', 'Web\StorageMasterController@getSelect2StorageCabangIdStoCode');
  Route::resource('storage-master', 'Web\StorageMasterController');

  // Master Model
  Route::get('master-model/select2-material-group', 'Web\MasterModelController@getSelect2MaterialGroup');
  Route::get('master-model/select2-category', 'Web\MasterModelController@getSelect2Category');
  Route::get('master-model/select2-model-type', 'Web\MasterModelController@getSelect2ModelType');
  Route::get('master-model/select2-model', 'Web\MasterModelController@getSelect2Model');
  Route::get('master-model/select2-model2', 'Web\MasterModelController@getSelect2Model2');
  Route::get('master-model/select2-model-sloc', 'Web\MasterModelController@getSelect2ModelSloc');
  Route::post('master-model/upload', 'Web\MasterModelController@proses_upload');
  Route::resource('master-model', 'Web\MasterModelController');

  // Master Vendor
  Route::resource('master-vendor', 'Web\VendorController');

  // Master Model Exception
  Route::resource('master-model-exception', 'Web\ModelExceptionController');
  Route::get('movement-type/select2', 'Web\MovementTypeController@getSelect2');

  Route::middleware([OnlyBranchAccess::class])->group(function () {
    // Master Branch Expedition
    Route::get('master-branch-expedition/select2-active-expedition', 'Web\BranchExpeditionController@getSelect2ActiveExpedition');
    Route::get('master-branch-expedition/select2-all-expedition', 'Web\BranchExpeditionController@getSelect2AllExpedition');
    Route::resource('master-branch-expedition', 'Web\BranchExpeditionController');

    // Branch Expedition Vehicle
    Route::get('branch-expedition-vehicle/select2-vehicle-number', 'Web\BranchExpeditionVehicleController@getSelect2VehicleNumber');
    Route::get('branch-expedition-vehicle/select2-vehicle-number-without-vehicle-type', 'Web\BranchExpeditionVehicleController@getSelect2VehicleNumberWithoutVehicleType');
    Route::get('branch-expedition-vehicle/select2-vehicle', 'Web\BranchExpeditionVehicleController@getSelect2Vehicle');
    Route::resource('branch-expedition-vehicle', 'Web\BranchExpeditionVehicleController');

    // Branch Master Driver
    Route::get('branch-master-driver/select2', 'Web\BranchMasterDriverController@select2');
    Route::resource('branch-master-driver', 'Web\BranchMasterDriverController');

    // Destination City of Branch
    Route::get('destination-city-of-branch/select2', 'Web\DestinationCityOfBranchController@getSelect2');
    Route::resource('destination-city-of-branch', 'Web\DestinationCityOfBranchController');
  });
});
