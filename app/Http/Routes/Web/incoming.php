<?php

Route::group(['middleware' => 'auth'], function () {

  Route::view('finish-good-production', 'web.incoming.finish-good-production.index');
  Route::view('finish-good-production/create', 'web.incoming.finish-good-production.create');
  Route::view('finish-good-production/{id}', 'web.incoming.finish-good-production.view');

  Route::view('incoming-import-oem', 'web.incoming.incoming-import-oem.index');
  Route::view('incoming-import-oem/create', 'web.incoming.incoming-import-oem.create');
  Route::view('incoming-import-oem/{id}', 'web.incoming.incoming-import-oem.view');

  Route::view('conform-manifest', 'web.incoming.conform-manifest.index');
  Route::view('conform-manifest/{id}', 'web.incoming.conform-manifest.view');

  Route::view('billing-return', 'web.incoming.billing-return.index');
  Route::view('billing-return/{id}', 'web.incoming.billing-return.view');

  Route::view('claim-notes', 'web.incoming.claim-notes.index');
  Route::view('claim-notes/create', 'web.incoming.claim-notes.create');
  Route::view('claim-notes/{id}', 'web.incoming.claim-notes.view');
});
