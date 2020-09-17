<?php

Route::group(['middleware' => 'auth'], function () {
  Route::get('task-notice', 'Web\TaskNoticeController@index');
  Route::post('task-notice', 'Web\TaskNoticeController@store');
  Route::put('task-notice', 'Web\TaskNoticeController@update');
  Route::delete('task-notice', 'Web\TaskNoticeController@destroy');
  Route::delete('task-notice/delete-actual', 'Web\TaskNoticeController@destroyActual');
  Route::post('task-notice/actual', 'Web\TaskNoticeController@storeActual');
  Route::put('task-notice/actual', 'Web\TaskNoticeController@updateActual');
  Route::get('task-notice/actual', 'Web\TaskNoticeController@getActual');
  Route::get('task-notice/{id}', 'Web\TaskNoticeController@show');
  Route::get('task-notice/{id}/export-st', 'Web\TaskNoticeController@exportSt');
  Route::get('task-notice/{id}/export-do-return', 'Web\TaskNoticeController@exportDoReturn');
});
