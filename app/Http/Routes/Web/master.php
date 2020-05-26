<?php

Route::group(['middleware' => 'auth'], function () {
    // Route::view('master-gate', 'web.master.master-gate.index');
    // Route::view('master-gate/create', 'web.master.master-gate.create');
    // Route::view('master-gate/{id}', 'web.master.master-gate.edit');
    Route::resource('master-gate', 'Web\GateController');

    // Route::view('master-destination', 'web.master.master-destination.index');
    // Route::view('master-destination/create', 'web.master.master-destination.create');
    // Route::view('master-destination/{id}', 'web.master.master-destination.edit');
    Route::get('master-destination/select2-cabang', 'Web\MasterDestinationController@getSelect2Cabang');
    Route::get('master-destination/select2-current-region', 'Web\MasterRegionController@getSelect2CurrentRegion');
    Route::resource('master-destination', 'Web\MasterDestinationController');

    // Route::view('master-vehicle', 'web.master.master-vehicle.index');
    // Route::view('master-vehicle/create', 'web.master.master-vehicle.create');
    // Route::view('master-vehicle/{id}', 'web.master.master-vehicle.view');
    Route::get('master-vehicle/select2-vehicle', 'Web\VehicleDetailController@getSelect2Vehicle');
    Route::resource('master-vehicle/{vehicle_group_id}/detail', 'Web\VehicleDetailController');
    Route::resource('master-vehicle', 'Web\VehicleController');

    Route::get('master-expedition/select2-active-expedition', 'Web\MasterExpeditionController@getSelect2ActiveExpedition');
    Route::get('master-expedition/select2-all-expedition', 'Web\MasterExpeditionController@getSelect2AllExpedition');
    Route::resource('master-expedition', 'Web\MasterExpeditionController');
    // Route::view('master-expedition', 'web.master.master-expedition.index');
    // Route::view('master-expedition/create', 'web.master.master-expedition.create');
    // Route::view('master-expedition/{id}', 'web.master.master-expedition.edit');

    Route::view('master-vehicle-expedition', 'web.master.master-vehicle-expedition.index');
    Route::view('master-vehicle-expedition/create', 'web.master.master-vehicle-expedition.create');
    Route::view('master-vehicle-expedition/{id}', 'web.master.master-vehicle-expedition.edit');


    Route::resource('master-driver', 'Web\MasterDriverController');
    // Route::view('master-driver', 'web.master.master-driver.index');
    // Route::view('master-driver/create', 'web.master.master-driver.create');
    // Route::view('master-driver/{id}', 'web.master.master-driver.edit');

    // Route::view('destination-city', 'web.master.destination-city.index');
    // Route::view('destination-city/create', 'web.master.destination-city.create');
    // Route::view('destination-city/1', 'web.master.destination-city.edit');
    Route::get('destination-city/select2-destination-city', 'Web\DestinationCityController@getSelect2DestinationCity');
    Route::resource('destination-city', 'Web\DestinationCityController');

    // Route::view('master-freight-cost', 'web.master.master-freight-cost.index');
    // Route::view('master-freight-cost/create', 'web.master.master-freight-cost.create');
    // Route::view('master-freight-cost/1', 'web.master.master-freight-cost.edit');
    Route::resource('master-freight-cost/upload', 'Web\MasterFreightCostController@proses_upload');
    Route::resource('master-freight-cost', 'Web\MasterFreightCostController');

    // Route::view('storage-master', 'web.master.storage-master.index');
    // Route::view('storage-master/create', 'web.master.storage-master.create');
    // Route::view('storage-master/1', 'web.master.storage-master.edit');
    Route::get('storage-master/select2-sto-type', 'Web\StorageMasterController@getSelect2StorageType');
    Route::get('storage-master/select2-storage', 'Web\StorageMasterController@getSelect2Storage');
    Route::resource('storage-master', 'Web\StorageMasterController');

    // Route::view('master-model', 'web.master.master-model.index');
    // Route::view('master-model/create', 'web.master.master-model.create');
    // Route::view('master-model/1', 'web.master.master-model.edit');
    Route::get('master-model/select2-material-group', 'Web\MasterModelController@getSelect2MaterialGroup');
    Route::get('master-model/select2-category', 'Web\MasterModelController@getSelect2Category');
    Route::get('master-model/select2-model-type', 'Web\MasterModelController@getSelect2ModelType');
    Route::get('master-model/select2-model', 'Web\MasterModelController@getSelect2Model');
    Route::post('master-model/upload', 'Web\MasterModelController@proses_upload');
    Route::resource('master-model', 'Web\MasterModelController');

    //Route::view('master-vendor', 'web.master.master-vendor.index');
    //Route::view('master-vendor/create', 'web.master.master-vendor.create');
    //Route::view('master-vendor/1', 'web.master.master-vendor.edit');
    Route::get('master-vendor/select2-vendor-name', 'Web\VendorController@getSelect2VendorName');
    Route::resource('master-vendor', 'Web\VendorController');

    // Route::view('master-model-exception', 'web.master.master-model-exception.index');
    Route::resource('master-model-exception', 'Web\ModelExceptionController');

    // Route::view('master-branch-expedition', 'web.master.master-branch-expedition.index');
    // Route::view('master-branch-expedition/create', 'web.master.master-branch-expedition.create');
    // Route::view('master-branch-expedition/1', 'web.master.master-branch-expedition.edit');
    Route::get('master-branch-expedition/select2-active-expedition', 'Web\BranchExpeditionController@getSelect2ActiveExpedition');
    Route::get('master-branch-expedition/select2-all-expedition', 'Web\BranchExpeditionController@getSelect2AllExpedition');
    Route::resource('master-branch-expedition', 'Web\BranchExpeditionController');

    // Route::view('branch-expedition-vehicle', 'web.master.branch-expedition-vehicle.index');
    // Route::view('branch-expedition-vehicle/create', 'web.master.branch-expedition-vehicle.create');
    // Route::view('branch-expedition-vehicle/1', 'web.master.branch-expedition-vehicle.edit');

    Route::resource('branch-expedition-vehicle', 'Web\BranchExpeditionVehicleController');

    // Route::view('branch-master-driver', 'web.master.branch-master-driver.index');
    // Route::view('branch-master-driver/create', 'web.master.branch-master-driver.create');
    // Route::view('branch-master-driver/1', 'web.master.branch-master-driver.edit');
    Route::resource('branch-master-driver', 'Web\BranchMasterDriverController');

    // Route::view('destination-city-of-branch', 'web.master.destination-city-of-branch.index');
    // Route::view('destination-city-of-branch/create', 'web.master.destination-city-of-branch.create');
    // Route::view('destination-city-of-branch/1', 'web.master.destination-city-of-branch.edit');
    Route::resource('destination-city-of-branch', 'Web\DestinationCityOfBranchController');
});
