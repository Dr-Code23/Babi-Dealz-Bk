<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\ContactUS\Http\Controllers\ContactUsController;
use Modules\FrontEnd\Http\Controllers\AboutController;
use Modules\FrontEnd\Http\Controllers\FooterController;
use Modules\FrontEnd\Http\Controllers\PolicyAndPrivacyController;
use Modules\FrontEnd\Http\Controllers\TermsAndConditionsController;

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

Route::middleware('auth:api')->group(function (){
    Route::apiresource('about', AboutController::class);
    Route::apiresource('footer', FooterController::class,);
    Route::apiresource('contact-us', ContactUsController::class,);
    Route::apiresource('terms-and-conditions', TermsAndConditionsController::class,);
    Route::apiresource('policy-and-privacy', PolicyAndPrivacyController::class,);

});
