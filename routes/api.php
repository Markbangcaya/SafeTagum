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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth:api'], function () {
    Route::group(['prefix' => 'disease'], function () {
        Route::get('all', [App\Http\Controllers\API\DiseaseController::class, 'index_all']);
        Route::get('list', [App\Http\Controllers\API\DiseaseController::class, 'index']);
        Route::post('create', [App\Http\Controllers\API\DiseaseController::class, 'store']);
        Route::put('update/{id}', [App\Http\Controllers\API\DiseaseController::class, 'update']);
        Route::delete('delete/{id}', [App\Http\Controllers\API\DiseaseController::class, 'destroy']);
    });
    Route::group(['prefix' => 'barangay'], function () {
        Route::get('all', [App\Http\Controllers\API\BarangayController::class, 'index_all']);
    });
    Route::group(['prefix' => 'patient'], function () {
        Route::get('list', [App\Http\Controllers\API\PatientController::class, 'index']);
        Route::post('create', [App\Http\Controllers\API\PatientController::class, 'store']);
        Route::put('update/{id}', [App\Http\Controllers\API\PatientController::class, 'update']);
        Route::post('assessment/{id}', [App\Http\Controllers\API\PatientController::class, 'assessment']);
        Route::post('updateassessment/{id}', [App\Http\Controllers\API\PatientController::class, 'updateassessment']);
        Route::post('forecast', [App\Http\Controllers\API\PatientController::class, 'forecast']);
        Route::get('detokenized/{id}', [App\Http\Controllers\API\PatientController::class, 'detokenized']);
        Route::post('report', [App\Http\Controllers\API\PatientController::class, 'report']);
    });
    Route::group(['prefix' => 'user'], function () {
        Route::get('list', [App\Http\Controllers\API\UserController::class, 'index']);
        Route::get('show', [App\Http\Controllers\API\UserController::class, 'show']);
        Route::post('create', [App\Http\Controllers\API\UserController::class, 'store']);
        Route::put('update/{id}', [App\Http\Controllers\API\UserController::class, 'update']);
        Route::delete('delete/{id}', [App\Http\Controllers\API\UserController::class, 'destroy']);
    });
    Route::group(['prefix' => 'permission'], function () {
        Route::get('list', [App\Http\Controllers\API\PermissionController::class, 'index']);
        Route::get('all', [App\Http\Controllers\API\PermissionController::class, 'index_all']);
        Route::post('create', [App\Http\Controllers\API\PermissionController::class, 'store']);
        Route::put('update/{id}', [App\Http\Controllers\API\PermissionController::class, 'update']);
        Route::delete('delete/{id}', [App\Http\Controllers\API\PermissionController::class, 'destroy']);
    });
    Route::group(['prefix' => 'role'], function () {
        Route::get('list', [App\Http\Controllers\API\RoleController::class, 'index']);
        Route::get('all', [App\Http\Controllers\API\RoleController::class, 'index_all']);
        Route::post('create', [App\Http\Controllers\API\RoleController::class, 'store']);
        Route::put('update/{id}', [App\Http\Controllers\API\RoleController::class, 'update']);
        Route::delete('delete/{id}', [App\Http\Controllers\API\RoleController::class, 'destroy']);
    });
    Route::group(['prefix' => 'registrar'], function () {
        Route::get('list', [App\Http\Controllers\API\RegistrarController::class, 'index']);
        Route::get('all', [App\Http\Controllers\API\RegistrarController::class, 'index_all']);
        Route::post('create', [App\Http\Controllers\API\RegistrarController::class, 'store']);
        Route::put('update/{id}', [App\Http\Controllers\API\RegistrarController::class, 'update']);
        Route::delete('delete/{id}', [App\Http\Controllers\API\RegistrarController::class, 'destroy']);
    });
    Route::group(['prefix' => 'program'], function () {
        Route::get('list', [App\Http\Controllers\API\ProgramController::class, 'index']);
        Route::get('all', [App\Http\Controllers\API\ProgramController::class, 'index_all']);
        Route::post('create', [App\Http\Controllers\API\ProgramController::class, 'store']);
        Route::put('update/{id}', [App\Http\Controllers\API\ProgramController::class, 'update']);
        Route::delete('delete/{id}', [App\Http\Controllers\API\ProgramController::class, 'destroy']);
    });
});
