<?php

Route::group(['middleware' => 'auth'], function () {
  Route::view('berita-acara', 'web.claim.berita-acara.index');
  Route::view('berita-acara/create', 'web.claim.berita-acara.create');
  Route::view('berita-acara/{id}', 'web.claim.berita-acara.view');

  Route::view('claim-notes', 'web.claim.claim-notes.index');
  Route::view('claim-notes/create', 'web.claim.claim-notes.create');
  Route::view('claim-notes/{id}', 'web.claim.claim-notes.view');

  Route::view('claim-insurance', 'web.claim.claim-insurance.index');
  Route::view('claim-insurance/create', 'web.claim.claim-insurance.create');
});
