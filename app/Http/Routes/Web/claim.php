<?php

Route::group(['middleware' => ['auth', 'authorize.module.access']], function () {
  // Berita Acara
  Route::get('berita-acara/{id}/export', 'Web\BeritaAcaraController@export');
  Route::post('berita-acara/{berita_acara_id}/detail', 'Web\BeritaAcaraDetailController@store');
  Route::post('berita-acara/{berita_acara_id}/detail/{berita_acara_detail_id}', 'Web\BeritaAcaraDetailController@update');
  Route::get('berita-acara/{berita_acara_id}/detail/{berita_acara_detail_id}/edit', 'Web\BeritaAcaraDetailController@edit');
  Route::delete('berita-acara/{berita_acara_id}/detail/{berita_acara_detail_id}', 'Web\BeritaAcaraDetailController@destroy');
  Route::get('berita-acara', 'Web\BeritaAcaraController@index'); //index
  Route::get('berita-acara/create', 'Web\BeritaAcaraController@create'); //page insert berita acara
  Route::post('berita-acara/store', 'Web\BeritaAcaraController@store'); //proses insert berita acara
  Route::get('berita-acara/{berita_acara_id}', 'Web\BeritaAcaraController@show'); //page detail berita acara
  Route::delete('/berita-acara/{id}/delete/{type}', 'Web\BeritaAcaraController@prosesDeleteImage'); //delete image
  Route::delete('berita-acara/{berita_acara_id}', 'Web\BeritaAcaraController@destroy'); //page detail berita acara
  Route::put('berita-acara/{berita_acara_id}/submit', 'Web\BeritaAcaraController@submit');
  Route::post('berita-acara/{berita_acara_id}', 'Web\BeritaAcaraController@edit');
  Route::get('berita-acara/{berita_acara_id}/bulk-template', 'Web\BeritaAcaraController@bulkTemplate'); //download template berita acara
  Route::post('berita-acara/{berita_acara_id}/upload-bulk', 'Web\BeritaAcaraController@uploadBulk'); //upload bulk berita acara
  Route::get('berita-acara/{berita_acara_id}/print', 'Web\BeritaAcaraController@export'); //proses cetak berita acara
  Route::get('berita-acara/{berita_acara_id}/print-detail', 'Web\BeritaAcaraController@exportDetail'); //proses cetak berita acara detail

  // Claim Notes
  Route::put('claim-notes/{id}/submit', 'Web\ClaimNoteController@submit');
  Route::get('claim-notes/{id}/export', 'Web\ClaimNoteController@export');
  Route::get('claim-notes/{id}/detail/{detail_id}/export', 'Web\ClaimNoteController@exportDetail');
  Route::get('claim-notes', 'Web\ClaimNoteController@index');
  Route::get('claim-notes/list-claim-notes', 'Web\ClaimNoteController@listClaimNotes'); //list datatable claim notes index
  Route::get('claim-notes/carton-box', 'Web\ClaimNoteController@listCartonBox');
  Route::get('claim-notes/unit', 'Web\ClaimNoteController@listUnit');
  Route::get('claim-notes/list-outstanding', 'Web\ClaimNoteController@listOutstanding'); //get datatable outstanding
  Route::delete('claim-notes/delete-outstanding/{id}', 'Web\ClaimNoteController@destroyOutstanding'); //delete outstanding item
  Route::delete('claim-notes/delete-multiple-outstandings', 'Web\ClaimNoteController@destroyMultipleOutstanding'); //delete outstanding item
  Route::delete('claim-notes/{id}', 'Web\ClaimNoteController@destroy'); //page detail berita acara
  Route::get('claim-notes/create-carton-box', 'Web\ClaimNoteController@createCartonBox');
  Route::get('claim-notes/create-unit', 'Web\ClaimNoteController@createUnit');
  Route::get('claim-notes/{id}', 'Web\ClaimNoteController@show'); //detail claim notes
  Route::post('claim-notes/{id}/update', 'Web\ClaimNoteController@update'); //update detail claim notes
  Route::get('claim-notes/{id}/list-claim-notes', 'Web\ClaimNoteController@listDetailClaimNotes'); //list datatable claim notes detail
  Route::get('claim-notes/{berita_acara_id}/print', 'Web\ClaimNoteController@export'); //proses cetak claim note
  Route::get('claim-notes/{berita_acara_id}/print-detail', 'Web\ClaimNoteController@exportDetail');
  Route::post('claim-notes/create', 'Web\ClaimNoteController@create');
  Route::get('claim-notes/{id}/detail',  'Web\ClaimNoteController@getDetail'); //detail claim insurance

  // Claim Insurance
  Route::get('claim-insurance/{id}/export', 'Web\ClaimInsuranceController@exportRPT');
  Route::put('claim-insurance/{id}/submit', 'Web\ClaimInsuranceController@submit');
  Route::delete('claim-insurance/outstanding/{id}', 'Web\ClaimInsuranceController@destroyOutstanding');
  Route::delete('claim-insurance/delete-multiple-outstandings', 'Web\ClaimInsuranceController@destroyMultipleOutstanding');
  Route::delete('claim-insurance/{id}', 'Web\ClaimInsuranceController@prosesDelete');
  Route::get('claim-insurance/{id}/detail/{detail_id}/export', 'Web\ClaimInsuranceController@exportDetail');
  Route::get('claim-insurance', 'Web\ClaimInsuranceController@index');
  Route::get('claim-insurance/list-claim-insurance', 'Web\ClaimInsuranceController@listClaimInsurance'); //list datatable claim insurance index
  Route::get('claim-insurance/{id}/list-claim-insurance', 'Web\ClaimInsuranceController@listDetailClaimInsurance'); //list datatable claim insurance detail
  Route::post('claim-insurance/{id}/update', 'Web\ClaimInsuranceController@update'); //update detail claim notes
  Route::post('claim-insurance/create', 'Web\ClaimInsuranceController@create');
  Route::get('claim-insurance/{id}',  'Web\ClaimInsuranceController@show'); //detail claim insurance
  Route::get('claim-insurance/{id}/detail',  'Web\ClaimInsuranceController@getDetail'); //detail claim insurance
  Route::get('claim-insurance/{berita_acara_id}/print', 'Web\ClaimInsuranceController@exportDetail'); //proses cetak claim note
  Route::get('claim-insurance/{berita_acara_id}/print-rpt', 'Web\ClaimInsuranceController@exportRPT'); //proses cetak claim note

  //summary claim note
  Route::get('summary-claim-notes',  'Web\SummaryClaimNoteController@index');
  Route::get('summary-claim-notes/{id}',  'Web\SummaryClaimNoteController@show');
  Route::put('summary-claim-notes/{id}',  'Web\SummaryClaimNoteController@update');
  Route::get('summary-claim-notes/{id}/export',  'Web\SummaryClaimNoteController@export');


  //summary claim note
  Route::get('summary-claim-insurance',  'Web\SummaryClaimInsuranceController@index');
  // Route::get('summary-claim-insurance/{id}',  'Web\SummaryClaimInsuranceController@show');
  Route::put('summary-claim-insurance/{id}',  'Web\SummaryClaimInsuranceController@update');
  Route::delete('summary-claim-insurance/{id}',  'Web\SummaryClaimInsuranceController@delete');
  Route::get('summary-claim-insurance/{id}/export',  'Web\SummaryClaimInsuranceController@export');
});
