<?php

use App\User;
use App\Company;
use App\Customer;
use App\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Intervention\Image\Facades\Image;


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



// Route::post('/login', 'AccesTokenController::class@issueToken')->middleware(['api-login', 'throttle']);


Route::group(['middleware' => ['cors', 'json.response']], function () {

    Route::post('/subscriber/create', 'Api\Auth\SubscriberRegistrationController@register')->name('subscriber.registration');
    // ...
    Route::middleware('auth:api')->get('/user', function (Request $request) {
        return $request->user();
    });

    Route::middleware('auth:api')->group(function () {
        // our routes to be protected will go in here
        Route::middleware('auth:api')->post('/logout', 'Auth\ApiAuthController@logout')->name('logout.api');
        // Route::resource('blog', 'ApiController@store');
    });

    Route::post('/login', function (Request $request) {
        $data = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        $user = User::whereEmail($request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response([
                'email' => ['The provided credentials are incorrect.'],
            ], 404);
        }
        return ["user" => $user->id, "token" => $user->createToken('api-application')->accessToken];
    });

    Route::post("/subscriber/login", function (Request $request) {
        $data = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        $subscriber = Subscriber::whereEmail($request->email)->first();
        if (!$subscriber || !Hash::check($request->password, $subscriber->password)) {
            return response([
                'email' => ['The provided credentials are incorrect.'],
            ], 404);
        }
        $subscriber_company = Company::where('company_email', $subscriber->company_email)->first();
        if ($subscriber_company == null) {
            return ["subscriberId" => $subscriber->id, "subscriberName" => $subscriber->name, "subscriberEmail" => $subscriber->email, "isCompany" => false, "token" => $subscriber->createToken('api-application')->accessToken];
        } else {
            return ["subscriberId" => $subscriber->id, "subscriberName" => $subscriber->name, "subscriberEmail" => $subscriber->email, "isCompany" => true, "companyID" => $subscriber_company->id, "companyName" => $subscriber_company->company_name,  "companyEmail" => $subscriber->company_email, "companyPhone" => $subscriber_company->phone_number, "token" => $subscriber->createToken('api-application')->accessToken];
        }
    });

    Route::post("/customer/login", function (Request $request) {
        $data = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        $customer = Customer::whereEmail($request->email)->first();
        if (!$customer || !Hash::check($request->password, $customer->password)) {
            return response([
                'email' => ['The provided credentials are incorrect.'],
            ], 404);
        }
        return $customer->createToken('my-token')->plainTextToken;
    });

    //MainController 
    Route::get('companies', 'Api\MainController@company');
    Route::get('company_detail/{id}', 'Api\MainController@company_detail');
    Route::get('blogs', 'Api\MainController@blog');
    Route::get('blog_detail/{id}', 'Api\MainController@blog_detail');
    Route::get('company_categories', 'Api\MainController@company_category');
    Route::get('company_categories/{id}', 'Api\MainController@company_category_detail');
    Route::post('company_search', 'Api\MainController@company_search');
    Route::post('blog_search', 'Api\MainController@blog_search');
    Route::get('vacancies', 'Api\MainController@vacancy');
    Route::get('tenders', 'Api\MainController@tender');
    Route::post('company_search', 'Api\MainController@search_company')->name('company.search');
});





//A Middleware For Subscriber Controller
Route::group(['middleware' => ['cors', 'json.response', 'auth:subscriber']], function () {
    // //Company Owner 
    Route::get('subscriber', 'Api\Auth\SubscriberController@index')->name('subscriber');
    Route::get('subscriber/edit', 'Api\Auth\SubscriberController@edit')->name('subscriber.edit');
    Route::post('subscriber/add_company', 'Api\Auth\SubscriberController@new_company')->name('subscriber.new_company');
    Route::post('/subscriber/store', 'Api\Auth\SubscriberController@create')->name('subscriber.store_company');
    // Route::patch('/subscriber/update/{id}', 'Api\Auth\SubscriberController@store')->name('subscriber.update');
    // Route::get('/subscriber/sign_up', 'Api\Auth\SubscriberRegistrationController@index');
    Route::get('subscriber/company', 'Api\Auth\SubscriberController@subscriber_company');
    Route::patch('/subscriber/update', 'Api\Auth\SubscriberController@update');
    Route::patch('/subscriber/update_company', 'Api\Auth\SubscriberController@subscriber_company_update');
    Route::get('/subscriber/sign_in', 'Api\Auth\SubscriberLoginController@showLoginForm');
    
    //vacancy
    Route::post('subscriber/add_vacancy', 'Api\Auth\SubscriberController@add_vacancy')->name('subscriber.add_vacancy');
    Route::get('subscriber/vacancy', 'Api\Auth\SubscriberController@vacancy')->name('subscriber.vacancy');
    
    Route::resource('rating', 'Api\RatingController');
    Route::resource('review', 'Api\ReviewController');
    Route::middleware(['auth:subscriber', 'admin'])->resource('role', 'Api\RoleController');
    Route::resource('image', 'Api\ImageController');
    Route::resource('company_owner', 'Api\CompanyOwnerController');
    Route::resource('bookmark', 'Api\BookmarkController');
    Route::resource('service', 'Api\ServiceController');
    Route::resource('working_time', 'Api\WorkingTimeController');
});


//A Middleware For Admin Controller
Route::group(['middleware' => ['cors', 'json.response', 'auth:api']], function () {
    Route::resource('blog', 'Api\BlogController');
    Route::resource('company', 'Api\CompanyController');
    Route::resource('category', 'Api\CategoryController');
    Route::resource('company_category', 'Api\CompanyCategoryController');
    Route::middleware(['auth'])->resource('company_requests', 'Api\CompanyRequestsController');
    Route::resource('activity_log', 'Api\ActivityLogController');

    Route::middleware(['admin'])->get('/admin', 'Api\AdminController@index')->name('admin');
    Route::middleware(['admin'])->get('/admin/register', 'Api\AdminController@register')->name('admin.register');
});