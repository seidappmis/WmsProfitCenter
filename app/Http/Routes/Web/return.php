<?php

Route::group(['middleware' => 'auth'], function () {
  Route::get('task-notice', 'Web\TaskNoticeController@index');
  Route::put('task-notice', 'Web\TaskNoticeController@update');
  Route::post('task-notice/actual', 'Web\TaskNoticeController@storeActual');
  Route::get('task-notice/actual', 'Web\TaskNoticeController@getActual');
  Route::get('task-notice/{id}', 'Web\TaskNoticeController@show');
  Route::get('task-notice/{id}/export-st', 'Web\TaskNoticeController@exportSt');
  Route::get('task-notice/{id}/export-do-return', 'Web\TaskNoticeController@exportDoReturn');
});
