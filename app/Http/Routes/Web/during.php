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
  Route::get('/berita-acara-during-select2-kapal', 'Web\BeritaAcaraDuringController@getSelect2Kapal');

  // damage goods report
  Route::get('/damage-goods-report', 'Web\DamageGoodsReportController@index');
  // Route::get('/damage-goods-report/{id}', 'Web\DamageGoodsReportController@show');
  Route::get('/damage-goods-report/list-outstanding', 'Web\DamageGoodsReportController@listOutstanding'); //get datatable outstanding
  Route::get('/damage-goods-report/list-damage-goods-report', 'Web\DamageGoodsReportController@listDGR'); //get datatable detail
  Route::get('/damage-goods-report/{id}/print', 'Web\DamageGoodsReportController@export');
  Route::get('/damage-goods-report/{id}/print-detail', 'Web\DamageGoodsReportController@exportDetail');
  Route::post('/damage-goods-report/create', 'Web\DamageGoodsReportController@create');
  Route::get('/damage-goods-report/{id}/export', 'Web\DamageGoodsReportController@export');
  Route::get('damage-goods-report/{id}', 'Web\DamageGoodsReportController@show');
  Route::delete('damage-goods-report/{id}', 'Web\DamageGoodsReportController@destroy');
  Route::delete('damage-goods-report/details/{id}', 'Web\DamageGoodsReportController@destroyDetail');
  Route::put('damage-goods-report/{id}/submit', 'Web\DamageGoodsReportController@submit');
  Route::get('damage-goods-report/{id}/detail', 'Web\DamageGoodsReportController@getDetail');
  Route::get('/damage-goods-report/select2', 'Web\DamageGoodsReportController@getSelect2');


  //summary DGR
  Route::get('summary-damage-goods-report',  'Web\SummaryDamageGoodsReportController@index');
  Route::get('summary-damage-goods-report/{id}',  'Web\SummaryDamageGoodsReportController@show');
  Route::put('summary-damage-goods-report/{id}',  'Web\SummaryDamageGoodsReportController@update');
  Route::get('summary-damage-goods-report/{id}/export',  'Web\SummaryDamageGoodsReportController@export');

  //Marine Cargo
  Route::get('/marine-cargo',  'Web\MarineCargoController@index');
  Route::get('/marine-cargo/create', 'Web\MarineCargoController@create');
  Route::post('/marine-cargo/create', 'Web\MarineCargoController@Postcreate');
  Route::get('/marine-cargo/select2-dgr', 'Web\MarineCargoController@getSelect2DGR');
  Route::get('/marine-cargo/{id}',  'Web\MarineCargoController@view');
  Route::delete('/marine-cargo/{id}',  'Web\MarineCargoController@destroy');
  Route::get('/marine-cargo/{id}/export-claim-note',  'Web\MarineCargoController@exportClaimNote');
  Route::get('/marine-cargo/{id}/export-notice-of-claim',  'Web\MarineCargoController@exportNoticeOfClaim');
});
