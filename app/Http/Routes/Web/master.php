<?php

Route::group(['middleware' => 'auth'], function () {
  Route::view('master-gate', 'web.master.master-gate.index');
  Route::view('master-gate/create', 'web.master.master-gate.create');

  Route::view('master-destination', 'web.master.master-destination.index');
  Route::view('master-destination/create', 'web.master.master-destination.create');

  Route::view('master-vehicle', 'web.master.master-vehicle.index');
  Route::view('master-vehicle/create', 'web.master.master-vehicle.create');

  Route::view('master-expedition', 'web.master.master-expedition.index');
  Route::view('master-expedition/create', 'web.master.master-expedition.create');

  Route::view('master-vehicle-expedition', 'web.master.master-vehicle-expedition.index');
  Route::view('master-vehicle-expedition/create', 'web.master.master-vehicle-expedition.create');

  Route::view('master-driver', 'web.master.master-driver.index');
  Route::view('master-driver/create', 'web.master.master-driver.create');

  Route::view('destination-city', 'web.master.destination-city.index');
  Route::view('destination-city/create', 'web.master.destination-city.create');

  Route::view('master-freight-cost', 'web.master.master-freight-cost.index');

  Route::view('storage-master', 'web.master.storage-master.index');
  Route::view('storage-master/create', 'web.master.storage-master.create');

  Route::view('master-model', 'web.master.master-model.index');

  Route::view('master-vendor', 'web.master.master-vendor.index');
  Route::view('master-model-exception', 'web.master.master-model-exception.index');

  Route::view('master-branch-expedition', 'web.master.master-branch-expedition.index');
  Route::view('branch-expedition-vehicle', 'web.master.branch-expedition-vehicle.index');

  Route::view('branch-master-driver', 'web.master.branch-master-driver.index');
  Route::view('branch-master-driver/create', 'web.master.branch-master-driver.create');

  Route::view('destination-city-of-branch', 'web.master.destination-city-of-branch.index');
});