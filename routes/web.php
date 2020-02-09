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

Route::any('/admin', 'AdminController@index');
Route::any('/admin/login', 'AdminController@index');
Route::any('/admin/users', 'AdminController@index');
Route::any('/admin/facility', 'AdminController@index');
Route::any('/admin/facility/bookings', 'AdminController@index');
Route::any('/admin/facility/resources', 'AdminController@index');
Route::any('/admin/roles', 'AdminController@index');
Route::any('/admin/permissions', 'AdminController@index');
Route::any('/courtbooking/courts', 'AdminController@index');
Route::any('/courtbooking/resources', 'AdminController@index');
Route::any('/settings/profile', 'AdminController@index');
Route::any('/settings/subscriptions', 'AdminController@index');
Route::any('/settings/orders', 'AdminController@index');
Route::any('/settings/invoices', 'AdminController@index');

Route::get('check/booking', 'Facility\BookingController@index');

// Route::get('/admin', function(){
// 	return view('app');
// });

// Route::group(['prefix' => 'courtbooking'], function () {
//     Route::get('/courts/{date?}', 'SchedulingController@viewSheet')->name('booking.sheet');
//     Route::get('/resources', 'SchedulingController@viewResourceSheet');
//     Route::resource('bookings', 'BookingsController');
//     Route::post('bookcourt', ['as' => 'bookcourt', 'uses'=> 'SchedulingController@makebooking']);
//     Route::post('joingroup', ['as' => 'joingroup', 'uses'=> 'SchedulingController@joingroup']);
//     Route::get('bookings/{id}/edit', 'BookingsController@edit');
// });