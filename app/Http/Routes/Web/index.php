<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'Web\Auth\LoginController@showLoginForm')->name('login');
Route::get('/login', 'Web\Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Web\Auth\LoginController@login')->name('login');
Route::post('/logout', 'Web\Auth\LoginController@logout')->name('logout');
Route::get('/test', function () {
  // echo "<pre>";
  // $modules   = \App\User::modules();
  // print_r($modules);
  $redColor = [255, 0, 0];

  $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
  echo '<img src="data:image/png;base64,' . base64_encode($generator->getBarcode('081231723897', $generator::TYPE_CODE_39)) . '">';
});

Route::group(['middleware' => 'auth'], function () {
  Route::view('home', 'web.home.index');
  Route::view('only-branch-access', 'web.only-branch-access');
});
