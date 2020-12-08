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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
// Route::post('me', 'APIAuth\AuthController@me')->middleware('verified');
// Route::group(['middleware' => ['role:super-admin']], function () {
//     //
// });

Route::group(['prefix' => 'auth', 'middleware' => 'api'], function ($router) {
    Route::post('register', 'APIAuth\RegisterController@registerUser');
    Route::post('login', 'APIAuth\AuthController@login')->name('login');
    Route::post('logout', 'APIAuth\AuthController@logout');
    Route::post('password/forget', 'APIAuth\ForgotController@sendResetLinkEmail');
    Route::post('password/reset', 'APIAuth\ResetController@reset');
    Route::post('refresh', 'APIAuth\AuthController@refresh');
    Route::post('me', 'APIAuth\AuthController@me');
    Route::post('resend', 'APIAuth\VerificationController@resend');
    Route::post('verify', 'APIAuth\VerificationController@verify');
});
// Route::group(['prefix' => 'auth', 'middleware' => 'api'], function ($router) {
// });