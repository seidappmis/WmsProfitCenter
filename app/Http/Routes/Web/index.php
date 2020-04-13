<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'Web\Auth\LoginController@showLoginForm')->name('login');
Route::get('/login', 'Web\Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Web\Auth\LoginController@login')->name('login');
Route::post('/logout', 'Web\Auth\LoginController@logout')->name('logout');