<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register the API routes for your application as
| the routes are automatically authenticated using the API guard and
| loaded automatically by this application's RouteServiceProvider.
|
*/

Route::group([
    'middleware' => 'auth:api'
], function () {
	// User
	Route::get('users/all', 'UserController@all');
	Route::get('user/add', 'UserController@showCreateForm')->name('user.add');
	Route::get('user/{id}', 'UserController@index')->name('user.edit');
	Route::post('user', 'UserController@store')->name('user.store');
	Route::put('user/{id}', 'UserController@update')->name('user.update');
	Route::delete('user/{id}', 'UserController@destroy')->name('user.delete');
	// Permission
	Route::resource('permission', 'PermissionController');
	Route::get('/permissions/all', 'PermissionController@all');
	// Role
    Route::resource('role', 'RoleController');
    Route::get('/roles/all', 'RoleController@all');
	Route::get('/roles/{id}/rolePermissions', 'RoleController@getRolePermissions');
	// Facility Booking
	Route::get('/facility/booking/all', 'Facility\BookingController@all');
	Route::post('/facility/booking', 'Facility\BookingController@store');
	Route::put('/facility/booking/{id}', 'Facility\BookingController@update');
	Route::put('/facility/booking/{id}/restore', 'Facility\BookingController@restore');
	Route::delete('/facility/booking/{id}', 'Facility\BookingController@destroy');
	Route::delete('/facility/booking/{id}/permanent', 'Facility\BookingController@destroyPermanent');
	// Facility Resource
	Route::get('/facility/resource/all', 'Facility\ResourceController@all');
	Route::post('/facility/resource', 'Facility\ResourceController@store');
	Route::put('/facility/resource/{id}', 'Facility\ResourceController@update');
	Route::delete('/facility/resource/{id}', 'Facility\ResourceController@destroy');
	// Facility Court Booking
	Route::get('/facility/courtbookings/all', 'Facility\CourtController@all');

	// Courtbooking Settings
	Route::get('/courtbooking/booking/all', 'CourtBooking\BookingSheetController@all');
	Route::post('/courtbooking/booking', 'CourtBooking\BookingSheetController@store');
	Route::put('/courtbooking/booking/{id}', 'CourtBooking\BookingSheetController@update');
	Route::put('/courtbooking/booking/{id}/restore', 'CourtBooking\BookingSheetController@restore');
	Route::delete('/courtbooking/booking/{id}', 'CourtBooking\BookingSheetController@destroy');
	Route::delete(
		'/courtbooking/booking/{id}/permanent', 
		'CourtBooking\BookingSheetController@destroyPermanent'
	);
	// Courtcooking Resource Type
	Route::get('/courtbooking/resource-type/all', 'CourtBooking\ResourceTypeController@all');
	Route::post('/courtbooking/resource-type', 'CourtBooking\ResourceTypeController@store');
	Route::put('/courtbooking/resource-type/{id}', 'CourtBooking\ResourceTypeController@update');
	Route::delete('/courtbooking/resource-type/{id}', 'CourtBooking\ResourceTypeController@destroy');
	// Courtcooking Resource
	Route::get('/courtbooking/resource/all', 'CourtBooking\ResourceController@all');
	Route::post('/courtbooking/resource', 'CourtBooking\ResourceController@store');
	Route::put('/courtbooking/resource/{id}', 'CourtBooking\ResourceController@update');
	Route::delete('/courtbooking/resource/{id}', 'CourtBooking\ResourceController@destroy');
});

Route::post('login', 'Usercontroller@login');
