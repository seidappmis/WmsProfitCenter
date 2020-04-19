<?php

Route::group(['middleware' => 'auth'], function () {

  Route::view('finish-good-production', 'web.incoming.finish-good-production.index');
  Route::view('finish-good-production/create', 'web.incoming.finish-good-production.create');
  Route::view('finish-good-production/{id}', 'web.incoming.finish-good-production.view');

  Route::view('incoming-import-oem', 'web.incoming.incoming-import-oem.index');
  Route::view('conform-manifest', 'web.incoming.conform-manifest.index');
  Route::view('billing-return', 'web.incoming.billing-return.index');
});
