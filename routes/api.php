<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

Route::post('user/password-reset-email', 'App\Http\Controllers\Api\UsersController@passwordResetEmail')->name('forget-password-email');
Route::post('user-reset-password', 'App\Http\Controllers\Api\UsersController@updateForgetPassword')->name('forget-password');
Route::get('users/expire-subscription', 'App\Http\Controllers\Api\UsersController@expireSubscription');
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('users/send-email', 'App\Http\Controllers\Api\UsersController@sendEMails');
Route::post('client/search', 'App\Http\Controllers\Api\ClientsController@searchBy');
// Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
Route::get('email/verify/{id}/{uid}', 'App\Http\Controllers\Api\UsersController@emailVerified');
Auth::routes(['verify' => true]);
Route::apiResource('user', 'App\Http\Controllers\Api\UsersController');
Route::apiResource('freelancer', 'App\Http\Controllers\Api\FreelancersController');
Route::apiResource('client', 'App\Http\Controllers\Api\ClientsController');
Route::apiResource('service', 'App\Http\Controllers\Api\ServicesController');
Route::post('service/{id}', 'App\Http\Controllers\Api\ServicesController@update');
Route::post('client/{id}', 'App\Http\Controllers\Api\ClientsController@update');
Route::post('freelancer/{id}', 'App\Http\Controllers\Api\FreelancersController@update');
// Route::apiResource('user_subscribe_client', 'App\Http\Controllers\Api\SubscribedUserClientsController');
// Route::apiResource('apply_job', 'App\Http\Controllers\Api\UserAppliedJobController');

Route::apiResource('contact_us', 'App\Http\Controllers\Api\ContactUsController');

Route::post('clients/client-referal', 'App\Http\Controllers\Api\ClientsController@findReferal');

Route::post('freelancers/search', 'App\Http\Controllers\Api\FreelancersController@searchBy');
Route::post('services/search', 'App\Http\Controllers\Api\ServicesController@searchBy');
Route::get('users/setup-intent', 'App\Http\Controllers\Api\UsersController@getSetupIntent');
Route::post('users/payments', 'App\Http\Controllers\Api\UsersController@postPaymentMethods');
Route::post('users/remove-payment', 'App\Http\Controllers\Api\UsersController@removePaymentMethod');
Route::put('users/subscription', 'App\Http\Controllers\Api\UsersController@updateSubscription');
Route::get('users/payment-methods', 'App\Http\Controllers\Api\UsersController@getPaymentMethods');
// for handling stripe



// getting admin users for admin dashboard

Route::get('users/admins', 'App\Http\Controllers\Api\UsersController@getAdminUsers');
Route::apiResource('sales_methods', 'App\Http\Controllers\Api\SalesMethodsController');
Route::apiResource('industries', 'App\Http\Controllers\Api\IndustriesController');
Route::apiResource('social_links', 'App\Http\Controllers\Api\SocialLinksController');

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('cancel_subscription', 'App\Http\Controllers\Api\CancelSubscriptionController');
    Route::apiResource('user_subscribe_client', 'App\Http\Controllers\Api\SubscribedUserClientsController');
    Route::apiResource('apply_job', 'App\Http\Controllers\Api\UserAppliedJobController');
  
    
    Route::post('clients/payments', 'App\Http\Controllers\Api\ClientsController@showMyPayments');
   
    
   
    Route::put('users/update-password/{id?}', 'App\Http\Controllers\Api\UsersController@updatePassword');
    Route::post('services/status', 'App\Http\Controllers\Api\ServicesController@changeStatus');
});

