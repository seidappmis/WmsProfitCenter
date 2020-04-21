<?php

Route::group(['middleware' => 'auth'], function () {
  Route::view('task-notice', 'web.return.task-notice.index');
});
