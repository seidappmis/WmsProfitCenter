<?php

Route::group(['middleware' => 'auth'], function () {
  Route::view('user-manager', 'web.settings.user-manager.index');
  Route::view('user-roles', 'web.settings.user-roles.index');
  Route::view('master-area', 'web.settings.master-area.index');
  Route::view('master-cabang', 'web.settings.master-cabang.index');
  Route::view('master-user-mobile', 'web.settings.master-user-mobile.index');
});
