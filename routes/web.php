<?php

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

use App\Customers\Requests\SendInquiryRequest;
use App\Mail\Inquiry;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::get('/', 'Front\HomeController@index')->name('home');
Route::get('logout', 'Auth\LoginController@logout');

Auth::routes();

Route::group(['middleware' => ['auth']], function () {
    Route::get('accounts', 'Front\AccountsController@index')->name('accounts');
});

Route::get('admin/login', 'Admin\LoginController@showLoginForm');
Route::post('admin/login', 'Admin\LoginController@login')->name('admin.login');
Route::get('admin/logout', 'Admin\LoginController@logout')->name('admin.logout');

/**
 * Admin routes
 */
Route::group(['prefix' => 'admin', 'middleware' => 'admin', 'as' => 'admin.' ], function () {
    Route::get('/', 'Admin\DashboardController@index')->name('dashboard');
    Route::resource('employees', 'Admin\EmployeeController');
    Route::resource('customers', 'Admin\Customers\CustomerController');
    Route::resource('customers.addresses', 'Admin\Customers\CustomerAddressController');
    Route::get('remove-image-product', 'Admin\Products\ProductController@removeImage')->name('product.remove.image');
    Route::resource('products', 'Admin\Products\ProductController');
    Route::get('remove-image-category', 'Admin\Categories\CategoryController@removeImage')->name('category.remove.image');
    Route::resource('categories', 'Admin\Categories\CategoryController');
    Route::resource('addresses', 'Admin\Addresses\AddressController');
    Route::resource('countries', 'Admin\Countries\CountryController');
    Route::resource('countries.provinces', 'Admin\Provinces\ProvinceController');
    Route::resource('countries.provinces.cities', 'Admin\Cities\CityController');
    Route::get('orders/{id}/invoice', 'Admin\Orders\OrderController@generateInvoice')
        ->name('orders.invoice.generate');
    Route::resource('orders', 'Admin\Orders\OrderController');
    Route::resource('order-statuses', 'Admin\Orders\OrderStatusController');
    Route::resource('couriers', 'Admin\Couriers\CourierController');
    Route::resource('payment-methods', 'Admin\PaymentMethods\PaymentMethodController');
});

/**
 * Frontend routes
 */
Route::get('cart/login', 'Auth\CartLoginController@showLoginForm')->name('cart.login');
Route::post('cart/login', 'Auth\CartLoginController@login')->name('cart.login');
Route::resource('cart', 'Front\CartController');
Route::get('checkout', 'Front\CheckoutController@index')->name('checkout.index');
Route::post('checkout', 'Front\CheckoutController@store')->name('checkout.store');
Route::get('checkout/execute', 'Front\CheckoutController@execute')->name('checkout.execute');
Route::get('checkout/cancel', 'Front\CheckoutController@cancel')->name('checkout.cancel');
Route::get('checkout/success', 'Front\CheckoutController@success')->name('checkout.success');
Route::get("category/{slug}", 'Front\CategoryController@getCategory')->name('front.category.slug');
Route::get("{product}", 'Front\ProductController@getProduct')->name('front.get.product');
Route::resource('customer', 'Front\CustomerController');
Route::resource('customer.address', 'Front\CustomerAddressController');

Route::post('inquire', function (SendInquiryRequest $request) {
    Mail::to(env('INQUIRY_MAIL'))->send(new Inquiry($request));
    $request->session()->flash('message', 'Your message was successfully delivered! Please wait for us to get back to you. <3');
    return redirect()->route('home');
})->name('inquiry.store');