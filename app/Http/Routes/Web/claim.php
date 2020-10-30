<?php

Route::group(['middleware' => ['auth', 'authorize.module.access']], function () {
  // Berita Acara
  Route::get('berita-acara/{id}/export', 'Web\BeritaAcaraController@export');
  Route::post('berita-acara/{berita_acara_id}/detail', 'Web\BeritaAcaraDetailController@store');
  Route::post('berita-acara/{berita_acara_id}/detail/{berita_acara_detail_id}', 'Web\BeritaAcaraDetailController@update');
  Route::get('berita-acara/{berita_acara_id}/detail/{berita_acara_detail_id}/edit', 'Web\BeritaAcaraDetailController@edit');
  Route::delete('berita-acara/{berita_acara_id}/detail/{berita_acara_detail_id}', 'Web\BeritaAcaraDetailController@destroy');
  // Route::resource('berita-acara', 'Web\BeritaAcaraController');
  Route::get('berita-acara', 'Web\BeritaAcaraController@index'); //index
  Route::get('berita-acara/create', 'Web\BeritaAcaraController@create'); //page insert berita acara
  Route::post('berita-acara/store', 'Web\BeritaAcaraController@store'); //proses insert berita acara
  Route::get('berita-acara/{berita_acara_id}', 'Web\BeritaAcaraController@show'); //page detail berita acara
  Route::get('berita-acara/{berita_acara_id}/bulk-template', 'Web\BeritaAcaraController@bulkTemplate'); //download template berita acara
  Route::post('berita-acara/{berita_acara_id}/upload-bulk', 'Web\BeritaAcaraController@uploadBulk'); //upload bulk berita acara
  Route::get('berita-acara/{berita_acara_id}/print', 'Web\BeritaAcaraController@export'); //proses insert berita acara

  // Claim Notes
  Route::get('claim-notes/{id}/export', 'Web\ClaimNoteController@export');
  Route::get('claim-notes/{id}/detail/{detail_id}/export', 'Web\ClaimNoteController@exportDetail');
  Route::get('claim-notes', 'Web\ClaimNoteController@index');
  Route::get('claim-notes/carton-box', 'Web\ClaimNoteController@listCartonBox');
  Route::get('claim-notes/unit', 'Web\ClaimNoteController@listUnit');
  Route::get('claim-notes/list-outstanding', 'Web\ClaimNoteController@listOutstanding'); //get datatable outstanding
  Route::get('claim-notes/create-carton-box', 'Web\ClaimNoteController@createCartonBox');
  Route::get('claim-notes/create-unit', 'Web\ClaimNoteController@createUnit');
  Route::view('claim-notes/{id}', 'web.claim.claim-notes.view');
  Route::post('claim-notes/create', 'Web\ClaimNoteController@create');

  // Claim Insurance
  Route::get('claim-insurance/{id}/export', 'Web\ClaimInsuranceController@exportRPT');
  Route::get('claim-insurance/{id}/detail/{detail_id}/export', 'Web\ClaimInsuranceController@exportDetail');
  Route::view('claim-insurance', 'web.claim.claim-insurance.index');
  Route::view('claim-insurance/create', 'web.claim.claim-insurance.create');
  Route::view('claim-insurance/{id}', 'web.claim.claim-insurance.edit');
});
