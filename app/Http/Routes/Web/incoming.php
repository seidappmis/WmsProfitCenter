<?php

Route::group(['middleware' => 'auth'], function () {

  // Finish Good Production
  Route::resource('finish-good-production', 'Web\FinishGoodController');

  // Incoming Import OEM
  Route::post('incoming-import-oem/{id}/submit-to-inventory', 'Web\IncomingImportOEMController@submitToInventory');
  Route::post('incoming-import-oem/{id}/detail', 'Web\IncomingImportOEMDetailController@store');
  Route::delete('incoming-import-oem/{incoming_manual_id}/detail/{detail_id}', 'Web\IncomingImportOEMDetailController@destroy');
  Route::resource('incoming-import-oem', 'Web\IncomingImportOEMController');

  // Conform Manifest
  Route::get('conform-manifest', 'Web\ConformManifestController@index');
  Route::get('conform-manifest/from-manifest-hq', 'Web\ConformManifestController@listManifestHQ');
  Route::get('conform-manifest/from-manifest-branch', 'Web\ConformManifestController@listManifestBranch');
  Route::get('conform-manifest/{id}', 'Web\ConformManifestController@viewForConform');

  // Billing Return
  Route::get('billing-return', 'Web\BillingReturnController@index');
  Route::get('billing-return/pending-billing-return-branch', 'Web\BillingReturnController@listPendingBillingBranch');
  Route::get('billing-return/return-billing-branch', 'Web\BillingReturnController@listReturnBillingBranch');
  Route::get('billing-return/{id}/view-for-submit', 'Web\BillingReturnController@showSubmit');
  // Route::view('billing-return', 'web.incoming.billing-return.index');

});
