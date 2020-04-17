<?php

Route::group(['middleware' => 'auth'], function () {
  Route::view('storage-inventory-monitoring', 'web.inventory.storage-inventory-monitoring.index');
  Route::view('upload-inventory-storage', 'web.inventory.upload-inventory-storage.index');
  Route::view('adjust-inventory-movement', 'web.inventory.adjust-inventory-movement.index');
  Route::view('transfer-sloc', 'web.inventory.transfer-sloc.index');
  Route::view('cancel-movement', 'web.inventory.cancel-movement.index');
});