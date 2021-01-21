<?php

Route::group(['middleware' => ['auth', 'authorize.module.access']], function () {
  Route::get('list-of-unconfirm-do', 'Web\ListOfUnconfirmDOController@index');
  Route::get('list-of-unconfirm-do/export-to-excel', 'Web\ListOfUnconfirmDOController@exportToExcel');

  Route::get('receipt-invoice', 'Web\ReceiptInvoiceController@index');
  Route::get('receipt-invoice/manifest', 'Web\ReceiptInvoiceController@getManifest');
  Route::get('receipt-invoice/{id_header}/manifest', 'Web\ReceiptInvoiceController@getListDo');
  Route::get('receipt-invoice/{id_header}/do-data', 'Web\ReceiptInvoiceController@getDOData');
  Route::put('receipt-invoice/{id_header}/do-data', 'Web\ReceiptInvoiceController@updateDOData');
  Route::put('receipt-invoice/{id_header}/do-data/{manifest_detail_id}', 'Web\ReceiptInvoiceController@updateDODataDetail');
  Route::get('receipt-invoice/create', 'Web\ReceiptInvoiceController@create');
  Route::post('receipt-invoice', 'Web\ReceiptInvoiceController@store');
  Route::post('receipt-invoice/{id}/create-receipt-no', 'Web\ReceiptInvoiceController@createReceiptNo');
  Route::put('receipt-invoice/{id}/update-receipt-invoice', 'Web\ReceiptInvoiceController@updateReceiptInvoice');
  Route::put('receipt-invoice/{id}/update-ppn', 'Web\ReceiptInvoiceController@updatePPN');
  Route::get('receipt-invoice/{id}', 'Web\ReceiptInvoiceController@show');
  Route::put('receipt-invoice/{id}', 'Web\ReceiptInvoiceController@update');
  Route::delete('receipt-invoice/{id}', 'Web\ReceiptInvoiceController@destroy');
  Route::delete('receipt-invoice/{id}/manifest/{do_manifest_no}', 'Web\ReceiptInvoiceController@destroyManifest');
  Route::get('receipt-invoice/{id}/export-receipt-no', 'Web\ReceiptInvoiceController@exportReceiptNo');
  Route::get('receipt-invoice/{id}/export-receive-invoice', 'Web\ReceiptInvoiceController@exportReceiptInvoice');
  Route::post('receipt-invoice/{id}/submit-to-accounting', 'Web\ReceiptInvoiceController@submitToAccounting');

  Route::get('receipt-invoice-accounting', 'Web\ReceiptInvoiceAccountingController@index');
  Route::post('receipt-invoice-accounting', 'Web\ReceiptInvoiceAccountingController@store');
  Route::get('receipt-invoice-accounting/receipt-list', 'Web\ReceiptInvoiceAccountingController@getReceiptList');
  Route::get('receipt-invoice-accounting/{id}/payment-requisition', 'Web\ReceiptInvoiceAccountingController@getListPaymentRequisition');
  Route::post('receipt-invoice-accounting/{id}/payment-requisition', 'Web\ReceiptInvoiceAccountingController@storeListPaymentRequisition');
  Route::delete('receipt-invoice-accounting/{id}/invoice/{invoice_receipt_id}', 'Web\ReceiptInvoiceAccountingController@destroyInvoice');
  Route::get('receipt-invoice-accounting/create', 'Web\ReceiptInvoiceAccountingController@create');
  Route::get('receipt-invoice-accounting/{id}', 'Web\ReceiptInvoiceAccountingController@show');
  Route::put('receipt-invoice-accounting/{id}', 'Web\ReceiptInvoiceAccountingController@update');
  Route::delete('receipt-invoice-accounting/{id}', 'Web\ReceiptInvoiceAccountingController@destroy');
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
  Route::get('summary-freight-cost-analysis/export', 'Web\SummaryFreightCostAnalysisController@export');
});
