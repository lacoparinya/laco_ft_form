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
    return view('home');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::resource('groups', 'GroupsController');
Route::resource('users', 'UsersController');
Route::resource('products', 'ProductsController');
Route::resource('shifts', 'ShiftsController');
Route::resource('units', 'UnitsController');
Route::resource('ft_masters', 'FtMastersController');
Route::resource('ft_logs', 'FtLogsController');
Route::get('/import', 'AutoImportController@test');
Route::get('/reports/daily', 'ReportsController@daily');
Route::get('/reports/range', 'ReportsController@range');
Route::post('/reports/reportAction', 'ReportsController@reportAction');
Route::get('/dashboard', 'DashboardController@home');
Route::get('/chart/{selecteddate}', 'DashboardController@datechart');
Route::get('/charttime/{selecteddate}', 'DashboardController@timechart');
