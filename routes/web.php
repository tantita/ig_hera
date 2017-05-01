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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::get('admin', 'Admin\AdminController@index');
Route::get('admin/give-role-permissions', 'Admin\AdminController@getGiveRolePermissions');
Route::post('admin/give-role-permissions', 'Admin\AdminController@postGiveRolePermissions');
Route::resource('admin/roles', 'Admin\RolesController');
Route::resource('admin/permissions', 'Admin\PermissionsController');
Route::resource('admin/users', 'Admin\UsersController');
Route::get('admin/generator', ['uses' => '\Appzcoder\LaravelAdmin\Controllers\ProcessController@getGenerator']);
Route::post('admin/generator', ['uses' => '\Appzcoder\LaravelAdmin\Controllers\ProcessController@postGenerator']);

Route::post('a/accounts/upload', 'AccountsController@upload');
Route::resource('a/accounts', 'AccountsController');
Route::get('a/accounts/{id}/download', 'AccountsController@download');


Route::get('a/settings', 'SettingsController@index');
Route::get('a/settings/edit', 'SettingsController@edit');
Route::patch('a/settings/edit', 'SettingsController@update');
// Route::resource('a/settings', 'SettingsController');
Route::resource('a/bios', 'BiosController');