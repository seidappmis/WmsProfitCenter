<?php

Route::group(['middleware' => ['auth', 'authorize.module.access']], function () {
  // Berita Acara
  Route::get('/berita-acara-during', 'Web\BeritaAcaraDuringController@index');
  Route::get('/berita-acara-during/create', 'Web\BeritaAcaraDuringController@create');
  Route::post('/berita-acara-during/create', 'Web\BeritaAcaraDuringController@prosesCreate');
  Route::get('/berita-acara-during/{id}/export-BA', 'Web\BeritaAcaraDuringController@exportBA');
  Route::get('/berita-acara-during/{id}/export-attach', 'Web\BeritaAcaraDuringController@exportAttach');

  Route::get('/damage-goods-report', 'Web\DamageGoodsReportController@index');
  Route::get('/damage-goods-report/{id}/export', 'Web\DamageGoodsReportController@export');
});
