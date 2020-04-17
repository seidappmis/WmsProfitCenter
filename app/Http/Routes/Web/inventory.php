<?php

Route::group(['middleware' => 'auth'], function () {
  Route::view('storage-inventory-monitoring', 'web.inventory.storage-inventory-monitoring.index');
  Route::view('upload-inventory-storage', 'web.inventory.upload-inventory-storage.index');
});