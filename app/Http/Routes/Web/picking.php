<?php

Route::group(['middleware' => 'auth'], function () {
  Route::view('upload-do-for-picking', 'web.picking.upload-do-for-picking.index');
  Route::view('picking-list', 'web.picking.picking-list.index');
  Route::view('picking-to-lmb', 'web.picking.picking-to-lmb.index');
});
