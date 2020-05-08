<?php

Route::group(['middleware' => 'auth'], function () {
    Route::view('user-manager', 'web.settings.user-manager.index');
    Route::view('user-manager/create', 'web.settings.user-manager.create');
    Route::view('user-manager/1', 'web.settings.user-manager.edit');

    Route::view('user-roles', 'web.settings.user-roles.index');
    Route::view('user-roles/create', 'web.settings.user-roles.create');
    Route::view('user-roles/1', 'web.settings.user-roles.edit');

    // Route::view('master-area', 'web.settings.master-area.index');
    // Route::view('master-area/create', 'web.settings.master-area.create');
    // Route::view('master-area/1', 'web.settings.master-area.edit');
    Route::get('master-area/select2-areas', 'Web\MasterAreaController@getSelect2Area');
    Route::resource('master-area', 'Web\MasterAreaController');

    //Route::view('master-cabang', 'web.settings.master-cabang.index');
    //Route::view('master-cabang/create', 'web.settings.master-cabang.create');
    //Route::view('master-cabang/1', 'web.settings.master-cabang.edit');
    Route::resource('master-cabang', 'Web\MasterCabangController');

    Route::view('master-user-mobile', 'web.settings.master-user-mobile.index');
    Route::view('master-user-mobile/create', 'web.settings.master-user-mobile.create');
});
