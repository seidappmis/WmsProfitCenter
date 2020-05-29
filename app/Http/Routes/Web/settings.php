<?php

Route::group(['middleware' => 'auth'], function () {
    // User Manager
    Route::resource('user-manager', 'Web\UserManagerController');

    // User ROles
    Route::get('user-roles/select2-roles', 'Web\UserRoleController@getSelect2Roles');
    Route::resource('user-roles', 'Web\UserRoleController');

    // Master Area
    Route::get('master-area/select2-area-only', 'Web\AreaController@getSelect2AreaOnly');
    Route::get('master-area/select2-areas', 'Web\AreaController@getSelect2Area');
    Route::resource('master-area', 'Web\AreaController');

    // Master Cabang
    Route::get('master-cabang/select2-cabang', 'Web\MasterCabangController@getSelect2Cabang');
    Route::resource('master-cabang', 'Web\MasterCabangController');

    // Master User Mobile
    Route::resource('master-user-mobile', 'Web\MasterUserMobileController');
});
