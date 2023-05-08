<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Property\Http\Controllers\Agency\ApartmentController;
use Modules\Property\Http\Controllers\Agency\HangarController;
use Modules\Property\Http\Controllers\Agency\LandController;
use Modules\Property\Http\Controllers\Agency\ShopController;
use Modules\Property\Http\Controllers\Agency\VillaController;
use Modules\Property\Http\Controllers\User\PropertyController;

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
    Route::get('get-apartment/{id}', [ApartmentController::class, 'show']);
    Route::post('update-apartment/{id}', [ApartmentController::class, 'update']);
    Route::delete('delete-apartment/{id}', [ApartmentController::class, 'destroy']);

    // hangar routes
    Route::post('add-hangar', [HangarController::class, 'store']);
    Route::get('get-hangars', [HangarController::class, 'index']);
    Route::get('get-hangar/{id}', [HangarController::class, 'show']);
    Route::post('update-hangar/{id}', [HangarController::class, 'update']);
    Route::delete('delete-hangar/{id}', [HangarController::class, 'destroy']);

    // land routes
    Route::post('add-land', [LandController::class, 'store']);
    Route::get('get-lands', [LandController::class, 'index']);
    Route::get('get-land/{id}', [LandController::class, 'show']);
    Route::post('update-land/{id}', [LandController::class, 'update']);
    Route::delete('delete-land/{id}', [LandController::class, 'destroy']);

    // villa routes
    Route::post('add-villa', [VillaController::class, 'store']);
    Route::get('get-villas', [VillaController::class, 'index']);
    Route::get('get-villa/{id}', [VillaController::class, 'show']);
    Route::post('update-villa/{id}', [VillaController::class, 'update']);
    Route::delete('delete-villa/{id}', [VillaController::class, 'destroy']);

    // shop routes
    Route::post('add-shop', [ShopController::class, 'store']);
    Route::get('get-shops', [ShopController::class, 'index']);
    Route::get('get-shop/{id}', [ShopController::class, 'show']);
    Route::post('update-shop/{id}', [ShopController::class, 'update']);
    Route::delete('delete-shop/{id}', [ShopController::class, 'destroy']);

});


Route::middleware('auth:api')->prefix("admin")->group( function () {
    Route::get('get-apartments', [\Modules\Property\Http\Controllers\Admin\PropertyController::class, 'indexApartment']);
    Route::get('get-lands', [\Modules\Property\Http\Controllers\Admin\PropertyController::class, 'indexLand']);
    Route::get('get-shops', [\Modules\Property\Http\Controllers\Admin\PropertyController::class, 'indexShop']);
    Route::get('get-hangars', [\Modules\Property\Http\Controllers\Admin\PropertyController::class, 'indexHangar']);
    Route::get('get-villas', [\Modules\Property\Http\Controllers\Admin\PropertyController::class, 'indexVilla']);
    Route::get('get-apartment/{id}', [\Modules\Property\Http\Controllers\Admin\PropertyController::class, 'showApartment']);
    Route::get('get-shop/{id}', [\Modules\Property\Http\Controllers\Admin\PropertyController::class, 'showShop']);
    Route::get('get-hangar/{id}', [\Modules\Property\Http\Controllers\Admin\PropertyController::class, 'showHangar']);
    Route::get('get-villa/{id}', [\Modules\Property\Http\Controllers\Admin\PropertyController::class, 'showVilla']);
    Route::get('get-land/{id}', [\Modules\Property\Http\Controllers\Admin\PropertyController::class, 'showLand']);

});


Route::middleware('auth:api')->prefix("customer")->group( function () {
    Route::get('get-propertys', [PropertyController::class, 'index']);
    Route::get('get-apartment/{id}', [PropertyController::class, 'showApartment']);
    Route::get('get-shop/{id}', [PropertyController::class, 'showShop']);
    Route::get('get-hangar/{id}', [PropertyController::class, 'showHangar']);
    Route::get('get-villa/{id}', [PropertyController::class, 'showVilla']);
    Route::get('get-land/{id}', [PropertyController::class, 'showLand']);
});
