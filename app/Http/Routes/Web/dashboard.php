<?php

Route::group(['middleware' => 'auth'], function () {
  Route::view('dashboard', 'web.dashboard.dashboard1.index');
  Route::view('dashboard2', 'web.dashboard.dashboard2.index');

  Route::view('trucking-monitor', 'web.dashboard.trucking-monitor.index');
  Route::get('trucking-monitor/vehicle-standby', 'Web\TruckingMonitorController@getVehicleStandby');
});
