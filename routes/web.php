<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'WelcomeController@show');

Route::get('/home', 'HomeController@show');

Route::group(['domain' => 'facility.playercoach.com'], function(){
	Route::get('register', 'Facility\AuthController@showTenantRegisterForm');
	Route::post('register', 'Facility\AuthController@register');
});

Route::get('users', 'UserController@index')->name('users');
Route::get('user/add', 'UserController@showCreateForm')->name('user.add');
Route::get('user/{id}', 'UserController@index')->name('user.edit');
Route::post('user', 'UserController@store')->name('user.store');
Route::put('user/{id}', 'UserController@update')->name('user.update');
Route::delete('user/{id}', 'UserController@destroy')->name('user.delete');

Route::get('users/all', 'UserController@all');

Route::resource('role', 'RoleController');
Route::resource('permission', 'PermissionController');

Route::get('/permissions/all', 'PermissionController@all');
Route::get('/roles/all', 'RoleController@all');
Route::get('/roles/{id}/rolePermissions', 'RoleController@getRolePermissions');

// Route::get('users', 'UserController@index')->name('users');
// Route::get('user/add', 'UserController@showCreateForm')->name('user.add');
// Route::get('user/{id}', 'UserController@index')->name('user.edit');
// Route::post('user/create', 'UserController@index')->name('user.create');
// Route::put('user/{id}', 'UserController@index')->name('user.update');
// Route::delete('user/{id}', 'UserController@index')->name('user.delete');

// Route::get('users', 'UserController@index')->name('users');
// Route::get('user/add', 'UserController@showCreateForm')->name('user.add');
// Route::get('user/{id}', 'UserController@index')->name('user.edit');
// Route::post('user/create', 'UserController@index')->name('user.create');
// Route::put('user/{id}', 'UserController@index')->name('user.update');
// Route::delete('user/{id}', 'UserController@index')->name('user.delete');

// Route::group(['prefix' => 'courtbooking'], function () {
//     Route::get('/courts/{date?}', 'SchedulingController@viewSheet')->name('booking.sheet');
//     Route::get('/resources', 'SchedulingController@viewResourceSheet');
//     Route::resource('bookings', 'BookingsController');
//     Route::post('bookcourt', ['as' => 'bookcourt', 'uses'=> 'SchedulingController@makebooking']);
//     Route::post('joingroup', ['as' => 'joingroup', 'uses'=> 'SchedulingController@joingroup']);
//     Route::get('bookings/{id}/edit', 'BookingsController@edit');
// });