<?php

use Illuminate\Support\Facades\Route;
use Modules\ContactUS\Http\Controllers\ContactUsController;

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
Route::controller(ContactUsController::class)->middleware('auth:api')->group(function () {
    Route::post('/contact/agency','contactAgency');
    Route::post('/contact/deals','contactDeals');
    Route::post('/contact/customer-support','contactCustomerSupport');
    Route::get('/messages/agency', 'allMessageAgency');
    Route::get('/messages/deals', 'allMessageDeals');
    Route::get('/messages/customer-support','allMessageCustomer');
    Route::get('/message/{id}','show');
    Route::delete('/message/{id}','destroy');
});
