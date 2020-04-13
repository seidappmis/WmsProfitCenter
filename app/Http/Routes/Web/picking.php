<?php

Route::group(['middleware' => 'auth'], function () {
  Route::view('upload-do-for-picking', 'web.picking.upload-do-for-picking.index');
  Route::view('picking-list', 'web.picking.upload-do-for-picking.index');
  Route::view('picking-to-lmb', 'web.picking.upload-do-for-picking.index');
});
