<?php

Route::group(['middleware' => 'auth'], function () {
  // Route::view('storage-inventory-monitoring', 'web.inventory.storage-inventory-monitoring.index');
  Route::get('storage-inventory-monitoring', 'Web\StorageInventoryMonitoringController@index');
  Route::get('storage-inventory-monitoring/{id}', 'Web\StorageInventoryMonitoringController@show');

  Route::get('upload-inventory-storage', 'Web\UploadInventoryStorageController@index');
  Route::post('upload-inventory-storage', 'Web\UploadInventoryStorageController@upload');

  // Route::view('adjust-inventory-movement', 'web.inventory.adjust-inventory-movement.index');
  Route::get('adjust-inventory-movement', 'Web\AdjustInventoryMovementController@index');
  Route::post('adjust-inventory-movement', 'Web\AdjustInventoryMovementController@store');


  Route::view('transfer-sloc', 'web.inventory.transfer-sloc.index');

  // Route::view('cancel-movement', 'web.inventory.cancel-movement.index');
  Route::get('cancel-movement', 'Web\CancelMovementController@index');
});