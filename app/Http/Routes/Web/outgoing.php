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

  Route::view('select-gate', 'web.outgoing.select-gate.index');
  Route::view('loading-process', 'web.outgoing.loading-process.index');

  Route::view('complete', 'web.outgoing.complete.index');
  Route::view('complete/{id}', 'web.outgoing.complete.view');

  Route::view('manifest-regular', 'web.outgoing.manifest-regular.index');
  Route::view('manifest-as', 'web.outgoing.manifest-as.index');
  Route::view('update-manifest', 'web.outgoing.update-manifest.index');
  Route::view('overload-concept-or-do', 'web.outgoing.overload-concept-or-do.index');
});
