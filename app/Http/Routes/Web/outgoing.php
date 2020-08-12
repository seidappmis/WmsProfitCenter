<?php

Route::group(['middleware' => 'auth'], function () {
  // Upload Concept
  Route::get('upload-concept', 'Web\UploadConceptController@index');
  Route::post('upload-concept', 'Web\UploadConceptController@store');
  Route::post('upload-concept/upload-csv', 'Web\UploadConceptController@uploadCsv');

  // IDCard Scan
  Route::get('idcard-scan/select2-vehicle-number', 'Web\IdCardScanController@getSelect2VehicleNumber');
  Route::resource('idcard-scan', 'Web\IdCardScanController');

  // Assign Vehicles
  Route::resource('assign-vehicles', 'Web\AssignVehicleController');

  // Select Gate
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

  Route::get('branch-manifest/truck-waiting-manifest', 'Web\BranchManifestController@truckWaitingManifest');
  Route::resource('branch-manifest', 'Web\BranchManifestController');

  // Manifest AS
  Route::get('manifest-as/lmb-waiting-manifest', 'Web\ManifestASController@lmbWaitingManifest');
  Route::get('manifest-as/{lmb_id}/create-manifest', 'Web\ManifestASController@createManifest');
  Route::get('manifest-as/{id}/export', 'Web\ManifestASController@export'); // Print
  Route::resource('manifest-as', 'Web\ManifestASController');

  Route::get('update-manifest', 'Web\UpdateManifestController@index');
  Route::post('update-manifest', 'Web\UpdateManifestController@show');

  // Route::view('overload-concept-or-do', 'web.outgoing.overload-concept-or-do.index');
  Route::get('overload-concept-or-do', 'Web\OverloadConceptOrDoController@index');
});
