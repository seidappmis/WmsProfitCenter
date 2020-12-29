<?php

use Illuminate\Support\Facades\Route;
// use DB;

Route::get('/', 'Web\Auth\LoginController@showLoginForm')->name('login');
Route::get('/login', 'Web\Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Web\Auth\LoginController@login')->name('login');
Route::post('/logout', 'Web\Auth\LoginController@logout')->name('logout');
Route::get('/test', function () {
  $now = date('Y-m-d H:i:s', strtotime('-7 hours'));
  echo $now;
  // echo "<pre>";
  // print_r(auth()->user()->allowTo('edit', 'send-to-lmb'));
  // DB::connection('sqlsrv')->statement('SET ANSI_NULLS, QUOTED_IDENTIFIER, CONCAT_NULL_YIELDS_NULL, ANSI_WARNINGS, ANSI_PADDING ON');
  // $sql = DB::connection('sqlsrv')->select("
  //   SELECT TOP (100)
  //   Bar_Ticket_Header.HEADER_NAME
  //   , (Bar_Ticket_Detail.SERIAL_NUMBER.value('count(/cols/fields)', 'int')) AS quantity
  //   , Bar_Model_Master.EAN_CODE
  //   , Bar_Model_Master.MODEL
  //   , Bar_Model_Master.PLANT
  //   , Bar_Schedule_Header.TIPE
  //   FROM 
  //   Bar_Ticket_Detail
  //   LEFT JOIN Bar_Ticket_Header ON Bar_Ticket_Header.ID = Bar_Ticket_Detail.HEADER_ID
  //   LEFT JOIN Bar_Schedule_Header ON Bar_Schedule_Header.ID = Bar_Ticket_Detail.SCH_ID
  //   LEFT JOIN Bar_Model_Master ON Bar_Model_Master.SAP_MODEL = Bar_Schedule_Header.SAPMODEL
  //   WHERE Bar_Model_Master.MODEL != ''
  //   ");

  // print_r($sql);
});


Route::group(['middleware' => 'auth'], function () {
  Route::get('data-synchronization', 'DataSynchronizationController@index');
  Route::view('home', 'web.home.index');
  Route::view('only-branch-access', 'web.only-branch-access');
});
