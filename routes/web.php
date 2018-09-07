<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::middleware('auth')->group(
    function () {
        Route::get(
            '/', function () {
                return view('home');
            }
        );
        Route::get('/welcome', 'WelcomeController@index')->name('welcome');
        // 个人信息
        Route::get('my', 'MyController@index')->name('my');
        Route::post('my/update', 'MyController@update')->name('my.update');

        // 用户管理
        Route::resource('user', 'UserController')->middleware('permission:用户管理')->names(
            [
                'index' => 'user',
                'create' => 'user.create'
            ]
        );
        Route::post('user/create', 'UserController@create')->middleware('permission:用户管理')->name('user.create');
        Route::post('user/{id}/edit', 'UserController@edit')->middleware('permission:用户管理')->name('user.edit');
        // 权限管理
        Route::resource('permission', 'PermissionController')->middleware('permission:用户管理')->names(
            [
                'index' => 'permission',
            ]
        );
        Route::resource('role', 'RoleController')->middleware('permission:用户管理')->names(
            [
                'index' => 'role',
            ]
        );
        Route::post('role/create', 'RoleController@create')->middleware('permission:用户管理')->name('role.create');
        Route::post('role/{id}/edit', 'RoleController@edit')->middleware('permission:用户管理')->name('role.edit');

        Route::post('permission/create', 'PermissionController@create')->middleware('permission:用户管理')->name('permission.create');
        Route::post('permission/{id}/edit', 'PermissionController@edit')->middleware('permission:用户管理')->name('permission.edit');

        Route::get('client/export', 'ClientController@export')->middleware('permission:批量导出客户')->name('client.export');
        Route::get('client/import', 'ClientController@import')->middleware('permission:批量导入客户')->name('client.import');
        Route::post('client/import/post', 'ClientController@postImport')->name('client.import.post');
        // 客户管理
        Route::resource('client', 'ClientController')->middleware('permission:查看客户')->names(
            [
                'index' => 'client',
                'store' => 'client.store'
            ]
        ); 

        // 客户追踪
        Route::any('trace/create', 'TraceController@create')->middleware('permission:追踪客户')->name('trace.create');
        
        // 系统设置
        Route::resource('setting', 'SettingController')->middleware('permission:系统设置')->names(
            [
                'index' => 'setting',
                'update' => 'setting.update'
            ]
        );

        Route::get('system/log', 'ActivityController@index')->middleware('permission:系统日志')->name('system.log');

        Route::get('report', 'ReportController@index')->middleware('permission:查看报表')->name('report');
    }
);

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

