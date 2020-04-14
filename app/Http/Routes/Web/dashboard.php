<?php

Route::group(['middleware' => 'auth'], function () {
  Route::view('dashboard', 'web.dashboard.index');
  Route::view('dashboard2', 'web.dashboard2.index');
  Route::view('trucking-monitor', 'web.trucking-monitor.index');
});
