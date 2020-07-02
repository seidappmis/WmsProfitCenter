<?php

Route::group(['middleware' => 'auth'], function () {
  // Berita Acara
  Route::post('berita-acara/{berita_acara_id}/detail', 'Web\BeritaAcaraDetailController@store');
  Route::delete('berita-acara/{berita_acara_id}/detail/{berita_acara_detail_id}', 'Web\BeritaAcaraDetailController@destroy');
  Route::resource('berita-acara', 'Web\BeritaAcaraController');

  Route::view('claim-notes', 'web.claim.claim-notes.index');
  Route::view('claim-notes/create-carton-box', 'web.claim.claim-notes.create-carton-box');
  Route::view('claim-notes/create-unit', 'web.claim.claim-notes.create-unit');
  Route::view('claim-notes/{id}', 'web.claim.claim-notes.view');

  Route::view('claim-insurance', 'web.claim.claim-insurance.index');
  Route::view('claim-insurance/create', 'web.claim.claim-insurance.create');
  Route::view('claim-insurance/{id}', 'web.claim.claim-insurance.edit');
});
