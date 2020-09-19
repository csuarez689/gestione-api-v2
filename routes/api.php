<?php

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

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function () {

    Route::post('login', [\App\Http\Controllers\API\AuthController::class, 'login']);
    // Route::get('me', 'API/AuthController@me');
    // Route::post('register', 'API/AuthController@register');
    // Route::post('logout', 'API/AuthController@logout');
    // Route::post('refresh', 'API/AuthController@refresh');
});

Route::group(['as' => 'api.'], function () {
    Route::get('schoolSectors', [\App\Http\Controllers\API\SchoolSectorController::class, 'index']);
    Route::get('schoolAmbits', [\App\Http\Controllers\API\SchoolAmbitController::class, 'index']);
    Route::get('schoolTypes', [\App\Http\Controllers\API\SchoolTypeController::class, 'index']);
    Route::get('jobStates', [\App\Http\Controllers\API\JobStateController::class, 'index']);
    Route::get('schoolLevels', [\App\Http\Controllers\API\SchoolLevelController::class, 'index']);

    Route::apiResource('users', \App\Http\Controllers\API\UserController::class);
});
