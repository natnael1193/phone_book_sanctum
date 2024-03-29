<?php

use App\Company;
use App\CompanyRating;
use App\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
Route::get('/send-email', [App\Http\Controllers\MailController::class, 'sendEmail']);
Route::get('/redirect', 'Auth\LoginController@redirectToProvider');
Route::get('/callback', 'Auth\LoginController@handleProviderCallback');

Route::get('/', function () {

    // Storage::disk('google')->put('hello.text', "Hello laravelbackup");

    // $existingUser = User::where('email', auth()->user()->email)->first();
    //    $locations = DB::table('maps')->get();

    return view('welcome');
});
//Route::get('/dashboard', function () {
//    $existingUser = User::where('email', auth()->user()->email)->first();
//    return view('index', compact('existingUser'))->name('dashboard');
//});

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
Route::resource('language_list', 'LanguageListController');
Route::resource('company', 'CompanyController');
Route::resource('category', 'CategoryController');
Route::resource('company_category', 'CompanyCategoryController');
Route::resource('rating', 'RatingController');
Route::resource('review', 'ReviewController');
Route::resource('image', 'ImageController');
Route::resource('service', 'ServiceController');
Route::resource('vacancy_category', 'VacancyCategoryController');
Route::resource('tender_category', 'TenderCategoryController');
Route::resource('tender_sub_category', 'TenderSubCategoryController');
Route::resource('company_requests', 'CompanyRequestsController');
Route::post('add_company', 'CompanyController@add_company')->name('add_company');
Route::get('verified_company', 'CompanyRequestsController@verified_company')->name('verified_company');
Route::post('/company/verified/{id}', 'CompanyController@verified')->name('company.verified');
Route::post('/company/called/{id}', 'CompanyController@call_update')->name('company.called');
Route::post('company/register', 'CompanyController@register')->name('company.register');
Route::post('company/search_location', 'CompanyController@search_location')->name('company.search_location');
Route::post('company_search', 'CompanyController@search_company')->name('company.search');
Route::delete('dropzone/delete/{id}', 'CompanyController@delete')->name('dropzone.delete');
Route::get('dropzone/fetch/{id}', 'CompanyController@fetch')->name('dropzone.fetch');
Route::post('/upload/images', 'CompanyController@upload')->name('dropzone.upload');
Route::delete('/service/delete/{id}', 'CompanyController@delete_service');
Route::resource('/blog_category', 'BlogCategoryController');
Route::resource('/bank', 'BankController');
Route::resource('/premium', 'PremiumController');
//Education Level
Route::get('/education_level', 'LevelController@education_level')->name('education_level.index');
Route::post('/education_level', 'LevelController@add_education_level')->name('education_level.store');
Route::patch('/education_level/{id}', 'LevelController@update_education_level')->name('education_level.update');
Route::delete('/education_level/{id}', 'LevelController@delete_education_level')->name('education_level.delete');
//Job Type
Route::get('/job_type', 'LevelController@job_type')->name('job_type.index');
Route::post('/job_type', 'LevelController@add_job_type')->name('job_type.store');
Route::patch('/job_type/{id}', 'LevelController@update_job_type')->name('job_type.update');
Route::delete('/job_type/{id}', 'LevelController@delete_job_type')->name('job_type.delete');
//Job Type
Route::get('/study_field', 'LevelController@study_field')->name('study_field.index');
Route::post('/study_field', 'LevelController@add_study_field')->name('study_field.store');
Route::patch('/study_field/{id}', 'LevelController@update_study_field')->name('study_field.update');
Route::delete('/study_field/{id}', 'LevelController@delete_study_field')->name('study_field.delete');
//Job Type
Route::get('/career_level', 'LevelController@career_level')->name('career_level.index');
Route::post('/career_level', 'LevelController@add_career_level')->name('career_level.store');
Route::patch('/career_level/{id}', 'LevelController@update_career_level')->name('career_level.update');
Route::delete('/career_level/{id}', 'LevelController@delete_career_level')->name('career_level.delete');
//Company Verification List
Route::get('/company_verification_list', 'LevelController@company_verification_list')->name('company_verification_list.index');
Route::post('/company_verification_list', 'LevelController@add_company_verification_list')->name('company_verification_list.store');
Route::patch('/company_verification_list/{id}', 'LevelController@update_company_verification_list')->name('company_verification_list.update');
Route::delete('/company_verification_list/{id}', 'LevelController@delete_company_verification_list')->name('company_verification_list.delete');




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
Route::get('/subscriber_company/sign_up', function () {
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



Route::post('blog_image', 'BlogController@image');

Route::get('/layouts', function () {
    return view('layouts.admin');
});

Route::get('/top_rated', 'MainController@top_rated');






Route::get('/linkstorage', function () {
    Artisan::call('storage:link');
});

Route::get('/config_cache', function () {
    Artisan::call('config:cache');
    return response("success");
});

Route::get('/cache_clear', function () {
    Artisan::call('cache:clear');
    return response("success");
});
