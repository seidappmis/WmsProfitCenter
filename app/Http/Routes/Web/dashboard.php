<?php

Route::group(['middleware' => ['auth', 'authorize.module.access']], function () {
  Route::view('dashboard', 'web.dashboard.dashboard1.index');
  Route::get('dashboard/loading-daily-status', 'Web\DashboardController@getLoadingDailyStatus');
  Route::get('dashboard/waiting-truck-all-area', 'Web\DashboardController@getWaitingTruckAllArea');

  Route::view('dashboard2', 'web.dashboard.dashboard2.index');
  Route::get('dashboard2/daily-by-category', 'Web\Dashboard2Controller@getDailyByCategory');

  Route::view('trucking-monitor', 'web.dashboard.trucking-monitor.index');
  Route::get('trucking-monitor/vehicle-standby', 'Web\TruckingMonitorController@getVehicleStandby');
  Route::get('trucking-monitor/delivery-order', 'Web\TruckingMonitorController@getDeliveryOrder');
});
