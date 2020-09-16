<?php

Route::group(['middleware' => 'auth'], function () {
  // Stock Take Schedule
  Route::put('stock-take-schedule/{sto_id}/view-detail/{id}', 'Web\StockTake\STScheduleDetailController@update');
  Route::get('stock-take-schedule/{sto_id}/view-detail/{id}/edit', 'Web\StockTake\STScheduleDetailController@edit');
  Route::put('stock-take-schedule/{sto_id}/finish', 'Web\StockTake\STScheduleController@finish');
  Route::get('stock-take-schedule/select2-schedule', 'Web\StockTake\STScheduleController@getSelect2Schedule');
  Route::resource('stock-take-schedule', 'Web\StockTake\STScheduleController');

  Route::get('stock-take-create-tag', 'Web\StockTakeCreateTagController@index');
  Route::get('stock-take-create-tag/{id}/export', 'Web\StockTakeCreateTagController@export');
  Route::get('stock-take-create-tag/select2-no-tag-1', 'Web\StockTakeCreateTagController@getSelect2NoTag1');
  Route::get('stock-take-create-tag/select2-no-tag-2', 'Web\StockTakeCreateTagController@getSelect2NoTag2');
  Route::post('stock-take-create-tag', 'Web\StockTakeCreateTagController@store');
  Route::view('stock-take-create-tag/create', 'web.stock-take.stock-take-create-tag.create');

  Route::get('stock-take-input-1', 'Web\StockTakeInput1Controller@index');
  Route::post('stock-take-input-1', 'Web\StockTakeInput1Controller@store');
  Route::delete('stock-take-input-1/{id}', 'Web\StockTakeInput1Controller@destroy');
  Route::view('stock-take-input-1/edit', 'web.stock-take.stock-take-input-1.edit');

  Route::get('stock-take-input-2', 'Web\StockTakeInput2Controller@index');
  Route::post('stock-take-input-2', 'Web\StockTakeInput2Controller@store');
  Route::delete('stock-take-input-2/{id}', 'Web\StockTakeInput2Controller@destroy');
  Route::view('stock-take-input-2/edit', 'web.stock-take.stock-take-input-2.edit');
  // Route::view('stock-take-input-2', 'web.stock-take.stock-take-input-2.index');
  // Route::view('stock-take-input-2/edit', 'web.stock-take.stock-take-input-2.edit');

  // Route::view('stock-take-quick-count', 'web.stock-take.stock-take-quick-count.index');
  Route::get('stock-take-quick-count', 'Web\StockTakeQuickCountController@index');
  Route::get('stock-take-quick-count/input-1', 'Web\StockTakeQuickCountController@getInput1');
  Route::get('stock-take-quick-count/input-2', 'Web\StockTakeQuickCountController@getInput2');
  Route::get('stock-take-quick-count/different-quantity', 'Web\StockTakeQuickCountController@getDifferentQuantity');
  Route::get('stock-take-quick-count/{id}/export', 'Web\StockTakeQuickCountController@export');


  Route::get('stock-take-compare-sap/{id}/export', 'Web\StockTakeCompareSAPController@export');
  Route::get('stock-take-compare-sap', 'Web\StockTakeCompareSAPController@index');
});
