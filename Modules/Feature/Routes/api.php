<?php

use Illuminate\Http\Request;
//use Modules\Feature\Http\Controllers\FeatureController;
use Modules\Feature\Http\Controllers\Api\User\FeatureController;



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

//Route::middleware('auth:api')->get('/feature', function (Request $request) {
//    return $request->user();
//});

Route::post('add-feature', [FeatureController::class, 'store']);
Route::get('get-feature', [FeatureController::class, 'index']);
Route::get('features/{id}', [FeatureController::class, 'show']);
Route::post('edit-feature/{id}', [FeatureController::class, 'update']);
Route::delete('delete-feature/{id}', [FeatureController::class, 'destroy']);
