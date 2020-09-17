<?php

Route::group(['middleware' => 'auth'], function () {
  // Route::view('upload-do-for-picking', 'web.picking.upload-do-for-picking.index');
  Route::get('upload-do-for-picking', 'Web\UploadDOForPickingController@index');
  Route::post('upload-do-for-picking', 'Web\UploadDOForPickingController@upload');
  Route::delete('upload-do-for-picking', 'Web\UploadDOForPickingController@destroy');
  Route::delete('upload-do-for-picking/multi-delete-selected-item', 'Web\UploadDOForPickingController@destroySelectedItem');

  // Route::view('picking-list', 'web.picking.picking-list.index');
  // Route::view('picking-list/create', 'web.picking.picking-list.create');
  Route::post('picking-list/split-concept', 'Web\PickingListController@splitConcept');
  Route::get('picking-list/select2-driver-by-register-id', 'Web\PickingListController@getSelect2DriverByRegisterID');
  Route::get('picking-list/select2-vehicle-number', 'Web\PickingListController@getSelect2VehicleNumber');
  Route::get('picking-list/get-transporter-list', 'Web\PickingListController@transporterList');
  Route::get('picking-list/non-assign-pickinglist', 'Web\PickingListController@getNonAssignedPicking');
  Route::get('picking-list/transporter/{id}', 'Web\PickingListController@assignPicking');
  Route::post('picking-list/transporter/{id}', 'Web\PickingListController@storeAssignPicking');
  Route::get('picking-list/transporter/{id}/edit', 'Web\PickingListController@editTransporter');
  Route::get('picking-list/do-or-shipment-data', 'Web\PickingListController@doOrShipmentData');
  Route::post('picking-list/submit-do', 'Web\PickingListController@submitDO');
  Route::delete('picking-list/detail/{id}', 'Web\PickingListController@destroyDetail');
  
  Route::get('picking-list/{id}/export', 'Web\PickingListController@export');
  Route::resource('picking-list', 'Web\PickingListController');

  // Route::view('picking-to-lmb', 'web.picking.picking-to-lmb.index');
  Route::post('picking-to-lmb/upload', 'Web\PickingToLMBController@upload');
  Route::post('picking-to-lmb/store-scan', 'Web\PickingToLMBController@storeScan');
  Route::get('picking-to-lmb/picking-list', 'Web\PickingToLMBController@pickingListIndex');
  Route::delete('picking-to-lmb/picking-list', 'Web\PickingToLMBController@destroyLmbDetail');
  Route::delete('picking-to-lmb/picking-list/multi-delete-selected-item', 'Web\PickingToLMBController@destroySelectedLmbDetail');
  Route::get('picking-to-lmb/picking-list/{id}', 'Web\PickingToLMBController@pickingListCreate');
  Route::put('picking-to-lmb/{id}/update-vehicle-number', 'Web\PickingToLMBController@updateVehicleNumber');
  Route::post('picking-to-lmb/{id}/send-manifest', 'Web\PickingToLMBController@sendManifest');
  Route::get('picking-to-lmb/{id}/export', 'Web\PickingToLMBController@export');
  Route::resource('picking-to-lmb', 'Web\PickingToLMBController');
});
