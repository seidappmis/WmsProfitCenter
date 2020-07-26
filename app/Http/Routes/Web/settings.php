<?php

Route::group(['middleware' => 'auth'], function () {
  // User Manager
  Route::post('user-manager/{id}/grant-cabang', 'Web\UserManagerController@grantCabang');
  Route::delete('user-manager/{id}/grant-cabang/{kode_cabang_grant}', 'Web\UserManagerController@destroyGrantCabang');
  Route::resource('user-manager', 'Web\UserManagerController');

  // User ROles
  Route::get('user-roles/select2-roles', 'Web\UserRoleController@getSelect2Roles');
  Route::resource('user-roles', 'Web\UserRoleController');

  // Master Area
  Route::get('master-area/select2-area-only', 'Web\AreaController@getSelect2AreaOnly');
  Route::get('master-area/select2-areas', 'Web\AreaController@getSelect2Area');
  Route::get('master-area/select2-areas-all', 'Web\AreaController@getSelect2AreaAll');
  Route::get('master-area/select2-code-area', 'Web\AreaController@getSelect2AreaCode');
  Route::resource('master-area', 'Web\AreaController');

  // Master Cabang
  Route::get('master-cabang/select2-cabang-only', 'Web\MasterCabangController@getSelect2CabangOnly'); // Option: PT. SEID HQ JKT
  Route::get('master-cabang/select2-all-cabang', 'Web\MasterCabangController@getSelect2AllCabang'); // Option: HYP-PT. SEID HQ JKT
  Route::get('master-cabang/select2-cabang', 'Web\MasterCabangController@getSelect2Cabang'); // Option: HYP-PT. SEID HQ JKT
  Route::get('master-cabang/select2-branch', 'Web\MasterCabangController@getSelect2Branch'); // Option: [JF] PT. SEID CAB. JAKARTA (Bukan HQ)
  Route::resource('master-cabang', 'Web\MasterCabangController');

  // Master User Mobile
  Route::resource('master-user-mobile', 'Web\MasterUserMobileController');
});
