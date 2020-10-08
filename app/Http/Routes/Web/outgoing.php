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
  Route::get('manifest-regular/select2-resend-driver', 'Web\ManifestRegularController@getSelect2ResendDriver');
  Route::delete('manifest-regular/delete-do', 'Web\ManifestRegularController@destroyDO');
  Route::delete('manifest-regular/{do_manifest_no}', 'Web\ManifestRegularController@destroy');
  Route::post('manifest-regular/new-manifest-lcl', 'Web\ManifestRegularController@newManifestLCL');
  Route::post('manifest-regular/resend', 'Web\ManifestRegularController@resend');
  Route::post('manifest-regular/{do_manifest_no}/upload-do', 'Web\ManifestRegularController@uploadDO');
  Route::get('manifest-regular/{do_manifest_no}/list-do', 'Web\ManifestRegularController@listDO');
  Route::get('manifest-regular/{lmb_id}/create-manifest', 'Web\ManifestRegularController@createManifest');
  Route::get('manifest-regular/{lmb_id}/export', 'Web\ManifestRegularController@export');
  Route::post('manifest-regular/{driver_register_id}/assign-do', 'Web\ManifestRegularController@assignDO');
  Route::resource('manifest-regular', 'Web\ManifestRegularController');

  Route::get('branch-manifest/truck-waiting-manifest', 'Web\BranchManifestController@truckWaitingManifest');
  Route::get('branch-manifest/{lmb_id}/create-manifest', 'Web\BranchManifestController@createManifest');
  Route::get('branch-manifest/{id}/export', 'Web\BranchManifestController@export');
  Route::post('branch-manifest/{lmb_id}/assign-do', 'Web\BranchManifestController@assignDO');
  Route::delete('branch-manifest/{id}/details/{detail_id}', 'Web\BranchManifestController@destroyDetail');
  Route::resource('branch-manifest', 'Web\BranchManifestController');

  // Manifest AS
  Route::get('manifest-as/lmb-waiting-manifest', 'Web\ManifestASController@lmbWaitingManifest');
  Route::get('manifest-as/{lmb_id}/create-manifest', 'Web\ManifestASController@createManifest');
  Route::get('manifest-as/{do_manifest_no}/list-do', 'Web\ManifestASController@listDO');
  Route::post('manifest-as/{do_manifest_no}/submit', 'Web\ManifestASController@submit');
  Route::get('manifest-as/{id}/export', 'Web\ManifestASController@export'); // Print
  Route::resource('manifest-as', 'Web\ManifestASController');

  Route::get('update-manifest', 'Web\UpdateManifestController@index');
  Route::post('update-manifest', 'Web\UpdateManifestController@show');
  Route::put('update-manifest', 'Web\UpdateManifestController@update');
  Route::get('update-manifest/list-do', 'Web\UpdateManifestController@listDo');
  Route::put('update-manifest/update-do', 'Web\UpdateManifestController@updateDO');

  // Route::view('overload-concept-or-do', 'web.outgoing.overload-concept-or-do.index');
  Route::get('overload-concept-or-do', 'Web\OverloadConceptOrDoController@index');
});
