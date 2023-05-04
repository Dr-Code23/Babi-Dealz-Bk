<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Property\Http\Controllers\Agency\ApartmentController;
use Modules\Property\Http\Controllers\Agency\HangarController;

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

Route::middleware('auth:api')->group( function () {
    // apartment routes
    Route::post('add-apartment', [ApartmentController::class, 'store']);
    Route::get('get-apartments', [ApartmentController::class, 'index']);
//    Route::get('get-apartment/{id}', [ApartmentController::class, 'show']);
    Route::post('update-apartment/{id}', [ApartmentController::class, 'update']);
    Route::delete('delete-apartment/{id}', [ApartmentController::class, 'destroy']);

    // hangar routes
    Route::post('add-hangar', [HangarController::class, 'store']);
    Route::get('get-hangars', [HangarController::class, 'index']);
    Route::get('get-hangar/{id}', [HangarController::class, 'show']);
    Route::post('update-hangar/{id}', [HangarController::class, 'update']);
    Route::delete('delete-hangar/{id}', [HangarController::class, 'destroy']);
    Route::get('get-apartment/{id}', [ApartmentController::class, 'show']);

});
