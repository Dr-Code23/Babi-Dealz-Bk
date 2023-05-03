<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Favorite\Http\Controllers\FavoriteController;

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

Route::middleware(['auth:api'])->group(function () {
    Route::get('favorites', [FavoriteController::class, 'index']);
    Route::post('favorites', [FavoriteController::class, 'store']);
    Route::get('favorites/{id}', [FavoriteController::class, 'show']);
    Route::post('unFavorite', [FavoriteController::class, 'unFavorite']);
});
