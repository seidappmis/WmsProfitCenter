<?php

Route::group(['middleware' => 'auth'], function () {
  // Berita Acara
  Route::get('berita-acara/{id}/print', 'Web\BeritaAcaraController@printView');
  Route::post('berita-acara/{berita_acara_id}/detail', 'Web\BeritaAcaraDetailController@store');
  Route::put('berita-acara/{berita_acara_id}/detail/{berita_acara_detail_id}', 'Web\BeritaAcaraDetailController@update');
  Route::get('berita-acara/{berita_acara_id}/detail/{berita_acara_detail_id}/edit', 'Web\BeritaAcaraDetailController@edit');
  Route::delete('berita-acara/{berita_acara_id}/detail/{berita_acara_detail_id}', 'Web\BeritaAcaraDetailController@destroy');
  Route::resource('berita-acara', 'Web\BeritaAcaraController');

  // Claim Notes
  Route::get('claim-notes', 'Web\ClaimNoteController@index');
  Route::get('claim-notes/carton-box', 'Web\ClaimNoteController@listCartonBox');
  Route::get('claim-notes/unit', 'Web\ClaimNoteController@listUnit');
  Route::get('claim-notes/create-carton-box', 'Web\ClaimNoteController@createCartonBox');
  Route::get('claim-notes/create-unit', 'Web\ClaimNoteController@createUnit');
  Route::view('claim-notes/{id}', 'web.claim.claim-notes.view');

  // Claim Insurance
  Route::view('claim-insurance', 'web.claim.claim-insurance.index');
  Route::view('claim-insurance/create', 'web.claim.claim-insurance.create');
  Route::view('claim-insurance/{id}', 'web.claim.claim-insurance.edit');
});
