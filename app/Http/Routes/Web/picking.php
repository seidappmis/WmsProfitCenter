<?php

Route::group(['middleware' => 'auth'], function () {
  // Route::view('upload-do-for-picking', 'web.picking.upload-do-for-picking.index');
  Route::get('upload-do-for-picking', 'Web\UploadDOForPickingController@index');
  Route::post('upload-do-for-picking', 'Web\UploadDOForPickingController@upload');
  Route::delete('upload-do-for-picking', 'Web\UploadDOForPickingController@destroy');
  Route::delete('upload-do-for-picking/multi-delete-selected-item', 'Web\UploadDOForPickingController@destroySelectedItem');

  // Route::view('picking-list', 'web.picking.picking-list.index');
  // Route::view('picking-list/create', 'web.picking.picking-list.create');
  Route::get('picking-list/do-or-shipment-data', 'Web\PickingListController@doOrShipmentData');
  Route::post('picking-list/submit-do', 'Web\PickingListController@submitDO');
  Route::resource('picking-list', 'Web\PickingListController');

  // Route::view('picking-to-lmb', 'web.picking.picking-to-lmb.index');
  Route::post('picking-to-lmb/upload', 'Web\PickingToLMBController@upload');
  Route::post('picking-to-lmb/store-scan', 'Web\PickingToLMBController@storeScan');
  Route::get('picking-to-lmb/picking-list', 'Web\PickingToLMBController@pickingListIndex');
  Route::get('picking-to-lmb/picking-list/{id}', 'Web\PickingToLMBController@pickingListCreate');
  Route::post('picking-to-lmb/{id}/send-manifest', 'Web\PickingToLMBController@sendManifest');
  Route::resource('picking-to-lmb', 'Web\PickingToLMBController');
});
