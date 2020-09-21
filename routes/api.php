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
    Route::get('provinces', [\App\Http\Controllers\API\ProvinceController::class, 'index'])->name('provinces');
    Route::get('provinces/{province}/departments', [\App\Http\Controllers\API\DepartmentController::class, 'index'])->name('departments');
    Route::get('departments/{department}/localities', [\App\Http\Controllers\API\LocalityController::class, 'index'])->name('localities');
    Route::get('formData', \App\Http\Controllers\API\FormData::class);
    Route::apiResource('users', \App\Http\Controllers\API\UserController::class);
    Route::apiResource('schools', \App\Http\Controllers\API\SchoolController::class);
});
