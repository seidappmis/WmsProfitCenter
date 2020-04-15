<?php

Route::group(['middleware' => 'auth'], function () {
  Route::view('master-gate', 'web.master.master-gate.index');
});