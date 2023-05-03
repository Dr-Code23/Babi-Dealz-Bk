<?php

use Illuminate\Http\Request;
use Modules\Property\Http\Controllers\Agency\ApartmentController;

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

Route::middleware('auth:api')->get('/property', function (Request $request) {
    return $request->user();
});

Route::post('add-apartment', [ApartmentController::class, 'store']);