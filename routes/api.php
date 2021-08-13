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
    Route::post('/user/register', 'Api\Auth\CompanyOwnerRegistrationController@register')->name('subscriber.registration');
    Route::post('/company_owner/login', 'Api\Auth\CompanyOwnerLoginController@login');
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
        // $subscriber_company = Company::where('subscriber_id', '=', $subscriber->id)->first();
        if ($subscriber->status_id == 1) {
            return ["subscriber_id" => $subscriber->id, "subscriber_name" => $subscriber->name, "subscriber_email" => $subscriber->email, "type" => "job_seeker", "token" => $subscriber->createToken('API Token')->plainTextToken];
        } else {
            return ["subscriber_id" => $subscriber->id, "subscriber_name" => $subscriber->name, "subscriber_email" => $subscriber->email, "type" => "normal_user", "token" => $subscriber->createToken('API Token')->plainTextToken];
        }
    });


    //MainController

    Route::get('companies', 'Api\MainController@company');
    Route::get('company_detail/{id}', 'Api\MainController@company_detail');
    Route::get('blogs', 'Api\MainController@blog');
    Route::get('blog_detail/{id}', 'Api\MainController@blog_detail');
    Route::get('company_categories', 'Api\MainController@company_category');
    Route::get('company_categories/{id}', 'Api\MainController@company_category_detail');
    Route::get('company_search/{id}', 'Api\MainController@company_search');
    Route::get('any_search/{id}', 'Api\MainController@any_search');
    Route::post('blog_search', 'Api\MainController@blog_search');
    Route::get('vacancies', 'Api\MainController@vacancy');
    Route::get('vacancy_detail/{id}', 'Api\MainController@vacancy_detail');
    Route::post('vacancy_search', 'Api\MainController@vacancy_search');
    Route::get('vacancy_categories', 'Api\MainController@vacancy_category');
    Route::get('some_vacancy_categories', 'Api\MainController@some_vacancy_categories');
    Route::get('vacancy_categories/{id}', 'Api\MainController@vacancy_category_detail');
    Route::get('tender_detail/{id}', 'Api\MainController@tender_detail');
    Route::get('tenders', 'Api\MainController@tender');
    Route::get('tender_categories', 'Api\MainController@tender_category');
    Route::get('tender_categories/{id}', 'Api\MainController@tender_category_detail');
    Route::post('tender_search', 'Api\MainController@tender_search')->name('tender.search');
    Route::get('/top_rated', 'Api\MainController@top_rated');
    Route::get('/latest_companies', 'Api\MainController@latest_companies');
    Route::get('/latest_vacancies', 'Api\MainController@latest_vacancies');
    Route::get('/latest_tenders', 'Api\MainController@latest_tenders');
    Route::get('/verified_companies', 'Api\MainController@verified_companies');
    Route::get('/recommended_companies', 'Api\MainController@recommended_companies');
    Route::get('/similar_business/{id}', 'Api\MainController@similar_business');
    Route::get('/featured_companies', 'Api\MainController@featured_companies');
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

    //Certificate
    Route::post('subscriber/add_certificate', 'Api\Auth\SubscriberController@add_certificate')->name('subscriber.add_certificate');
    Route::get('subscriber/certificate', 'Api\Auth\SubscriberController@certificate')->name('subscriber.certificate');
    Route::get('subscriber/{id}/edit_certificate', 'Api\Auth\SubscriberController@edit_certificate')->name('subscriber.edit_certificate');
    Route::patch('/subscriber/{id}/update_certificate', 'Api\Auth\SubscriberController@update_certificate')->name('subscriber.update_certificate');
    Route::delete('subscriber/{id}/delete_certificate', 'Api\Auth\SubscriberController@delete_certificate')->name('subscriber.delete_certificate');

    //Education
    Route::get('subscriber/education', 'Api\Auth\SubscriberController@education')->name('subscriber.education');
    Route::post('subscriber/add_education', 'Api\Auth\SubscriberController@add_education')->name('subscriber.add_education');
    Route::get('subscriber/{id}/edit_education', 'Api\Auth\SubscriberController@edit_education')->name('subscriber.edit_education');
    Route::patch('subscriber/{id}/update_education', 'Api\Auth\SubscriberController@update_education')->name('subscriber.update_education');
    Route::delete('subscriber/{id}/delete_education', 'Api\Auth\SubscriberController@delete_education')->name('subscriber.delete_education');

    //Experience
    Route::get('subscriber/experience', 'Api\Auth\SubscriberController@experience')->name('subscriber.experience');
    Route::post('subscriber/add_experience', 'Api\Auth\SubscriberController@add_experience')->name('subscriber.add_experience');
    Route::get('subscriber/{id}/edit_experience', 'Api\Auth\SubscriberController@edit_experience')->name('subscriber.edit_experience');
    Route::patch('subscriber/{id}/update_experience', 'Api\Auth\SubscriberController@update_experience')->name('subscriber.update_experience');
    Route::delete('subscriber/{id}/delete_experience', 'Api\Auth\SubscriberController@delete_experience')->name('subscriber.delete_experience');

    //Professional Skill
    Route::get('subscriber/professional_skill', 'Api\Auth\SubscriberController@professional_skill')->name('subscriber.professional_skill');
    Route::post('subscriber/add_professional_skill', 'Api\Auth\SubscriberController@add_professional_skill')->name('subscriber.add_professional_skill');
    Route::get('subscriber/{id}/edit_professional_skill', 'Api\Auth\SubscriberController@edit_professional_skill')->name('subscriber.edit_professional_skill');
    Route::patch('subscriber/{id}/update_professional_skill', 'Api\Auth\SubscriberController@update_professional_skill')->name('subscriber.update_professional_skill');
    Route::delete('subscriber/{id}/delete_professional_skill', 'Api\Auth\SubscriberController@delete_professional_skill')->name('subscriber.delete_professional_skill');

    //PersonalSkill
    Route::get('subscriber/personal_skill', 'Api\Auth\SubscriberController@personal_skill')->name('subscriber.personal_skill');
    Route::post('subscriber/add_personal_skill', 'Api\Auth\SubscriberController@add_personal_skill')->name('subscriber.add_personal_skill');
    Route::get('subscriber/{id}/edit_personal_skill', 'Api\Auth\SubscriberController@edit_personal_skill')->name('subscriber.edit_personal_skill');
    Route::patch('subscriber/{id}/update_personal_skill', 'Api\Auth\SubscriberController@update_personal_skill')->name('subscriber.update_personal_skill');
    Route::delete('subscriber/{id}/delete_personal_skill', 'Api\Auth\SubscriberController@delete_personal_skill')->name('subscriber.delete_personal_skill');

    //Language
    Route::get('subscriber/language', 'Api\Auth\SubscriberController@language')->name('subscriber.language');
    Route::post('subscriber/add_language', 'Api\Auth\SubscriberController@add_language')->name('subscriber.add_language');
    Route::get('subscriber/{id}/edit_language', 'Api\Auth\SubscriberController@edit_language')->name('subscriber.edit_language');
    Route::patch('subscriber/{id}/update_language', 'Api\Auth\SubscriberController@update_language')->name('subscriber.update_language');
    Route::delete('subscriber/{id}/delete_language', 'Api\Auth\SubscriberController@delete_language')->name('subscriber.delete_language');

    //Hobby
    Route::get('subscriber/hobby', 'Api\Auth\SubscriberController@hobby')->name('subscriber.hobby');
    Route::post('subscriber/add_hobby', 'Api\Auth\SubscriberController@add_hobby')->name('subscriber.add_hobby');
    Route::get('subscriber/{id}/edit_hobby', 'Api\Auth\SubscriberController@edit_hobby')->name('subscriber.edit_hobby');
    Route::patch('subscriber/{id}/update_hobby', 'Api\Auth\SubscriberController@update_hobby')->name('subscriber.update_hobby');
    Route::delete('subscriber/{id}/delete_hobby', 'Api\Auth\SubscriberController@delete_hobby')->name('subscriber.delete_hobby');

    //Reference
    Route::get('subscriber/reference', 'Api\Auth\SubscriberController@reference')->name('subscriber.reference');
    Route::post('subscriber/add_reference', 'Api\Auth\SubscriberController@add_reference')->name('subscriber.add_reference');
    Route::get('subscriber/{id}/edit_reference', 'Api\Auth\SubscriberController@edit_reference')->name('subscriber.edit_reference');
    Route::patch('subscriber/{id}/update_reference', 'Api\Auth\SubscriberController@update_reference')->name('subscriber.update_reference');
    Route::delete('subscriber/{id}/delete_reference', 'Api\Auth\SubscriberController@delete_reference')->name('subscriber.delete_reference');


    //Company Rating
    Route::get('subscriber/my_rating/{id}', 'Api\Auth\SubscriberController@company_rating')->name('subscriber.add_company_rating');
    Route::post('subscriber/add_company_rating', 'Api\Auth\SubscriberController@add_company_rating')->name('subscriber.add_company_rating');
    Route::patch('subscriber/{id}/update_company_rating', 'Api\Auth\SubscriberController@update_company_rating')->name('subscriber.update_company_rating');

    //Company Review
    Route::post('subscriber/add_company_review', 'Api\Auth\SubscriberController@add_company_review')->name('subscriber.add_company_review');
    Route::patch('subscriber/{id}/update_company_review', 'Api\Auth\SubscriberController@update_company_review')->name('subscriber.update_company_rating');
    Route::post('subscriber/add_preference', 'Api\Auth\SubscriberController@subscriber_add_preference')->name('subscriber.add_company_review');
    //Preference


    //Apply Vacancy
    Route::get('subscriber/applied_vacancy', 'Api\Auth\SubscriberController@applied_vacancy')->name('subscriber.applied_vacancy');
    Route::post('subscriber/apply_vacancy', 'Api\Auth\SubscriberController@apply_vacancy')->name('subscriber.apply_vacancy');
    Route::post('subscriber/delete_applied_vacancy', 'Api\Auth\SubscriberController@remove_applied_vacancy')->name('subscriber.remove_applied_vacancy');
    //Preference Vacancies
    Route::get('subscriber/preference_vacancy', 'Api\Auth\SubscriberController@subscriber_preference_vacancy')->name('subscriber.subscriber_preference_vacancy');

    //Saved Vacancy
    Route::get('subscriber/saved_vacancy', 'Api\Auth\SubscriberController@saved_vacancy')->name('subscriber.saved_vacancy');
    Route::post('subscriber/save_vacancy', 'Api\Auth\SubscriberController@save_vacancy')->name('subscriber.save_vacancy');
    Route::post('subscriber/delete_saved_vacancy', 'Api\Auth\SubscriberController@remove_saved_vacancy')->name('subscriber.save_vacancy');

    //Checked Cv
    Route::get('subscriber/check_cv', 'Api\Auth\SubscriberController@check_cv');

    Route::resource('rating', 'Api\RatingController');
    Route::resource('review', 'Api\ReviewController');
    Route::middleware(['auth:subscriber', 'admin'])->resource('role', 'Api\RoleController');
    Route::resource('image', 'Api\ImageController');
    Route::resource('company_owner', 'Api\CompanyOwnerController');
    Route::resource('bookmark', 'Api\BookmarkController');
    // Route::resource('service', 'Api\ServiceController');
    Route::resource('working_time', 'Api\WorkingTimeController');
});

