<?php

Route::group(['middleware' => 'auth'], function () {
  Route::view('clean-concept', 'web.others.clean-concept.index');
});
