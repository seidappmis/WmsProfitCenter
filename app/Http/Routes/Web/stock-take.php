<?php

Route::group(['middleware' => 'auth'], function () {
  Route::view('stock-take-schedule', 'web.stock-take.stock-take-schedule.index');
  Route::view('stock-take-schedule/create', 'web.stock-take.stock-take-schedule.create');
  Route::view('stock-take-schedule/detail', 'web.stock-take.stock-take-schedule.detail');
  Route::view('stock-take-schedule/edit', 'web.stock-take.stock-take-schedule.edit');

  Route::view('stock-take-create-tag', 'web.stock-take.stock-take-create-tag.index');
  Route::view('stock-take-create-tag/create', 'web.stock-take.stock-take-create-tag.create');

  Route::view('stock-take-input-1', 'web.stock-take.stock-take-input-1.index');
  Route::view('stock-take-input-2', 'web.stock-take.stock-take-input-2.index');
  Route::view('stock-take-quick-count', 'web.stock-take.stock-take-quick-count.index');
  Route::view('stock-take-compare-sap', 'web.stock-take.stock-take-compare-sap.index');
});
