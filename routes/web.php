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

Auth::routes();

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
Route::get('subscriber', 'Auth\SubscriberController@index')->name('subscriber');
Route::get('subscriber/edit', 'Auth\SubscriberController@edit')->name('subscriber.edit');
Route::patch('/subscriber/update/{id}', 'Auth\SubscriberController@store')->name('subscriber.update');
Route::get('/subscriber/sign_up', 'Auth\SubscriberRegistrationController@index');
Route::post('/subscriber/create', 'Auth\SubscriberRegistrationController@register')->name('subscriber.registration');
Route::get('/subscriber/sign_in', 'Auth\SubscriberLoginController@showLoginForm');
Route::post('/subscriber/login', 'Auth\SubscriberLoginController@login')->name('subscriber.login');
// Route::resource('company_owner', 'CompanyOwnerController');




Route::get('/layouts', function(){
    return view('layouts.admin');
});