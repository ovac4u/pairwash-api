<?php
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
|--------------------------------------------------------------------------
| User Authentication Routes
|--------------------------------------------------------------------------
 */
Route::group(['namespace' => 'Auth'], function () {

    Route::post('login', 'LoginController@login');

    Route::post('register', 'RegisterController@register');

    Route::post('logout', 'LoginController@logout')

        ->middleware('auth:api')

        ->name('api-logout');
});
/**
|--------------------------------------------------------------------------
| User Authenticated Routes
|--------------------------------------------------------------------------
 */
Route::group(['middleware' => 'auth:api'], function () {

    Route::get('user', function () {

        return responder()->success(['user' => request()->user()]);
    });
});
