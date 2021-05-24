<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/freezem/{id}',  'ListingController@get_freeze_m_data');
Route::get('/freezemlist/{limit}',  'ListingController@get_freeze_m_list');
Route::get('/freezed/{id}',  'ListingController@get_freeze_d_data');
Route::get('/freezedlist/{limit}',  'ListingController@get_freeze_d_list');


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
