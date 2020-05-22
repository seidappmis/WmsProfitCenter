<?php

Route::group(['middleware' => 'auth'], function () {
    // Route::view('user-manager', 'web.settings.user-manager.index');
    // Route::view('user-manager/create', 'web.settings.user-manager.create');
    // Route::view('user-manager/1', 'web.settings.user-manager.edit');
    Route::resource('user-manager', 'Web\UserManagerController');

    // Route::view('user-roles', 'web.settings.user-roles.index');
    // Route::view('user-roles/create', 'web.settings.user-roles.create');
    // Route::view('user-roles/1', 'web.settings.user-roles.edit');
    Route::get('user-roles/select2-roles', 'Web\UserRoleController@getSelect2Roles');
    Route::resource('user-roles', 'Web\UserRoleController');

    // Route::view('master-area', 'web.settings.master-area.index');
    // Route::view('master-area/create', 'web.settings.master-area.create');
    // Route::view('master-area/1', 'web.settings.master-area.edit');
    Route::get('master-area/select2-area-only', 'Web\AreaController@getSelect2AreaOnly');
    Route::get('master-area/select2-areas', 'Web\AreaController@getSelect2Area');
    Route::resource('master-area', 'Web\AreaController');

    //Route::view('master-cabang', 'web.settings.master-cabang.index');
    //Route::view('master-cabang/create', 'web.settings.master-cabang.create');
    //Route::view('master-cabang/1', 'web.settings.master-cabang.edit');
    Route::get('master-cabang/select2-region', 'Web\MasterCabangController@getSelect2Region');
    Route::get('master-cabang/select2-cabang', 'Web\MasterCabangController@getSelect2Cabang');
    Route::resource('master-cabang', 'Web\MasterCabangController');

    // Route::view('master-user-mobile', 'web.settings.master-user-mobile.index');
    // Route::view('master-user-mobile/create', 'web.settings.master-user-mobile.create');
    Route::resource('master-user-mobile', 'Web\MasterUserMobileController');
});
