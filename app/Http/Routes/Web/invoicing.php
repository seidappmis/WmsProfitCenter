<?php

Route::group(['middleware' => 'auth'], function () {
  Route::view('list-of-unconfirm-do', 'web.invoicing.list-of-unconfirm-do.index');
  Route::view('receipt-invoice', 'web.invoicing.receipt-invoice.index');
  Route::view('receipt-invoice-accounting', 'web.invoicing.receipt-invoice-accounting.index');
  Route::view('branch-invoicing', 'web.invoicing.branch-invoicing.index');
  Route::view('summary-freight-cost-analysis', 'web.invoicing.summary-freight-cost-analysis.index');
});
