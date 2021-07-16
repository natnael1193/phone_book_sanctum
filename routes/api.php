<?php

use App\Service;
use App\User;
use App\Company;
use App\Customer;
use App\Subscriber;
use App\WorkingTime;
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
//Route::middleware('auth:sanctum')->get('/subscriber', function (Request $request) {
////    return $request->user();
//    $post =  Company::query()->where('subscriber_id', auth()->user()->id)->first();
//    $user = Subscriber::query()->where('email', auth()->user('sanctum')->email)->first();
//    $service = Service::query()->where('subscriber_id', auth()->user('sanctum')->id)->get();
//    $working_time = WorkingTime::query()->where('subscriber_id', auth()->user('sanctum')->id)->get();
//
//    return response()->json(["subscriber" => $user, "company" => $post, "company services" => $service, "working time" => $working_time]);
//});

Route::group(['middleware' => ['cors', 'json.response']], function () {

    Route::post('/subscriber/create', 'Api\Auth\SubscriberRegistrationController@register')->name('subscriber.registration');
    // ...
    // Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    //     return $request->user();
    // });

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
        return ["user" => $user->id, "token" => $user->createToken('API Token')->plainTextToken];
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
        $subscriber_company = Company::where('subscriber_id', '=', $subscriber->id)->first();
        if ($subscriber_company == null) {
            return ["subscriberId" => $subscriber->id, "subscriberName" => $subscriber->name, "subscriberEmail" => $subscriber->email, "hasCompany" => false, "token" => $subscriber->createToken('API Token')->plainTextToken];
        } else {
            return ["subscriberId" => $subscriber->id, "subscriberName" => $subscriber->name, "subscriberEmail" => $subscriber->email, "hasCompany" => true, "companyID" => $subscriber_company->id, "companyName" => $subscriber_company->company_name,  "companyEmail" => $subscriber->company_email, "companyPhone" => $subscriber_company->phone_number, "token" => $subscriber->createToken('API Token')->plainTextToken];
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
    Route::get('company_search/{id}', 'Api\MainController@company_search');
    Route::post('blog_search', 'Api\MainController@blog_search');
    Route::get('vacancies', 'Api\MainController@vacancy');
    Route::get('vacancy_detail/{id}', 'Api\MainController@vacancy_detail');
    Route::post('vacancy_search', 'Api\MainController@vacancy_search');
    Route::get('vacancy_categories', 'Api\MainController@vacancy_category');
    Route::get('vacancy_categories/{id}', 'Api\MainController@vacancy_category_detail');
    Route::get('tender_detail/{id}', 'Api\MainController@tender_detail');
    Route::get('tenders', 'Api\MainController@tender');
    Route::post('tender_search', 'Api\MainController@tender_search')->name('tender.search');
    Route::get('/top_rated', 'Api\MainController@top_rated');
});





//A Middleware For Subscriber Controller
Route::group(['middleware' => ['cors', 'json.response', 'auth:sanctum']], function () {
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
    Route::get('subscriber/{id}/edit_vacancy', 'Api\Auth\SubscriberController@edit_vacancy')->name('subscriber.edit_vacancy');
    Route::patch('subscriber/{id}/update_vacancy', 'Api\Auth\SubscriberController@update_vacancy')->name('subscriber.update_vacancy');
    Route::delete('subscriber/{id}/delete_vacancy', 'Api\Auth\SubscriberController@delete_vacancy')->name('subscriber.delete_vacancy');

        //service
    Route::get('subscriber/service', 'Api\Auth\SubscriberController@service')->name('subscriber.service');
    Route::post('subscriber/add_service', 'Api\Auth\SubscriberController@add_service')->name('subscriber.add_service');
    Route::get('subscriber/{id}/edit_service', 'Api\Auth\SubscriberController@edit_service')->name('subscriber.edit_service');
    Route::patch('subscriber/{id}/update_service', 'Api\Auth\SubscriberController@update_service')->name('subscriber.update_service');
    Route::delete('subscriber/{id}/delete_service', 'Api\Auth\SubscriberController@delete_service')->name('subscriber.delete_service');

    //Working Time
    Route::get('subscriber/working_time', 'Api\Auth\SubscriberController@working_time')->name('subscriber.working_time');
    Route::post('subscriber/add_working_time', 'Api\Auth\SubscriberController@add_working_time')->name('subscriber.add_working_time');
    Route::get('subscriber/{id}/edit_working_time', 'Api\Auth\SubscriberController@edit_working_time')->name('subscriber.edit_working_time');
    Route::patch('subscriber/{id}/update_working_time', 'Api\Auth\SubscriberController@update_working_time')->name('subscriber.update_working_time');
    // Route::delete('subscriber/{id}/delete_service', 'Api\Auth\SubscriberController@delete_service')->name('subscriber.delete_service');

    //Company Rating
    Route::post('subscriber/add_company_rating', 'Api\Auth\SubscriberController@add_company_rating')->name('subscriber.add_company_rating');
    Route::patch('subscriber/{id}/update_company_rating', 'Api\Auth\SubscriberController@update_company_rating')->name('subscriber.update_company_rating');

    //Company Review
    Route::post('subscriber/add_company_review', 'Api\Auth\SubscriberController@add_company_review')->name('subscriber.add_company_review');
    Route::patch('subscriber/{id}/update_company_review', 'Api\Auth\SubscriberController@update_company_review')->name('subscriber.update_company_rating');


    Route::resource('rating', 'Api\RatingController');
    Route::resource('review', 'Api\ReviewController');
    Route::middleware(['auth:subscriber', 'admin'])->resource('role', 'Api\RoleController');
    Route::resource('image', 'Api\ImageController');
    Route::resource('company_owner', 'Api\CompanyOwnerController');
    Route::resource('bookmark', 'Api\BookmarkController');
    // Route::resource('service', 'Api\ServiceController');
    Route::resource('working_time', 'Api\WorkingTimeController');
});


//A Middleware For Admin Controller
Route::group(['middleware' => ['cors', 'json.response', 'auth:sanctum']], function () {
    Route::resource('blog', 'Api\BlogController');
    Route::resource('company', 'Api\CompanyController');
    Route::resource('category', 'Api\CategoryController');
    Route::resource('company_category', 'Api\CompanyCategoryController');
    Route::middleware(['auth'])->resource('company_requests', 'Api\CompanyRequestsController');
    Route::resource('activity_log', 'Api\ActivityLogController');

    Route::middleware(['admin'])->get('/admin', 'Api\AdminController@index')->name('admin');
    Route::middleware(['admin'])->get('/admin/register', 'Api\AdminController@register')->name('admin.register');
});
