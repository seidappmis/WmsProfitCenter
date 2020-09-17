<?php

Route::group(['middleware' => 'auth'], function () {
  Route::get('clean-concept', 'Web\CleanConceptController@index');
  Route::delete('clean-concept', 'Web\CleanConceptController@destroy');
  Route::delete('clean-concept/multi-delete-selected-item', 'Web\CleanConceptController@destroySelectedItem');
});
