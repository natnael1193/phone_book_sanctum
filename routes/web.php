<?php

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

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
Route::get('/redirect', 'Auth\LoginController@redirectToProvider');
Route::get('/callback', 'Auth\LoginController@handleProviderCallback');

Route::get('/', function () {

    // Storage::disk('google')->put('hello.text', "Hello laravelbackup");
    
    // $existingUser = User::where('email', auth()->user()->email)->first();
    return view('welcome');
});
Route::get('/dashboard', function () {
    $existingUser = User::where('email', auth()->user()->email)->first();
    return view('index', compact('existingUser'))->name('dashboard');
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
Route::get('/edit_user/{id}', 'AdminController@edit_user')->name('user.edit_user');
Route::post('/update_user', 'AdminController@update_user')->name('user.update_user');

Route::resource('admin', 'AdminController')->middleware('admin');
Route::get('/admin/register', 'AdminController@register')->name('admin.register')->middleware('admin');
Route::resource('role', 'RoleController')->middleware('admin');
Route::resource('blog', 'BlogController');
Route::resource('vacancy', 'VacancyController');
Route::resource('tender', 'TinderController');
Route::resource('location', 'LocationController');
Route::resource('company', 'CompanyController');
Route::resource('category', 'CategoryController');
Route::resource('company_category', 'CompanyCategoryController');
Route::resource('rating', 'RatingController');
Route::resource('review', 'ReviewController');
Route::resource('image', 'ImageController');
Route::resource('service', 'ServiceController');
Route::resource('company_requests', 'CompanyRequestsController');
Route::post('/company/verified/{id}', 'CompanyController@verified')->name('company.verified');
Route::post('/company/called/{id}', 'CompanyController@call_update')->name('company.called');
Route::post('company/register', 'CompanyController@register')->name('company.register');
Route::post('company/search_location', 'CompanyController@search_location')->name('company.search_location');
Route::post('company_search', 'CompanyController@search_company')->name('company.search');
Route::get('dropzone/delete/{id}', 'CompanyController@delete')->name('dropzone.delete');
Route::get('dropzone/fetch/{id}', 'CompanyController@fetch')->name('dropzone.fetch');
Route::post('/upload/images', 'CompanyController@upload')->name('dropzone.upload');

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
Route::post('/subscriber_company/register', 'Auth\SubscriberRegistrationController@subscriber_company_register')->name('subscriber.subscriber_company_register');
Route::get('/subscriber/sign_in', 'Auth\SubscriberLoginController@showLoginForm');
Route::post('/subscriber/login', 'Auth\SubscriberLoginController@login')->name('subscriber.login');
Route::get('/subscriber_company/sign_up', function(){
    return view('company_owner.subscriber_company');
});

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