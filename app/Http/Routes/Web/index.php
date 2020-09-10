<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'Web\Auth\LoginController@showLoginForm')->name('login');
Route::get('/login', 'Web\Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Web\Auth\LoginController@login')->name('login');
Route::post('/logout', 'Web\Auth\LoginController@logout')->name('logout');
Route::get('/test', function () {
  echo "<pre>";
  $modules   = \App\User::modules();
  print_r($modules);
});

Route::group(['middleware' => 'auth'], function () {
  Route::view('home', 'web.home.index');
  Route::view('only-branch-access', 'web.only-branch-access');
});
