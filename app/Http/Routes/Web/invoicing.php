<?php

Route::group(['middleware' => 'auth'], function () {
  Route::get('list-of-unconfirm-do', 'Web\ListOfUnconfirmDOController@index');
  Route::get('list-of-unconfirm-do/export-to-excel', 'Web\ListOfUnconfirmDOController@exportToExcel');

  Route::view('receipt-invoice', 'web.invoicing.receipt-invoice.index');
  Route::view('receipt-invoice/create', 'web.invoicing.receipt-invoice.create');
  Route::view('receipt-invoice/{id}', 'web.invoicing.receipt-invoice.view');

  Route::view('receipt-invoice-accounting', 'web.invoicing.receipt-invoice-accounting.index');
  Route::view('receipt-invoice-accounting/create', 'web.invoicing.receipt-invoice-accounting.create');
  Route::view('receipt-invoice-accounting/{id}', 'web.invoicing.receipt-invoice-accounting.view');

  Route::view('branch-invoicing', 'web.invoicing.branch-invoicing.index');
  Route::view('branch-invoicing/create', 'web.invoicing.branch-invoicing.create');

  Route::view('summary-freight-cost-analysis', 'web.invoicing.summary-freight-cost-analysis.index');
});