//Reset Password
// Route::post('subscriber/reset_password', 'Api\Auth\ForgotPasswordController@postEmail')->name('subscriber.reset_password');
// Route::get('forget-password', 'Api\Auth\ForgotPasswordController@getEmail');
Route::post('subscriber/forget-password', 'Api\Auth\ForgotPasswordController@postEmail')->name('user.forget-password');
// Route::get('reset-password/{token}', 'Api\Auth\ForgotPasswordController@getPassword');
// Route::post('reset-password', 'Api\Auth\ForgotPasswordController@updatePassword');

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


//A Middleware For Company Owner Controller
Route::group(['middleware' => ['cors', 'json.response', 'auth:sanctum']], function () {
    // //Company Owner
    Route::get('company_owner', 'Api\Auth\CompanyOwnerController@index')->name('company_owner');
    Route::get('company_owner/edit', 'Api\Auth\CompanyOwnerController@edit')->name('company_owner.edit');
    Route::post('company_owner/add_company', 'Api\Auth\CompanyOwnerController@new_company')->name('company_owner.new_company');
    Route::post('/company_owner/store', 'Api\Auth\CompanyOwnerController@create')->name('company_owner.store_company');
    // Route::patch('/company_owner/update/{id}', 'Api\Auth\CompanyOwnerController@store')->name('company_owner.update');
    // Route::get('/company_owner/sign_up', 'Api\Auth\SubscriberRegistrationController@index');
    Route::get('company_owner/company', 'Api\Auth\CompanyOwnerController@subscriber_company');
    Route::post('/company_owner/update', 'Api\Auth\CompanyOwnerController@update');
    Route::patch('/company_owner_update_company', 'Api\Auth\CompanyOwnerController@subscriber_company_update');
    Route::get('/company_owner/sign_in', 'Api\Auth\SubscriberLoginController@showLoginForm');

    //vacancy
    Route::post('company_owner_add_vacancy', 'Api\Auth\CompanyOwnerController@add_vacancy')->name('company_owner.add_vacancy');
    Route::get('/company_owner_vacancy', 'Api\Auth\CompanyOwnerController@vacancy');
    Route::get('company_owner/{id}/edit_vacancy', 'Api\Auth\CompanyOwnerController@edit_vacancy')->name('company_owner.edit_vacancy');
    Route::patch('company_owner/{id}/update_vacancy', 'Api\Auth\CompanyOwnerController@update_vacancy')->name('company_owner.update_vacancy');
    Route::delete('company_owner/{id}/delete_vacancy', 'Api\Auth\CompanyOwnerController@delete_vacancy')->name('company_owner.delete_vacancy');

    //service
    Route::get('company_owner_service', 'Api\Auth\CompanyOwnerController@service')->name('company_owner.service');
    Route::post('company_owner_add_service', 'Api\Auth\CompanyOwnerController@add_service')->name('company_owner.add_service');
    Route::get('company_owner_/{id}/edit_service', 'Api\Auth\CompanyOwnerController@edit_service')->name('company_owner.edit_service');
    Route::patch('company_owner/{id}/update_service', 'Api\Auth\CompanyOwnerController@update_service')->name('company_owner.update_service');
    Route::delete('company_owner/{id}/delete_service', 'Api\Auth\CompanyOwnerController@delete_service')->name('company_owner.delete_service');

    //Working Time
    Route::get('company_owner_working_time', 'Api\Auth\CompanyOwnerController@working_time')->name('company_owner.working_time');
    Route::post('company_owner_add_working_time', 'Api\Auth\CompanyOwnerController@add_working_time')->name('company_owner.add_working_time');
    Route::get('company_owner/{id}/edit_working_time', 'Api\Auth\CompanyOwnerController@edit_working_time')->name('company_owner.edit_working_time');
    Route::patch('company_owner/{id}/update_working_time', 'Api\Auth\CompanyOwnerController@update_working_time')->name('company_owner.update_working_time');
    // Route::delete('company_owner/{id}/delete_service', 'Api\Auth\CompanyOwnerController@delete_service')->name('company_owner.delete_service');

    //Company Rating
    Route::post('company_owner_add_company_rating', 'Api\Auth\CompanyOwnerController@add_company_rating')->name('company_owner.add_company_rating');
    Route::patch('company_owner/{id}/update_company_rating', 'Api\Auth\CompanyOwnerController@update_company_rating')->name('company_owner.update_company_rating');


    //premium order
    Route::get('/banks_list', 'BankController@bank_list');
    Route::post('/update_company_premium', 'PremiumController@store');
    Route::get('/premiumCheck/{id}', 'PremiumCheckController@premiumCheck');
});
