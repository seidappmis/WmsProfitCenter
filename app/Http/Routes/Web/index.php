<?php

use Illuminate\Support\Facades\Route;
// use DB;

Route::get('/', 'Web\Auth\LoginController@showLoginForm')->name('login');
Route::get('/login', 'Web\Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Web\Auth\LoginController@login')->name('login');
Route::post('/logout', 'Web\Auth\LoginController@logout')->name('logout');
Route::get('/test', function () {
  echo "<pre>";
  print_r(auth()->user()->allowTo('edit', 'send-to-lmb'));
  // $sql = DB::connection('sqlsrv')->table('LOG_Manifest_Header')->first();
  // print_r($sql);
});


Route::group(['middleware' => 'auth'], function () {
  Route::get('data-synchronization', 'DataSynchronizationController@index');
  Route::view('home', 'web.home.index');
  Route::view('only-branch-access', 'web.only-branch-access');
});
