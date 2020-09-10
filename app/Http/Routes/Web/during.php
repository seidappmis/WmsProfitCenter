<?php

Route::group(['middleware' => 'auth'], function () {
  // Berita Acara
  Route::get('/berita-acara-during', 'Web\BeritaAcaraDuringController@index');

  Route::get('/damage-goods-report', 'Web\DamageGoodsReportController@index');
 
});
