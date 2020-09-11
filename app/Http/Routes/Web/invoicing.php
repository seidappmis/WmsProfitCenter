<?php

Route::group(['middleware' => 'auth'], function () {
  Route::get('list-of-unconfirm-do', 'Web\ListOfUnconfirmDOController@index');
  Route::get('list-of-unconfirm-do/export-to-excel', 'Web\ListOfUnconfirmDOController@exportToExcel');

  Route::get('receipt-invoice', 'Web\ReceiptInvoiceController@index');
  Route::get('receipt-invoice/manifest', 'Web\ReceiptInvoiceController@getManifest');
  Route::get('receipt-invoice/create', 'Web\ReceiptInvoiceController@create');
  Route::post('receipt-invoice', 'Web\ReceiptInvoiceController@store');
  Route::get('receipt-invoice/{id}', 'Web\ReceiptInvoiceController@show');
  Route::get('receipt-invoice/{id}/export-receipt-no', 'Web\ReceiptInvoiceController@exportReceiptNo');
  Route::get('receipt-invoice/{id}/export-receive-invoice', 'Web\ReceiptInvoiceController@exportReceiptInvoice');

  Route::get('receipt-invoice-accounting', 'Web\ReceiptInvoiceAccountingController@index');
  Route::get('receipt-invoice-accounting/create', 'Web\ReceiptInvoiceAccountingController@create');
  Route::get('receipt-invoice-accounting/{id}', 'Web\ReceiptInvoiceAccountingController@show');
  Route::get('receipt-invoice-accounting/{id}/export-receipt-invoice-accounting', 'Web\ReceiptInvoiceAccountingController@exportReceiptInvoiceAccounting');

  Route::put('branch-invoicing', 'Web\BranchInvoicingController@update');
  Route::delete('branch-invoicing', 'Web\BranchInvoicingController@destroy');
  Route::get('branch-invoicing', 'Web\BranchInvoicingController@index');
  Route::post('branch-invoicing', 'Web\BranchInvoicingController@store');
  Route::get('branch-invoicing/manifest-data', 'Web\BranchInvoicingController@getManifestData');
  Route::get('branch-invoicing/manifest-details', 'Web\BranchInvoicingController@getManifestDetails');
  Route::get('branch-invoicing/{group_id}', 'Web\BranchInvoicingController@show');
  Route::get('branch-invoicing/create', 'Web\BranchInvoicingController@create');
  Route::get('branch-invoicing/{id}/export', 'Web\BranchInvoicingController@export');

  Route::get('summary-freight-cost-analysis', 'Web\SummaryFreightCostAnalysisController@index');

});
