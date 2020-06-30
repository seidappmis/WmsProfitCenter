<?php

Route::group(['middleware' => 'auth'], function () {
  // Stock Take Schedule
  Route::put('stock-take-schedule/{sto_id}/view-detail/{id}', 'Web\StockTake\STScheduleDetailController@update');
  Route::get('stock-take-schedule/{sto_id}/view-detail/{id}/edit', 'Web\StockTake\STScheduleDetailController@edit');
  Route::resource('stock-take-schedule', 'Web\StockTake\STScheduleController');
  Route::put('stock-take-schedule/{sto_id}/finish', 'Web\StockTake\STScheduleController@finish');

  Route::view('stock-take-create-tag', 'web.stock-take.stock-take-create-tag.index');
  Route::view('stock-take-create-tag/create', 'web.stock-take.stock-take-create-tag.create');

  Route::view('stock-take-input-1', 'web.stock-take.stock-take-input-1.index');
  Route::view('stock-take-input-1/edit', 'web.stock-take.stock-take-input-1.edit');

  Route::view('stock-take-input-2', 'web.stock-take.stock-take-input-2.index');
  Route::view('stock-take-input-2/edit', 'web.stock-take.stock-take-input-2.edit');

  Route::view('stock-take-quick-count', 'web.stock-take.stock-take-quick-count.index');
  Route::view('stock-take-compare-sap', 'web.stock-take.stock-take-compare-sap.index');
});
