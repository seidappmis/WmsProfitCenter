<?php

Route::group(['middleware' => ['auth', 'authorize.module.access']], function () {
  // Berita Acara
  Route::get('/berita-acara-during', 'Web\BeritaAcaraDuringController@index');
  Route::get('/berita-acara-during/create', 'Web\BeritaAcaraDuringController@create');
  Route::post('/berita-acara-during/create', 'Web\BeritaAcaraDuringController@prosesCreate'); // create
  Route::post('/berita-acara-during/update', 'Web\BeritaAcaraDuringController@prosesUpdate'); // update
  Route::get('/berita-acara-during/{id}', 'Web\BeritaAcaraDuringController@detail');
  Route::delete('/berita-acara-during/{id}', 'Web\BeritaAcaraDuringController@prosesDelete');
  Route::put('berita-acara-during/{id}/submit', 'Web\BeritaAcaraDuringController@submit');
  Route::delete('/berita-acara-during/{id}/delete/{type}', 'Web\BeritaAcaraDuringController@prosesDeleteImage'); //delete image
  Route::get('/berita-acara-during/{id}/detail-list', 'Web\BeritaAcaraDuringDetailController@list'); // list detail
  Route::delete('/berita-acara-during/{id}/delete', 'Web\BeritaAcaraDuringDetailController@prosesDelete'); //delete detail
  Route::post('/berita-acara-during/{id}/create', 'Web\BeritaAcaraDuringDetailController@prosesCreate'); // create detail
  Route::post('/berita-acara-during-detail/update', 'Web\BeritaAcaraDuringDetailController@prosesUpdate'); // update detail
  Route::get('/berita-acara-during/{id}/export', 'Web\BeritaAcaraDuringController@export');
  Route::get('/berita-acara-during/{id}/export-attach', 'Web\BeritaAcaraDuringController@exportAttach');
  Route::get('/berita-acara-during/{id}/export-attach', 'Web\BeritaAcaraDuringController@exportAttach');

  Route::get('/damage-goods-report', 'Web\DamageGoodsReportController@index');
  Route::get('/damage-goods-report/list-outstanding', 'Web\DamageGoodsReportController@listOutstanding'); //get datatable outstanding
  Route::get('/damage-goods-report/{id}/export', 'Web\DamageGoodsReportController@export');
});
