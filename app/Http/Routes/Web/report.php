<?php

Route::group(['middleware' => 'auth'], function () {
  Route::get('report-master', 'Web\ReportMasterController@index');
  Route::get('report-master/export', 'Web\ReportMasterController@export');

  Route::get('report-master-users', 'Web\ReportMasterUserController@index');
  Route::get('report-master-users/export', 'Web\ReportMasterUserController@export');

  Route::get('report-user-mobile', 'Web\ReportMasterUserMobileController@index');
  Route::get('report-user-mobile/export', 'Web\ReportMasterUserMobileController@export');

  Route::view('standby-driver-list', 'web.report.standby-driver-list.index');

  Route::get('concept-or-do-outstanding-list', 'Web\ConceptOrDOOutstandingListController@index');

  Route::view('loading-status-list', 'web.report.loading-status-list.index');
  Route::view('report-concept-coming-vs-actual-loading', 'web.report.report-concept-coming-vs-actual-loading.index');
  Route::view('concept-issue', 'web.report.concept-issue.index');
  Route::view('report-loading-lead-time', 'web.report.report-loading-lead-time.index');
  Route::view('report-loading-summary', 'web.report.report-loading-summary.index');
  Route::view('report-kpi-expeditions', 'web.report.report-kpi-expeditions.index');
  Route::view('summary-incoming-report', 'web.report.summary-incoming-report.index');
  Route::view('summary-outgoing-report', 'web.report.summary-outgoing-report.index');
  Route::view('report-master-freight-cost', 'web.report.report-master-freight-cost.index');
  Route::view('summary-freight-cost-report-per-manifest', 'web.report.summary-freight-cost-report-per-manifest.index');
  Route::view('summary-freight-cost-report-per-region', 'web.report.summary-freight-cost-report-per-region.index');
  Route::view('report-overload-concept-or-do', 'web.report.report-overload-concept-or-do.index');
  Route::view('summary-task-notice', 'web.report.summary-task-notice.index');

  Route::view('report-user-mobile', 'web.report.report-user-mobile.index');

  Route::view('summary-lmb-report', 'web.report.summary-lmb-report.index');
  Route::view('report-inventory-movement', 'web.report.report-inventory-movement.index');
  Route::view('report-stock-inventory', 'web.report.report-stock-inventory.index');
  Route::view('serial-number-trace', 'web.report.serial-number-trace.index');
  Route::view('report-occupancy', 'web.report.report-occupancy.index');
  Route::view('summary-wh-transporter-report', 'web.report.summary-wh-transporter-report.index');
  Route::view('summary-do-confirmed', 'web.report.summary-do-confirmed.index');
});
