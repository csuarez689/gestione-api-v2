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

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function () {
    Route::post('login', [\App\Http\Controllers\API\AuthController::class, 'login']);
    Route::post('logout', [\App\Http\Controllers\API\AuthController::class, 'logout']);
    Route::get('profile', [\App\Http\Controllers\API\AuthController::class, 'profile']);
    Route::post('refresh', [\App\Http\Controllers\API\AuthController::class, 'refresh']);
});

Route::group(['as' => 'api.', 'middleware' => 'auth:api'], function () {
    Route::get('provinces', [\App\Http\Controllers\API\ProvinceController::class, 'index'])->name('provinces');
    Route::get('provinces/{province}/departments', [\App\Http\Controllers\API\DepartmentController::class, 'index'])->name('departments');
    Route::get('departments/{department}/localities', [\App\Http\Controllers\API\LocalityController::class, 'index'])->name('localities');
    Route::get('formData', \App\Http\Controllers\API\FormData::class); //invokable
    Route::apiResource('users', \App\Http\Controllers\API\UserController::class);
    Route::apiResource('schools', \App\Http\Controllers\API\SchoolController::class);
    Route::apiResource('teachers', \App\Http\Controllers\API\TeacherController::class);
});
