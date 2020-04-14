<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'Web\Auth\LoginController@showLoginForm')->name('login');
Route::get('/login', 'Web\Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Web\Auth\LoginController@login')->name('login');
Route::post('/logout', 'Web\Auth\LoginController@logout')->name('logout');

Route::group(['middleware' => 'auth'], function () {
  Route::view('home', 'web.home.index');
  Route::view('dashboard', 'web.dashboard.index');
  Route::view('dashboard2', 'web.dashboard2.index');
  Route::view('trucking-monitor', 'web.trucking-monitor.index');
});
