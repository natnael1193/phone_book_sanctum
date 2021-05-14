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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware('auth:sanctum')->get('/subscriber', function (Request $request) {
    //    $this->validator($request);
       return $request->user();
        // if(Auth::guard('customer')->attempt($request->only('email','password'),$request->filled('remember'))){
        //     //Authentication passed...
        //     return response()->json(auth()->user('customer'));
        // }  
});

Route::middleware('auth:sanctum')->group(function () {
    // our routes to be protected will go in here
    Route::middleware('auth:sanctum')->post('/logout', 'Auth\ApiAuthController@logout')->name('logout.api');
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
    return ["user" => $user->id, "token" =>$user->createToken('my-token')->plainTextToken];
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
    
    $subscriber_company = Company::where('company_email', $subscriber ->company_email)->first();
    if($subscriber_company==null ){
        return ["subscriberId" => $subscriber->id, "subscriberName" => $subscriber->name, "subscriberEmail" => $subscriber->email, "isCompany" => false,"token" => $subscriber->createToken('my-token')->plainTextToken];
    }
    else{
        return ["subscriberId" => $subscriber->id, "subscriberName" => $subscriber->name, "subscriberEmail" => $subscriber->email,"isCompany" => true, "companyID" => $subscriber_company->id,"companyName" => $subscriber_company->company_name,  "companyEmail" => $subscriber->company_email, "companyPhone" => $subscriber_company->phone_number,"token" => $subscriber->createToken('my-token')->plainTextToken];
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

Route::middleware('auth:sanctum')->resource('blog', 'Api\BlogController');
Route::middleware('auth:sanctum')->resource('company', 'Api\CompanyController');
Route::middleware('auth:sanctum')->resource('category', 'Api\CategoryController');
Route::middleware('auth:sanctum')->resource('company_category', 'Api\CompanyCategoryController');
Route::middleware('auth:sanctum')->resource('rating', 'Api\RatingController');
Route::middleware('auth:sanctum')->resource('review', 'Api\ReviewController');
Route::middleware(['auth:sanctum', 'admin'])->resource('role', 'Api\RoleController');
Route::middleware('auth:sanctum')->resource('image', 'Api\ImageController');
Route::middleware(['auth:sanctum', 'auth'])->resource('company_requests', 'Api\CompanyRequestsController');
Route::middleware('auth:sanctum')->resource('company_owner', 'Api\CompanyOwnerController');
Route::middleware('auth:sanctum')->post('company/register', 'Api\CompanyController@register');
Route::middleware('auth:sanctum')->resource('activity_log', 'Api\ActivityLogController');
Route::middleware('auth:sanctum')->resource('bookmark', 'Api\BookmarkController');
Route::middleware('auth:sanctum')->resource('service', 'Api\ServiceController');
Route::middleware('auth:sanctum')->resource('working_time', 'Api\WorkingTimeController');



// //Company Owner 
Route::middleware('auth:sanctum')->get('subscriber', 'Api\Auth\SubscriberController@index')->name('subscriber');
Route::middleware('auth:sanctum')->get('subscriber/edit', 'Api\Auth\SubscriberController@edit')->name('subscriber.edit');
Route::middleware('auth:sanctum')->get('subscriber/add_company', 'Api\Auth\SubscriberController@new_company')->name('subscriber.new_company');
Route::post('/subscriber/store', 'Api\Auth\SubscriberController@create')->name('subscriber.store_company');
Route::middleware('auth:sanctum')->patch('/subscriber/update/{id}', 'Api\Auth\SubscriberController@store')->name('subscriber.update');
// Route::middleware('auth:sanctum')->get('/subscriber/sign_up', 'Api\Auth\SubscriberRegistrationController@index');
Route::post('/subscriber/create', 'Api\Auth\SubscriberRegistrationController@register')->name('subscriber.registration');
Route::middleware('auth:sanctum')->patch('/subscriber/update', 'Api\Auth\SubscriberController@update')->name('subscriber.update');
Route::middleware('auth:sanctum')->get('/subscriber/sign_in', 'Api\Auth\SubscriberLoginController@showLoginForm');
// Route::middleware('auth:sanctum')->post('/subscriber/login', 'Api\Auth\SubscriberLoginController@login')->name('subscriber.login');

// //User Owner
// Route::middleware('auth:sanctum')->get('customer', 'Api\Auth\CustomerController@index')->name('customer');
// Route::middleware('auth:sanctum')->get('customer/edit', 'Api\Auth\CustomerController@edit')->name('customer.edit');
// Route::middleware('auth:sanctum')->patch('/customer/update/{id}', 'Api\Auth\CustomerController@store')->name('customer.update');
// Route::middleware('auth:sanctum')->get('/customer/sign_up', 'Api\Auth\CustomerRegistrationController@index');
// Route::post('/customer/create', 'Api\Auth\CustomerRegistrationController@register')->name('customer.registration');
// Route::middleware('auth:sanctum')->get('/customer/sign_in', 'Api\Auth\CustomerLoginController@showLoginForm');
// Route::post('/customer/login', 'Api\Auth\CustomerLoginController@login')->name('customer.login');
// Route::resource('company_owner', 'CompanyOwnerController');

// Route::middleware('auth:sanctum')->post('blog', 'Api\BlogController@blogStore');
Route::middleware(['auth:sanctum', 'admin'])->get('/admin', 'Api\AdminController@index')->name('admin');
Route::middleware(['auth:sanctum', 'admin'])->get('/admin/register', 'Api\AdminController@register')->name('admin.register');

//MainController 
Route::get('companies', 'Api\MainController@company');
Route::get('company_detail/{id}', 'Api\MainController@company_detail');
Route::get('blogs', 'Api\MainController@blog');
Route::get('blog_detail/{id}', 'Api\MainController@blog_detail');
Route::get('company_category', 'Api\MainController@company_category');
Route::get('company_category_detail/{id}', 'Api\MainController@company_category_detail');