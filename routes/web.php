<?php

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
Route::get('/', function () {
    return view('welcome');
});
Route::get('/dashboard', function () {
    return view('index');
});

Auth::routes();

//Back End
Route::get('/admin', 'AdminController@index')->name('admin')->middleware('admin');
Route::get('/manager', 'ManagerController@index')->name('manager')->middleware('manager');
Route::get('/user', 'UserController@index')->name('user')->middleware('user');
Route::get('/encoder', 'EncoderController@index')->name('encoder')->middleware('encoder');
Route::get('/bloger', 'BlogController@index')->name('bloger')->middleware('bloger');
Route::get('/company_owner', 'CompanyOwnerController@index')->middleware('company_owner');
Route::post('/user/register', 'AdminController@register')->name('user.register')->middleware('admin');

Route::resource('admin', 'AdminController')->middleware('admin');
Route::get('/admin/register', 'AdminController@register')->name('admin.register')->middleware('admin');
Route::resource('role', 'RoleController')->middleware('admin');
Route::resource('blog', 'blogController');
Route::resource('company', 'CompanyController');
Route::resource('category', 'CategoryController');
Route::resource('company_category', 'CompanyCategoryController');
Route::resource('rating', 'RatingController');
Route::resource('review', 'ReviewController');
Route::resource('image', 'ImageController');
Route::resource('service', 'ServiceController');
Route::resource('company_requests', 'CompanyRequestsController');
Route::patch('/company/verified/{id}', 'CompanyController@verified')->name('company.verfied');
Route::post('company/register', 'CompanyController@register')->name('company.register');
Route::resource('activity_log', 'ActivityLogController');
Route::resource('bookmark', 'BookmarkController');
//Company Owner 
Route::get('subscriber', 'Auth\SubscriberController@index')->name('subscriber');
Route::get('subscriber/edit', 'Auth\SubscriberController@edit')->name('subscriber.edit');
Route::get('subscriber/add_company', 'Auth\SubscriberController@new_company')->name('subscriber.new_company');
Route::post('/subscriber/store', 'Auth\SubscriberController@create')->name('subscriber.store_company');
Route::patch('/subscriber/update/{id}', 'Auth\SubscriberController@store')->name('subscriber.update');
Route::get('/subscriber/sign_up', 'Auth\SubscriberRegistrationController@index');
Route::post('/subscriber/create', 'Auth\SubscriberRegistrationController@register')->name('subscriber.registration');
Route::post('/subscriber/register', 'Auth\SubscriberRegistrationController@store')->name('subscriber.store');
Route::get('/subscriber/sign_in', 'Auth\SubscriberLoginController@showLoginForm');
Route::post('/subscriber/login', 'Auth\SubscriberLoginController@login')->name('subscriber.login');

//User Owner
Route::get('customer', 'Auth\CustomerController@index')->name('customer');
Route::get('customer/edit', 'Auth\CustomerController@edit')->name('customer.edit');
Route::patch('/customer/update/{id}', 'Auth\CustomerController@store')->name('customer.update');
Route::get('/customer/sign_up', 'Auth\CustomerRegistrationController@index');
Route::post('/customer/create', 'Auth\CustomerRegistrationController@register')->name('customer.registration');
Route::get('/customer/sign_in', 'Auth\CustomerLoginController@showLoginForm');
Route::post('/customer/login', 'Auth\CustomerLoginController@login')->name('customer.login');
// Route::resource('company_owner', 'CompanyOwnerController');



Route::get('/layouts', function(){
    return view('layouts.admin');
});