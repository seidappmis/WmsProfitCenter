<?php

Route::group(['middleware' => 'auth'], function () {
    Route::get('list-of-unconfirm-do', 'Web\ListOfUnconfirmDOController@index');
    Route::get('list-of-unconfirm-do/export-to-excel', 'Web\ListOfUnconfirmDOController@exportToExcel');

    Route::get('receipt-invoice', 'Web\ReceiptInvoiceController@index');
    Route::get('receipt-invoice/create', 'Web\ReceiptInvoiceController@create');
    Route::get('receipt-invoice/{id}', 'Web\ReceiptInvoiceController@show');
    Route::get('receipt-invoice/{id}/export-receipt-no', 'Web\ReceiptInvoiceController@exportReceiptNo');
    Route::get('receipt-invoice/{id}/export-receipt-invoice', 'Web\ReceiptInvoiceController@exportReceiptInvoice');


    Route::get('receipt-invoice-accounting', 'Web\ReceiptInvoiceAccountingController@index');
    Route::get('receipt-invoice-accounting/create', 'Web\ReceiptInvoiceAccountingController@create');
    Route::get('receipt-invoice-accounting/{id}', 'Web\ReceiptInvoiceAccountingController@show');
    Route::get('receipt-invoice-accounting/{id}/export-receipt-invoice-accounting', 'Web\ReceiptInvoiceAccountingController@exportReceiptInvoiceAccounting');

    Route::get('branch-invoicing', 'Web\BranchInvoicingController@index');
    Route::get('branch-invoicing/create', 'Web\BranchInvoicingController@create');
    Route::get('branch-invoicing/{id}/export', 'Web\BranchInvoicingController@export');

    Route::get('summary-freight-cost-analysis', 'Web\SummaryFreightCostAnalysisController@index');
});
