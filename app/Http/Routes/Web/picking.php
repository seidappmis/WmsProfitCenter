<?php

Route::group(['middleware' => 'auth'], function () {
  Route::view('upload-do-for-picking', 'web.picking.upload-do-for-picking.index');
});
