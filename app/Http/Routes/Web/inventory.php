<?php

Route::group(['middleware' => 'auth'], function () {
  Route::view('upload-inventory-storage', 'web.inventory.upload-inventory-storage.index');
});