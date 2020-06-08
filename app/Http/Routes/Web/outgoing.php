<?php

Route::group(['middleware' => 'auth'], function () {
  // Upload Concept
  Route::get('upload-concept', 'Web\UploadConceptController@index');
  Route::post('upload-concept', 'Web\UploadConceptController@store');
  Route::post('upload-concept/upload-csv', 'Web\UploadConceptController@uploadCsv');

  // IDCard Scan
  Route::resource('idcard-scan', 'Web\IdCardScanController');

  // Assign Vehicles
  Route::resource('assign-vehicles', 'Web\AssignVehicleController');

  // Select Gate
  Route::get('select-gate', 'Web\SelectGateController@index');

  Route::view('loading-process', 'web.outgoing.loading-process.index');

  // Route::view('complete', 'web.outgoing.complete.index');
  Route::post('complete/{id}/complete', 'Web\CompleteController@complete');
  Route::resource('complete', 'Web\CompleteController');

  // Route::view('manifest-regular', 'web.outgoing.manifest-regular.index');
  Route::get('manifest-regular/truck-waiting-manifest', 'Web\ManifestRegularController@truckWaitingManifest');
  Route::get('manifest-regular/{lmb_id}/create-manifest', 'Web\ManifestRegularController@createManifest');
  Route::post('manifest-regular/{driver_register_id}/assign-do', 'Web\ManifestRegularController@assignDO');
  Route::resource('manifest-regular', 'Web\ManifestRegularController');


  Route::view('manifest-as', 'web.outgoing.manifest-as.index');
  Route::view('update-manifest', 'web.outgoing.update-manifest.index');
  Route::view('overload-concept-or-do', 'web.outgoing.overload-concept-or-do.index');
});
