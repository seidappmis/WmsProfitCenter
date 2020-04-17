<?php

Route::group(['middleware' => 'auth'], function () {
  Route::view('finish-good-production', 'web.incoming.finish-good-production.index');
  Route::view('incoming-import-oem', 'web.incoming.incoming-import-oem.index');
  Route::view('confirm-manifest', 'web.incoming.confirm-manifest.index');
  Route::view('billing-return', 'web.incoming.billing-return.index');
});
