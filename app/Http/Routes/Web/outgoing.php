<?php

Route::group(['middleware' => 'auth'], function () {
  // Route::view('upload-concept', 'web.outgoing.upload-concept.index');
  Route::get('upload-concept', 'Web\UploadConceptController@index');
  Route::post('upload-concept', 'Web\UploadConceptController@store');
  Route::post('upload-concept/upload-csv', 'Web\UploadConceptController@uploadCsv');

  // Route::view('idcard-scan', 'web.outgoing.idcard-scan.index');
  Route::resource('idcard-scan', 'Web\IdCardScanController');

  // Route::view('assign-vehicles', 'web.outgoing.assign-vehicles.index');
  Route::resource('assign-vehicles', 'Web\AssignVehicleController');

  // Route::view('select-gate', 'web.outgoing.select-gate.index');
  Route::get('select-gate', 'Web\SelectGateController@index');

  // Route::view('loading-process', 'web.outgoing.loading-process.index');
  Route::get('loading-process', 'Web\LoadingProcessController@index');

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

  // Route::view('overload-concept-or-do', 'web.outgoing.overload-concept-or-do.index');
  Route::get('overload-concept-or-do', 'Web\OverloadConceptOrDoController@index');
});
