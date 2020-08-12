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

// Home
Route::get('/', 'WelcomeController@stats');

// Stats
Route::get('/stats/csvs', 'StatsController@csvs');
Route::get('/stats/users', 'StatsController@users');
Route::get('/stats/users/{user}', 'StatsController@showUser');
Route::get('/stats/company', 'StatsController@showCompany');
Route::get('/stats/orders', 'StatsController@orders');
Route::get('/stats/orders/{order}', 'StatsController@showOrder');
Route::post('/stats/company/filter', 'StatsController@filterCompany');
Route::post('/users/{user}/filter', 'StatsController@filterUser');
Route::post('/orders/{order}/filter', 'StatsController@filterOrder');

// Authentication
Auth::routes();

// Device
Route::post('/devices/inventory/export', 'DeviceController@inventoryExport');
Route::post('/devices/returns/export', 'DeviceController@returnsExport');


// ------------------------------

// Authentication Routes...
// Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
// Route::post('login', 'Auth\LoginController@login');
// Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// // Registration Routes...
// Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
// Route::post('register', 'Auth\RegisterController@register');

// // Password Reset Routes...
// Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm');
// Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
// Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');
// Route::post('password/reset', 'Auth\ResetPasswordController@reset');
