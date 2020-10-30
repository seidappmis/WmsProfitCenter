<?php

Route::group(['middleware' => ['auth', 'authorize.module.access']], function () {
  Route::get('report-master', 'Web\ReportMasterController@index');
  Route::get('report-master/export', 'Web\ReportMasterController@export');

  Route::get('report-master-users', 'Web\ReportMasterUserController@index');
  Route::get('report-master-users/export', 'Web\ReportMasterUserController@export');

  Route::get('report-user-mobile', 'Web\ReportMasterUserMobileController@index');
  Route::get('report-user-mobile/export', 'Web\ReportMasterUserMobileController@export');

  Route::get('standby-driver-list', 'Web\StandbyDriverListController@index');
  Route::get('standby-driver-list/export', 'Web\StandbyDriverListController@export');

  Route::get('concept-or-do-outstanding-list', 'Web\ConceptOrDOOutstandingListController@index');
  Route::get('concept-or-do-outstanding-list/export', 'Web\ConceptOrDOOutstandingListController@export');

  Route::get('loading-status-list', 'Web\LoadingStatusListController@index');
  Route::post('loading-status-list', 'Web\LoadingStatusListController@index');
  Route::get('loading-status-list/export', 'Web\LoadingStatusListController@export');

  Route::get('report-concept-coming-vs-actual-loading', 'Web\ReportConceptComingActualLoadingController@index');
  Route::get('report-concept-coming-vs-actual-loading/graph', 'Web\ReportConceptComingActualLoadingController@getGraph');
  Route::view('concept-issue', 'web.report.concept-issue.index');
  Route::get('report-loading-lead-time', 'Web\ReportLoadingLeadTimeController@index');
  Route::get('report-loading-lead-time/graph', 'Web\ReportLoadingLeadTimeController@getGraph');
  Route::view('report-loading-summary', 'web.report.report-loading-summary.index');

  Route::get('report-kpi-expeditions', 'Web\ReportKPIExpeditionsController@index');

  Route::get('summary-incoming-report', 'Web\SummaryIncomingReportController@index');
  Route::get('summary-incoming-report/export', 'Web\SummaryIncomingReportController@export');

  Route::get('summary-outgoing-report', 'Web\SummaryOutgoingReportController@index');
  Route::post('summary-outgoing-report', 'Web\SummaryOutgoingReportController@index');
  Route::get('summary-outgoing-report/export', 'Web\SummaryOutgoingReportController@export');

  Route::get('report-master-freight-cost', 'Web\ReportMasterFreightCostController@index');
  Route::get('report-master-freight-cost/export', 'Web\ReportMasterFreightCostController@export');
  Route::view('summary-freight-cost-report-per-manifest', 'web.report.summary-freight-cost-report-per-manifest.index');
  Route::view('summary-freight-cost-report-per-region', 'web.report.summary-freight-cost-report-per-region.index');

  Route::get('report-overload-concept-or-do', 'Web\ReportOverloadConceptOrDOController@index');
  Route::post('report-overload-concept-or-do', 'Web\ReportOverloadConceptOrDOController@index');
  Route::get('report-overload-concept-or-do/export', 'Web\ReportOverloadConceptOrDOController@export');


  Route::get('summary-task-notice', 'Web\SummaryTaskNoticeController@index');

  // Route::view('report-user-mobile', 'web.report.report-user-mobile.index');

  /*
  Summary LMB REPORT
   */
  Route::get('summary-lmb-report', 'Web\SummaryLMBReportController@index');

  Route::get('report-inventory-movement', 'Web\ReportInventoryMovementController@index');

  Route::get('report-stock-inventory', 'Web\ReportStockInventoryController@index');
  Route::get('report-stock-inventory/export', 'Web\ReportStockInventoryController@export');

  Route::get('serial-number-trace', 'Web\SerialNumberTraceController@index');
  Route::get('serial-number-trace/export', 'Web\SerialNumberTraceController@export');

  Route::get('report-occupancy', 'Web\ReportOccupancyController@index');
  Route::get('report-occupancy/export', 'Web\ReportOccupancyController@export');
  
  Route::get('summary-wh-transporter-report', 'Web\SummaryWHTransporterReportController@index');
  Route::get('summary-wh-transporter-report/export', 'Web\SummaryWHTransporterReportController@export');

  Route::get('summary-do-confirmed', 'Web\SummaryDOConfirmedController@index');
  Route::get('summary-do-confirmed/export', 'Web\SummaryDOConfirmedController@export');
});
