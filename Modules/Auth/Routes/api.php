<?php

use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Controllers\Api\Admin\AdminChangePasswordAController;
use Modules\Auth\Http\Controllers\Api\Admin\AdminController;
use Modules\Auth\Http\Controllers\Api\Admin\AdminProfileController;
use Modules\Auth\Http\Controllers\Api\Admin\FrontEnd\AboutController;
use Modules\Auth\Http\Controllers\Api\Admin\FrontEnd\ContactUsController;
use Modules\Auth\Http\Controllers\Api\Admin\FrontEnd\FooterController;
use Modules\Auth\Http\Controllers\Api\Admin\FrontEnd\TermsAndConditionsController;
use Modules\Auth\Http\Controllers\Api\Admin\RoleController;
use Modules\Auth\Http\Controllers\Api\Admin\SendNotificationController;
use Modules\Auth\Http\Controllers\Api\Admin\UserController;
use Modules\Auth\Http\Controllers\Api\Auth\AuthController;
use Modules\Auth\Http\Controllers\Api\Auth\ChangePasswordController;
use Modules\Auth\Http\Controllers\Api\Auth\CompanyController;
use Modules\Auth\Http\Controllers\Api\Auth\RestePasswordController;
use Modules\Auth\Http\Controllers\Api\Auth\UserProfileController;

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


Route::post('login', [AuthController::class, 'Login']);
Route::post('register', [AuthController::class, 'register']);
Route::post('deals-register', [AuthController::class, 'dealsRegister']);
Route::post('agency-register', [AuthController::class, 'agencyRegister']);
Route::post('verify', [AuthController::class, 'verify']);
Route::post('sendVerify', [AuthController::class, 'sendVerify']);
Route::post('change/password', [RestePasswordController::class, 'forgotPassword']);
Route::post('reset/password', [RestePasswordController::class, 'reset']);
Route::get('/auth/{provider}', [AuthController::class, 'redirectToProvider']);
Route::get('/auth/{provider}/callback', [AuthController::class, 'handleProviderCallback']);

/**
 * user
 */

Route::middleware(['auth:sanctum'])->group(function () {


    Route::get('logout', [UserProfileController::class, 'logout']);
    Route::get('profile', [UserProfileController::class, 'profile']);
    Route::post('update/profile', [UserProfileController::class, 'updateProfile']);
    Route::post('change-password', [ChangePasswordController::class, 'changePassword']);
    Route::delete('delete-account', [UserProfileController::class, 'deleteAccount']);
    Route::get('notification', [AuthController::class, 'notification']);
    Route::get('unreadNotification', [AuthController::class, 'unreadNotification']);
    Route::delete('deleteNotification/{id}', [AuthController::class, 'deleteNotification']);


});


/**
 * admin
 */
Route::post('Admin/Register', [AdminController::class, 'AdminRegister']);
Route::post('Admin/Login', [AdminController::class, 'AdminLogin']);

Route::middleware(['user_api'])->prefix("admin")->group(function () {
    Route::get('show-user/{id}', [UserController::class, 'show']);
    Route::apiresource('roles', RoleController::class);
    Route::apiresource('users', UserController::class);
    Route::post('update-users/{id}', [UserController::class, 'update']);
    Route::get('active-user/{id}', [UserController::class, 'activate']);
    Route::get('all-users', [UserController::class, 'index']);
    Route::get('all-deals', [UserController::class, 'allDeals']);
    Route::get('all-agency', [UserController::class, 'allAgency']);
    Route::get('Admin/profile', [AdminProfileController::class, 'AdminProfile']);
    Route::post('update/profile', [AdminProfileController::class, 'AdminUpdateProfile']);
    Route::get('logout', [AdminProfileController::class, 'Logout']);
    Route::post('send', [SendNotificationController::class, 'sendNotification']);
    Route::apiresource('about', AboutController::class);
    Route::apiresource('footer', FooterController::class,);
    Route::apiresource('contact-us', ContactUsController::class,);
    Route::apiresource('terms-and-conditions', TermsAndConditionsController::class,);
    Route::post('change-password', [ChangePasswordController::class, 'changePassword']);


});
/**
 *  FrontEnd --> Footer , ContactUs and  About
 */

Route::post('contact-us', [ContactUsController::class, 'store']);
Route::get('footer', [FooterController::class, 'index']);
Route::get('about', [AboutController::class, 'index']);


