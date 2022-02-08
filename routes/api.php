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

Route::group(['namespace'=>'Api'], function(){
        #Client
        Route::any('register','AuthController@register');
        Route::any('login','AuthController@login');
        Route::any('profile','AuthController@profile');
        Route::any('activeAccount','AuthController@activeAccount');
        Route::any('logout','AuthController@logout');
        Route::any('resendCode','AuthController@resendCode');
        Route::any('forgetPassword','AuthController@forgetPassword');
        Route::any('resetPassword','AuthController@resetPassword');
        Route::any('updateUser','AuthController@updateUser');
        Route::any('showUser','AuthController@showUser');


    #Resturant
    Route::any('registerResturant','AuthController@registerResturant');
    Route::any('loginResturant','AuthController@loginResturant');
    Route::any('profileResturant','AuthController@profileResturant');
    Route::any('logoutResturant','AuthController@logoutResturant');
    Route::any('activeAccountResturant','AuthController@activeAccountResturant');
    Route::any('resendCodeResturant','AuthController@resendCodeResturant');
    Route::any('forgetPasswordResturant','AuthController@forgetPasswordResturant');
    Route::any('resetPasswordResturant','AuthController@resetPasswordResturant');
    Route::any('updateUserResturant','AuthController@updateUserResturant');
    Route::any('showUserResturant','AuthController@showUserResturant');

    #common
    Route::any('cities', 'ApiController@cities');
    Route::any('neighborhoods', 'ApiController@neighborhoods');
    Route::any('categories', 'ApiController@categories');
    Route::any('storeService', 'ApiController@storeService');
    Route::any('updateService', 'ApiController@updateService');
    Route::any('deleteService', 'ApiController@deleteService');
    Route::any('showService', 'ApiController@showService');
    Route::any('showAllServices', 'ApiController@showAllServices');
    Route::any('home', 'ApiController@home');
    Route::any('contact', 'ApiController@contact');
    Route::any('showAllResturants', 'ApiController@showAllResturants');
    Route::any('showResturant', 'ApiController@showResturant');
    Route::any('Offers', 'ApiController@Offers');
    Route::any('showOffer', 'ApiController@showOffer');
    Route::any('rateResturant', 'ApiController@rateResturant');
    Route::any('addToCart', 'ApiController@addToCart');
    Route::any('updateToCart', 'ApiController@updateToCart');
    Route::any('showCart', 'ApiController@showCart');

    Route::any('report', 'ApiController@report');


    Route::group(['prefix'=> 'client'],function (){
        Route::group(['middleware'=> 'auth:client'],function (){

        });
    });

});
