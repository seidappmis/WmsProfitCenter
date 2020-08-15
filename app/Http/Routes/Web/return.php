<?php

Route::group(['middleware' => 'auth'], function () {
  Route::view('task-notice', 'web.return.task-notice.index');
  Route::get('task-notice/{id}/export-st', 'Web\TaskNoticeController@exportSt');
  Route::get('task-notice/{id}/export-do-return', 'Web\TaskNoticeController@exportDoReturn');
});
