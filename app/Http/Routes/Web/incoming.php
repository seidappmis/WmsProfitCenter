<?php

Route::group(['middleware' => 'auth'], function () {

  // Finish Good Production
  Route::resource('finish-good-production', 'Web\FinishGoodController');

  // Incoming Import OEM
  Route::post('incoming-import-oem/{id}/submit-to-inventory', 'Web\IncomingImportOEMController@submitToInventory');
  Route::post('incoming-import-oem/{id}/detail', 'Web\IncomingImportOEMDetailController@store');
  Route::delete('incoming-import-oem/{incoming_manual_id}/detail/{detail_id}', 'Web\IncomingImportOEMDetailController@destroy');
  Route::resource('incoming-import-oem', 'Web\IncomingImportOEMController');

  Route::view('conform-manifest', 'web.incoming.conform-manifest.index');
  Route::view('conform-manifest/{id}', 'web.incoming.conform-manifest.view');

  Route::view('billing-return', 'web.incoming.billing-return.index');
  Route::view('billing-return/{id}', 'web.incoming.billing-return.view');

});
