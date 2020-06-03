<?php

Route::group(['middleware' => 'auth'], function () {
  // Route::view('upload-do-for-picking', 'web.picking.upload-do-for-picking.index');
  Route::get('upload-do-for-picking', 'Web\UploadDOForPickingController@index');
  Route::post('upload-do-for-picking', 'Web\UploadDOForPickingController@upload');
  Route::delete('upload-do-for-picking', 'Web\UploadDOForPickingController@destroy');
  Route::delete('upload-do-for-picking/multi-delete-selected-item', 'Web\UploadDOForPickingController@destroySelectedItem');

  Route::view('picking-list', 'web.picking.picking-list.index');
  Route::view('picking-list/create', 'web.picking.picking-list.create');

  Route::view('picking-to-lmb', 'web.picking.picking-to-lmb.index');
});
