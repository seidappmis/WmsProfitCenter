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

  Route::get('loading-status-list', 'Web\LoadingStatusListController@index');
  Route::post('loading-status-list', 'Web\LoadingStatusListController@index');

  Route::view('report-concept-coming-vs-actual-loading', 'web.report.report-concept-coming-vs-actual-loading.index');
  Route::view('concept-issue', 'web.report.concept-issue.index');
  Route::view('report-loading-lead-time', 'web.report.report-loading-lead-time.index');
  Route::view('report-loading-summary', 'web.report.report-loading-summary.index');

  Route::get('report-kpi-expeditions', 'Web\ReportKPIExpeditionsController@index');

  Route::get('summary-incoming-report', 'Web\SummaryIncomingReportController@index');

  Route::get('summary-outgoing-report', 'Web\SummaryOutgoingReportController@index');
  Route::get('report-master-freight-cost', 'Web\ReportMasterFreightCostController@index');
  Route::view('summary-freight-cost-report-per-manifest', 'web.report.summary-freight-cost-report-per-manifest.index');
  Route::view('summary-freight-cost-report-per-region', 'web.report.summary-freight-cost-report-per-region.index');

  Route::get('report-overload-concept-or-do', 'Web\ReportOverloadConceptOrDOController@index');
  Route::post('report-overload-concept-or-do', 'Web\ReportOverloadConceptOrDOController@index');


  Route::get('summary-task-notice', 'Web\SummaryTaskNoticeController@index');

  // Route::view('report-user-mobile', 'web.report.report-user-mobile.index');

  /*
  Summary LMB REPORT
   */
  Route::get('summary-lmb-report', 'Web\SummaryLMBReportController@index');

  Route::get('report-inventory-movement', 'Web\ReportInventoryMovementController@index');

  Route::get('report-stock-inventory', 'Web\ReportStockInventoryController@index');

  Route::get('serial-number-trace', 'Web\SerialNumberTraceController@index');
  Route::get('serial-number-trace/export', 'Web\SerialNumberTraceController@export');

  Route::get('report-occupancy', 'Web\ReportOccupancyController@index');
  Route::get('report-occupancy/export', 'Web\ReportOccupancyController@export');
  
  Route::get('summary-wh-transporter-report', 'Web\SummaryWHTransporterReportController@index');
  Route::get('summary-wh-transporter-report/export', 'Web\SummaryWHTransporterReportController@export');

  Route::get('summary-do-confirmed', 'Web\SummaryDOConfirmedController@index');
  Route::get('summary-do-confirmed/export', 'Web\SummaryDOConfirmedController@export');
});
