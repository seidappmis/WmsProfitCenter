<?php

Route::group(['middleware' => 'auth'], function () {
  Route::view('upload-concept', 'web.outgoing.upload-concept.index');
  Route::view('idcard-scan', 'web.outgoing.idcard-scan.index');
  Route::view('assign-vehicles', 'web.outgoing.assign-vehicles.index');
  Route::view('select-gate', 'web.outgoing.select-gate.index');
  Route::view('loading-process', 'web.outgoing.loading-process.index');
  Route::view('complete', 'web.outgoing.complete.index');
  Route::view('manifest-regular', 'web.outgoing.manifest-regular.index');
  Route::view('manifest-as', 'web.outgoing.manifest-as.index');
  Route::view('update-manifest', 'web.outgoing.update-manifest.index');
  Route::view('overload-concept-or-do', 'web.outgoing.overload-concept-or-do.index');
});
