<?php

Route::group(['middleware' => 'auth'], function () {
    // Master Gate
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
    Route::resource('master-expedition', 'Web\MasterExpeditionController');

    // Master Vehicle Expedition
    Route::get('master-vehicle-expedition/select2-vehicle-number', 'Web\MasterVehicleExpeditionController@getSelect2VehicleNumber');
    Route::resource('master-vehicle-expedition', 'Web\MasterVehicleExpeditionController');

    // Master Driver
    Route::get('master-driver/select2-driver-name', 'Web\MasterDriverController@getSelect2DriverName');
    Route::resource('master-driver', 'Web\MasterDriverController');

    // Destination City
    Route::get('destination-city/select2-destination-city', 'Web\DestinationCityController@getSelect2DestinationCity');
    Route::resource('destination-city', 'Web\DestinationCityController');

    // Master Freight Cost
    Route::post('master-freight-cost/upload', 'Web\MasterFreightCostController@proses_upload');
    Route::resource('master-freight-cost', 'Web\MasterFreightCostController');

    // Storage Master
    Route::get('storage-master/select2-sto-type', 'Web\StorageMasterController@getSelect2StorageType');
    Route::get('storage-master/select2-storage', 'Web\StorageMasterController@getSelect2Storage');
    Route::resource('storage-master', 'Web\StorageMasterController');

    // Master Model
    Route::get('master-model/select2-material-group', 'Web\MasterModelController@getSelect2MaterialGroup');
    Route::get('master-model/select2-category', 'Web\MasterModelController@getSelect2Category');
    Route::get('master-model/select2-model-type', 'Web\MasterModelController@getSelect2ModelType');
    Route::get('master-model/select2-model', 'Web\MasterModelController@getSelect2Model');
    Route::post('master-model/upload', 'Web\MasterModelController@proses_upload');
    Route::resource('master-model', 'Web\MasterModelController');

    // Master Vendor
    Route::get('master-vendor/select2-vendor-name', 'Web\VendorController@getSelect2VendorName');
    Route::resource('master-vendor', 'Web\VendorController');

    // Master Model Exception
    Route::resource('master-model-exception', 'Web\ModelExceptionController');

    // Master Branch Expedition
    Route::get('master-branch-expedition/select2-active-expedition', 'Web\BranchExpeditionController@getSelect2ActiveExpedition');
    Route::get('master-branch-expedition/select2-all-expedition', 'Web\BranchExpeditionController@getSelect2AllExpedition');
    Route::resource('master-branch-expedition', 'Web\BranchExpeditionController');

    // Branch Expedition Vehicle
    Route::resource('branch-expedition-vehicle', 'Web\BranchExpeditionVehicleController');

    // Branch Master Driver
    Route::resource('branch-master-driver', 'Web\BranchMasterDriverController');

    // Destination City of Branch
    Route::resource('destination-city-of-branch', 'Web\DestinationCityOfBranchController');
});
