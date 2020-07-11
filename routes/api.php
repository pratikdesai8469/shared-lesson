<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::namespace('Api')->group(function () {
    Route::post('/user/login', 'UserController@login');
    Route::post('/user/register', 'UserController@register');
    Route::post('/user/verify-otp', 'UserController@verifyOtp');
    Route::post('/user/resend-otp', 'UserController@resendOtp');
    Route::post('/user/forgot-password', 'UserController@forgotPassword');
    Route::post('/user/change-password', 'UserController@changePassword');
});

Route::group(['namespace' => 'Api', 'middleware' => ['ApiAuthentication']], function () {
	Route::post('/user/edit-profile', 'UserController@editProfile');
    Route::post('/user/logout', 'UserController@logout');

    Route::get('/lession', 'LessionController@index');
	Route::post('/lession/add', 'LessionController@add');
	Route::post('/lession/edit', 'LessionController@edit');
    Route::get('/lession/view/{id}', 'LessionController@view');
    Route::get('/lession/delete/{id}', 'LessionController@delete');
});