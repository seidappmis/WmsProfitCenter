<?php

Route::group(['middleware' => 'auth'], function () {
  Route::view('stock-take-schedule', 'web.stock-take.stock-take-schedule.index');
});
