<?php

use App\Models\User;
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

Route::get('userss', function () {
    $users = User::all();
    return $users;
});

//-------------AUTH ROUTES-------------
Route::group(['prefix' => 'auth', 'as' => 'api.auth.'], function () {
    Route::post('login', [\App\Http\Controllers\API\AuthController::class, 'login'])->name('login');
    Route::post('logout', [\App\Http\Controllers\API\AuthController::class, 'logout'])->name('logout');
    Route::get('profile', [\App\Http\Controllers\API\AuthController::class, 'profile'])->name('profile');
    Route::post('refresh', [\App\Http\Controllers\API\AuthController::class, 'refresh'])->name('refresh');
});



Route::group(['as' => 'api.', 'middleware' => 'auth:api'], function () {

    //-------------LOCATION ROUTES-------------
    Route::get('provinces', [\App\Http\Controllers\API\ProvinceController::class, 'index'])->name('provinces');
    Route::get('provinces/{province}/departments', [\App\Http\Controllers\API\DepartmentController::class, 'index'])->name('departments');
    Route::get('departments/{department}/localities', [\App\Http\Controllers\API\LocalityController::class, 'index'])->name('localities');

    //-------------FORM DATA RELATED ROUTES-------------
    Route::get('formData', \App\Http\Controllers\API\FormData::class)->name('formData'); //invokable

    //-------------USERS ROUTES------------
    Route::apiResource('users', \App\Http\Controllers\API\UserController::class);

    //-------------SCHOOLS ROUTES-------------
    Route::apiResource('schools', \App\Http\Controllers\API\SchoolController::class);

    //-------------TEACHERS ROUTES-------------
    Route::apiResource('teachers', \App\Http\Controllers\API\TeacherController::class);

    //-------------TEACHING PLANT ROUTES-------------
    Route::apiResource('schools.teachingPlant', \App\Http\Controllers\API\TeachingPlantController::class)->shallow();

    //-------------ORDEN MERITOS ROUTES-------------
    Route::get('ordenesMerito', [\App\Http\Controllers\API\OrdenMeritoController::class, 'index'])->name('ordenesMerito.index');
    Route::get('ordenesMerito/{orden_merito}', [\App\Http\Controllers\API\OrdenMeritoController::class, 'show'])->name('ordenesMerito.show');
    Route::post('ordenesMerito/upload', [\App\Http\Controllers\API\OrdenMeritoController::class, 'upload'])->name('ordenesMerito.upload');

    //-------------FAILED ORDEN MERITOS ROUTES-------------
    Route::get('failedOrdenesMerito', [\App\Http\Controllers\API\FailedOrdenMeritoController::class, 'index'])->name('failedOrdenesMerito.index');
    Route::get('failedOrdenesMerito/{failedOrdenMerito}', [\App\Http\Controllers\API\FailedOrdenMeritoController::class, 'show'])->name('failedOrdenesMerito.show');
    Route::post('failedOrdenesMerito/{failedOrdenMerito}/repair', [\App\Http\Controllers\API\FailedOrdenMeritoController::class, 'repair'])->name('failedOrdenesMerito.repair');
    Route::delete('failedOrdenesMerito/{failedOrdenMerito}', [\App\Http\Controllers\API\FailedOrdenMeritoController::class, 'destroy'])->name('failedOrdenesMerito.destroy');
    Route::delete('failedOrdenesMerito', [\App\Http\Controllers\API\FailedOrdenMeritoController::class, 'truncate'])->name('failedOrdenesMerito.truncate');
});
