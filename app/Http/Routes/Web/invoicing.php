<?php

Route::group(['middleware' => 'auth', 'prefix' => 'invoicing'], function () {
  Route::view('list-of-unconfirm-do', 'web.invoicing.list-of-unconfirm-do.index');
  Route::view('receipt-invoice', 'web.invoicing.receipt-invoice.index');
  Route::view('receipt-invoice-accounting', 'web.invoicing.receipt-invoice-accounting.index');
});
