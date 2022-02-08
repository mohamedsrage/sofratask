<?php

use App\Http\Controllers\Backend\BackendController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\CityController;
use App\Http\Controllers\Backend\CountryController;
use App\Http\Controllers\Backend\CustomerAddressController;
use App\Http\Controllers\Backend\CustomerController;
use App\Http\Controllers\Backend\NeighborhoodController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\ProductCouponController;
use App\Http\Controllers\Backend\ProductReviewController;
use App\Http\Controllers\Backend\ShippingCompanyController;
use App\Http\Controllers\Backend\StateController;
use App\Http\Controllers\Backend\SupervisorController;
use App\Http\Controllers\Backend\TagController;
use App\Models\ProductReview;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/






Auth::routes(['verify => ture']);

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function(){
    Route::get('/login', [BackendController::class, 'login'])->name('login');
    Route::post('/post-login', [BackendController::class, 'post_login'])->name('post-login');
    Route::get('/forgot-password', [BackendController::class, 'forgot_password'])->name('forgot_password');

    Route::group(['Middleware' => ['roles' , 'role:admin|suppervisor']], function(){
        Route::get('/', [BackendController::class, 'index'])->name('index_route');
        Route::get('/index', [BackendController::class, 'index'])->name('index');
        Route::get('/account_settings', [BackendController::class, 'account_settings'])->name('account_settings');
        Route::post('/admin/remove-image', [BackendController::class, 'remove_image'])->name('remove_image');
        Route::patch('/account_settings', [BackendController::class, 'update_account_settings'])->name('update_account_settings');


        Route::post('/admin/remove-image', [Backend\BackendController::class, 'remove_image'])->name('remove_image');
        Route::resource('categories', CategoryController::class);
        Route::resource('products', ProductController::class);
        Route::resource('tags', TagController::class);
        Route::resource('product_coupons', ProductCouponController::class);
        Route::resource('product_reviews', ProductReviewController::class);
        Route::resource('customers', CustomerController::class);
        Route::resource('supervisors', SupervisorController::class);
        Route::resource('countries', CountryController::class);
        Route::resource('states', StateController::class);
        Route::get('states/get_states', [StateController::class, 'get_states'])->name('states.get_states');
        Route::post('show_states', [StateController::class, 'show_states'])->name('show_states');
        // Route::post('show_states', 'StateController@show_states')->name('show_states');
        Route::resource('cities', CityController::class);
        Route::resource('neighborhoods', NeighborhoodController::class);
        // Route::resource('cities/get_cities', [CityController::class, '.get_cities'])->name('cities.get_cities');
        Route::resource('customer_addresses', CustomerAddressController::class);
        Route::get('customers/get_customers', [CustomerController::class, 'get_customers'])->name('customers.remove_image');
        Route::get('/customers/get_customers', [Backend\CustomerController::class, 'get_customers'])->name('customers.get_customers');
        Route::get('cities/get_cities', [Backend\CityController::class, 'get_cities'])->name('cities.get_cities');
        Route::post('show_cities', [CityController::class, 'show_cities'])->name('show_cities');
        // Route::post('show_cities', 'CityController@show_cities')->name('show_cities');
        Route::resource('shipping_companies', ShippingCompanyController::class);




    });
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/site-logout', [App\Http\Controllers\HomeController::class, 'site_logout'])->name('site-logout');
