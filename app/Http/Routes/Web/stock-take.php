<?php

Route::group(['middleware' => 'auth'], function () {
  Route::view('stock-take-schedule', 'web.stock-take.stock-take-schedule.index');
  Route::view('stock-take-create-tag', 'web.stock-take.stock-take-create-tag.index');
});
