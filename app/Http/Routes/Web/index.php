<?php

use Illuminate\Support\Facades\Route;
// use DB;

Route::get('/', 'Web\Auth\LoginController@showLoginForm')->name('login');
Route::get('/login', 'Web\Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Web\Auth\LoginController@login')->name('login');
Route::post('/logout', 'Web\Auth\LoginController@logout')->name('logout');
// Route::get('/reset-password', function(){
//   $user = App\User::where('username', 'mis5')->first();
//   $user->password = Illuminate\Support\Facades\Hash::make('123456');
//   $user->save();
// });
Route::get('/test', function () {
  // $picking_detail = \App\Models\PickinglistDetail::select(
    //   'wms_pickinglist_detail.id',
    //   // 'wms_pickinglist_detail.delivery_no',
    //   // 'wms_pickinglist_detail.invoice_no',
    //   // 'wms_pickinglist_detail.kode_customer',
    //   // 'wms_pickinglist_detail.code_sales',
    //   'wms_pickinglist_header.city_code',
    //   'wms_pickinglist_header.city_name',
    //   'wms_pickinglist_header.driver_register_id',
    //   'wms_pickinglist_detail.ean_code',
    //   // 'wms_pickinglist_detail.quantity',
    //   // 'wms_pickinglist_detail.cbm',
    //   // DB::raw('GROUP_CONCAT(wms_pickinglist_detail.delivery_items SEPARATOR ",") as rs_delivery_items'),
    //   // DB::raw('GROUP_CONCAT(wms_pickinglist_detail.quantity SEPARATOR ",") as rs_quantity'),
    //   // DB::raw('(wms_pickinglist_detail.cbm / wms_pickinglist_detail.quantity) AS cbm_unit'),
    //   DB::raw('GROUP_CONCAT(DISTINCT CONCAT(wms_pickinglist_detail.invoice_no, ":", wms_pickinglist_detail.delivery_no, ":" , wms_pickinglist_detail.delivery_items, ":", wms_pickinglist_detail.quantity, ":", wms_pickinglist_detail.kode_customer, ":", wms_pickinglist_detail.code_sales, ":", (wms_pickinglist_detail.cbm / wms_pickinglist_detail.quantity)) ORDER BY wms_pickinglist_detail.invoice_no, wms_pickinglist_detail.delivery_no, wms_pickinglist_detail.delivery_items SEPARATOR ",") as rs_in_dn_di_q'),
    //   DB::raw('COUNT(DISTINCT wms_lmb_detail.serial_number) AS quantity_lmb')
    //   // DB::raw('(SUM(wms_pickinglist_detail.quantity) - COUNT(wms_lmb_detail.serial_number)) AS quantity ')
    // )
    //   ->leftjoin('wms_pickinglist_header', 'wms_pickinglist_header.id', '=', 'wms_pickinglist_detail.header_id')
    //   ->leftjoin('wms_lmb_detail', function ($join) {
      //     $join->on('wms_lmb_detail.picking_id', '=', 'wms_pickinglist_detail.header_id');
  //     // $join->on('wms_lmb_detail.delivery_no', '=', 'wms_pickinglist_detail.delivery_no');
  //     // $join->on('wms_lmb_detail.invoice_no', '=', 'wms_pickinglist_detail.invoice_no');
  //     $join->on('wms_lmb_detail.ean_code', '=', 'wms_pickinglist_detail.ean_code');
  //   })
  //   ->groupBy(
    //     'wms_pickinglist_detail.header_id',
    //     // 'wms_pickinglist_detail.invoice_no',
    //     // 'wms_pickinglist_detail.delivery_no',
    //     // 'wms_pickinglist_detail.delivery_items',
    //     'wms_pickinglist_detail.ean_code'
    //   )
    //   ->where(DB::raw('CAST(wms_pickinglist_detail.ean_code AS UNSIGNED)'), 4974019909943)
    //   ->where('wms_pickinglist_header.picking_no', 1020201224001)
    //   ->orderBy('quantity', 'desc');
    
    echo "<pre>";
    // print_r($picking_detail->first());
    // print_r(auth()->user()->allowTo('edit', 'send-to-lmb'));
    DB::connection('sqlsrv')->statement('SET ANSI_NULLS, QUOTED_IDENTIFIER, CONCAT_NULL_YIELDS_NULL, ANSI_WARNINGS, ANSI_PADDING ON');
    $sql = DB::connection('sqlsrv')->select("
    SELECT TOP (100)
    Bar_Ticket_Header.HEADER_NAME
    , (Bar_Ticket_Detail.SERIAL_NUMBER.value('count(/cols/fields)', 'int')) AS quantity
    , Bar_Model_Master.EAN_CODE
    , Bar_Model_Master.MODEL
    , Bar_Model_Master.PLANT
    , Bar_Schedule_Header.TIPE
    FROM 
    Bar_Ticket_Detail
    LEFT JOIN Bar_Ticket_Header ON Bar_Ticket_Header.ID = Bar_Ticket_Detail.HEADER_ID
    LEFT JOIN Bar_Schedule_Header ON Bar_Schedule_Header.ID = Bar_Ticket_Detail.SCH_ID
    LEFT JOIN Bar_Model_Master ON Bar_Model_Master.SAP_MODEL = Bar_Schedule_Header.SAPMODEL
    WHERE Bar_Model_Master.MODEL != ''
    ");
    
    print_r($sql);
  });
  
  
  Route::group(['middleware' => 'auth'], function () {
    Route::get('data-synchronization', 'DataSynchronizationController@index');
    Route::view('home', 'web.home.index');
    Route::view('only-branch-access', 'web.only-branch-access');
    Route::post('/change-password', 'Web\Auth\ChangePasswordController@changePassword')->name('change-password');
  });
  