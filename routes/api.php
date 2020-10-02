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

Route::group(['prefix' => 'auth', 'as' => 'api.auth.'], function () {
    Route::post('login', [\App\Http\Controllers\API\AuthController::class, 'login'])->name('login');
    Route::post('logout', [\App\Http\Controllers\API\AuthController::class, 'logout'])->name('logout');
    Route::get('profile', [\App\Http\Controllers\API\AuthController::class, 'profile'])->name('profile');
    Route::post('refresh', [\App\Http\Controllers\API\AuthController::class, 'refresh'])->name('refresh');
});



Route::group(['as' => 'api.', 'middleware' => 'auth:api'], function () {
    Route::get('provinces', [\App\Http\Controllers\API\ProvinceController::class, 'index'])->name('provinces');
    Route::get('provinces/{province}/departments', [\App\Http\Controllers\API\DepartmentController::class, 'index'])->name('departments');
    Route::get('departments/{department}/localities', [\App\Http\Controllers\API\LocalityController::class, 'index'])->name('localities');
    Route::get('formData', \App\Http\Controllers\API\FormData::class)->name('formData'); //invokable
    Route::apiResource('users', \App\Http\Controllers\API\UserController::class);
    Route::apiResource('schools', \App\Http\Controllers\API\SchoolController::class);
    Route::apiResource('teachers', \App\Http\Controllers\API\TeacherController::class);
    Route::apiResource('schools.teaching_plant', \App\Http\Controllers\API\TeachingPlantController::class)->shallow();
    Route::get('ordenes_merito', [\App\Http\Controllers\API\OrdenMeritoController::class, 'index'])->name('ordenes_merito.index');
    Route::get('ordenes_merito/{orden_merito}', [\App\Http\Controllers\API\OrdenMeritoController::class, 'show'])->name('ordenes_merito.show');
    Route::post('ordenes_merito/upload', [\App\Http\Controllers\API\OrdenMeritoController::class, 'upload'])->name('ordenes_merito.upload');
});
