<?php

Route::group(['middleware' => ['auth', 'authorize.module.access']], function () {
  // Berita Acara
  Route::get('/berita-acara-during', 'Web\BeritaAcaraDuringController@index');
  Route::get('/berita-acara-during/create', 'Web\BeritaAcaraDuringController@create');
  Route::post('/berita-acara-during/create', 'Web\BeritaAcaraDuringController@prosesCreate'); // create
  Route::post('/berita-acara-during/update', 'Web\BeritaAcaraDuringController@prosesUpdate'); // update
  Route::get('/berita-acara-during/detail-list', 'Web\BeritaAcaraDuringDetailController@list'); // list detail
  Route::post('/berita-acara-during/{id}/create', 'Web\BeritaAcaraDuringDetailController@prosesCreate'); // create detail
  Route::post('/berita-acara-during-detail/update', 'Web\BeritaAcaraDuringDetailController@prosesUpdate'); // update detail
  Route::get('/berita-acara-during/{id}/export-BA', 'Web\BeritaAcaraDuringController@exportBA');
  Route::get('/berita-acara-during/{id}/export-attach', 'Web\BeritaAcaraDuringController@exportAttach');

  Route::get('/damage-goods-report', 'Web\DamageGoodsReportController@index');
  Route::get('/damage-goods-report/{id}/export', 'Web\DamageGoodsReportController@export');
});
