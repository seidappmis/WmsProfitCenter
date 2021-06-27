<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth', 'authorize.module.access']], function () {
  // Route::view('storage-inventory-monitoring', 'web.inventory.storage-inventory-monitoring.index');
  Route::get('storage-inventory-monitoring', 'Web\StorageInventoryMonitoringController@index');
  Route::get('storage-inventory-monitoring/{id}', 'Web\StorageInventoryMonitoringController@show');

  Route::get('upload-inventory-storage', 'Web\UploadInventoryStorageController@index');
  Route::post('upload-inventory-storage', 'Web\UploadInventoryStorageController@upload');

  // Route::view('adjust-inventory-movement', 'web.inventory.adjust-inventory-movement.index');
  Route::get('adjust-inventory-movement', 'Web\AdjustInventoryMovementController@index');
  Route::post('adjust-inventory-movement', 'Web\AdjustInventoryMovementController@store');


  Route::get('transfer-sloc', 'Web\TransferSlocController@index');
  Route::post('transfer-sloc', 'Web\TransferSlocController@store');
  Route::get('transfer-sloc/select2-storage-location', 'Web\TransferSlocController@getSelect2StorageLocation');

  // Route::view('cancel-movement', 'web.inventory.cancel-movement.index');
  Route::get('cancel-movement', 'Web\CancelMovementController@index');

});

Route::get('stock-check', 'Web\StorageInventoryMonitoringController@check');
Route::get('stock-check/{id}', 'Web\StorageInventoryMonitoringController@check_show');
Route::get('log-check', 'Web\MovementTypeController@index');