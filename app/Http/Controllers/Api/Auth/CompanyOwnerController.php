<?php

namespace App\Http\Controllers\Api\Auth;

use App\Company;
use App\Images;
use App\Service;
use App\Vacancy;
use App\Category;
use App\Certification;
use App\CompanyOwner;
use App\Subscriber;
use App\WorkingTime;
use App\CompanyRating;
use App\CompanyReview;
use App\Education;
use App\EducationLevel;
use App\Experience;
use App\Hobby;
use App\Http\Controllers\Controller;
use App\Language;
use App\LanguageList;
use App\PersonalSkill;
use App\ProfessionalSkill;
use App\Reference;
use App\SavedTender;
use App\Tinder;
use App\VacancyRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class CompanyOwnerController extends Controller
{
    //
    // protected $user;

    // protected $company_owner = false;


    public function index()
    {

        $user = CompanyOwner::query()->where('email', auth()->user('sanctum')->email)->first();
        $post =  Company::query()->where('subscriber_id', auth()->user('sanctum')->id)->first();
        $service = Service::query()->where('company_id', $post->id)->get();
        $vacancy = Vacancy::query()->where('company_id', $post->id)->get();
        $working_time = WorkingTime::query()->where('company_id', $post->id)->get();
        $image = Images::query()->where('company_id', $post->id)->get();
        if ($user == true) {
            return response()->json(["company_owner" => $user, "company" => $post, "company services" => $service, "vacancy" => $vacancy, "working time" => $working_time, "images" => $image]);
        } else {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }
    }

    public function update(Request $request)
    {
        $data = request()->all();
        $user = CompanyOwner::query()->where('id', auth()->user('sanctum')->id)->first();
        // $password = ['password' => Hash::make($data['password'])];

        if (request('image')) {
            $imagePath = request('image')->store('uploads', 'public');
            $image = Image::make(public_path("storage/{$imagePath}"))->resize(300, 300);
            $image->save();
            $imageArray = ['image' => $imagePath];
        }
        $user->update(array_merge(
            $data,
            $imageArray  ?? [],
            // $password
        ));
        return response()->json($data);
    }

    public function update_password(Request $request)
    {
    $data = request()->validate([
        'password_confirmation' => ['required', 'string', 'max:255'],
        'new_password' => ['required', 'string', 'max:255'],
        'old_password' => ['required', 'string', 'max:255'],
    ]);

    if (!(Hash::check(request('old_password'), auth()->user('sanctum')->password))) {
        return response()->json(['error' => 'Password do not match']);
    }
    if (strcmp(request('old_password'), request('new_password')) == 0) {
        return response()->json(['error' => 'Current password and new password can not be the same']);
    }
    if (strcmp(request('password_confirmation'), request('new_password')) != 0) {
        return response()->json(['error' => 'Password confiramtion error']);
    }
    $user = auth()->user('sanctum');
    $user->password = Hash::make(request('new_password'));
    $user->save();

    return response()->json(['message' => 'Password changed Successfully']);
}

    public function company(Request $request)
    {
        $post =  Company::query()->where('subscriber_id', auth()->user('sanctum')->id)->first();
        $post->rating = CompanyRating::where('company_id', $post->id)->get();
        
        return response()->json($post);
    }

    public function subscriber_company_update()
    {
        // $company = Company::where('company_email', auth()->user('sanctum')->company_email)->first();
        $data = request()->validate([
            'subscriber_id' => 'unique:companies',
            'company_email' => 'unique:companies',
            "company_name" => 'required',
            "phone_number" => "required",
            "company_category" => "",
            "category_id" => "",
            "location_id" => "",
            "company_name" => "",
            "company_name_am" => "",
            "phone_number" => "",
            "phone_number_2" => "",
            "company_email" => "",
            "description" => "",
            "description_am" => "",
            "fax" => "",
            "website" => "",
            "company_logo_path" => "",
            "location_image_id" => "",
            "tin_number" => "",
            "verification" => "",
            "called" => "",
            "facebook" => "",
            "twitter" => "",
            "telegram" => "",
        ]);

        $company = Company::where('subscriber_id', auth()->user('sanctum')->id)->first();
        $company->update(array_merge(
            $data
        ));

        return response()->json(["company" => $data]);
    }

    //Vacancy
    public function vacancy()
    {

        $post =  Company::query()->where('subscriber_id', auth()->user('sanctum')->id)->first('id');
        $vacancy = Vacancy::where('company_id', $post->id)->get();

        return response()->json($vacancy);
    }

    public function add_vacancy(Request $request)
    {
        $data = request()->all();
        $subscriber = ['subscriber_id' => auth()->user('sanctum')->id];
        $company = Company::where('subscriber_id', auth()->user('sanctum')->id)->first();
        $company_id = ['company_id' => $company->id];

        //        if ($request->name != null) {
        //            foreach ($request->name as $item => $v) {
        //                $post2 = array(
        //                    'name' => $request->name[$item],
        //                    'subscriber_id' => $subscriber->id,
        //                    'company_id' => $company->id,
        //                );
        //                Vacancy::create(array_merge(
        //                    $data,
        //                    $post2
        //
        //                ));
        //            }
        //        }

        Vacancy::create(array_merge(
            $data,
            $subscriber,
            $company_id
        ));

        return response()->json([$data, $subscriber, $company_id]);
    }

    public function edit_vacancy($id)
    {

        $vacancy = Vacancy::findOrFail($id);
        $this->authorize('view', $vacancy);
        return response()->json([$vacancy]);
    }

    public function update_vacancy(Request $request, $id)
    {

        $data = Company::query()->where('subscriber_id', auth()->user('sanctum')->id)->first();
        $post = request()->all();
        $oldData = Vacancy::findOrFail($id);
        $user = ['subscriber_id' => auth()->user('sanctum')->id];
        $company = ['company_id' => $data->id];
        if ($oldData->company_id == $data->id) {
        $oldData->update(array_merge(
            $post,
            $user,
            $company
        ));
        return response()->json([$user, $post]);
    } else {
        return response([
            'error' => 'Unauthorized',
        ], 403);
    }
    }

    public function delete_vacancy($id)
    {
        $data = Company::query()->where('subscriber_id', auth()->user('sanctum')->id)->first();
        $post = Vacancy::findOrFail($id);
        if ($data->id == $post->company_id) {
        Vacancy::findOrFail($id)->delete();
        return response()->json("Deleted Successfully");
    } else {
        return response([
            'error' => 'Unauthorized',
        ], 403);
    }
    }

    //Service
    public function service()
    {
        $company = Company::where('subscriber_id', auth()->user('sanctum')->id)->first();
        $company_id = ['company_id' => $company->id];
        $service  = Service::where('company_id',  $company_id)->get();

        return response()->json($service);
    }
    public function add_service(Request $request)
    {
        $data = request()->all();
        $subscriber = ['subscriber_id' => auth()->user('sanctum')->id];
        $company = Company::where('subscriber_id', auth()->user('sanctum')->id)->first();
        $company_id = ['company_id' => $company->id];

        Service::create(array_merge(
            $data,
            $subscriber,
            $company_id
        ));
        //
        //        if ($request->name != null) {
        //            foreach ($request->name as $item => $v) {
        //                $post2 = array(
        //                    'name' => $request->name[$item],
        //                    'subscriber_id' => $subscriber->id,
        //                    'company_id' => $company->id,
        //                );
        //                Service::create(array_merge(
        //                    $data,
        //                    $post2
        //
        //                ));
        //            }
        //        }

        return response()->json([$data, $subscriber, $company_id]);
    }

    public function edit_service($id)
    {

        $service = Service::findOrFail($id);
        // $this->authorize('view', $service);
        return response()->json([$service]);
    }

    public function update_service(Request $request, $id)
    {

        $data = Company::query()->where('subscriber_id', auth()->user('sanctum')->id)->first();
        $post = request()->all();
        $oldData = Service::findOrFail($id);
        // $this->authorize('update', $oldData);
        $user = ['subscriber_id' => auth()->user('sanctum')->id];
        $company = ['company_id' => $data->id];
        if ($oldData->company_id == $data->id) {
        $oldData->update(array_merge(
            $post,
            $user,
            $company
        ));
        return response()->json([$user, $post]);
    } else {
        return response([
            'error' => 'Unauthorized',
        ], 403);
    }
    }

    public function delete_service($id)
    {

        $data = Company::query()->where('subscriber_id', auth()->user('sanctum')->id)->first();
        $post = Service::findOrFail($id);
        if ($data->id == $post->company_id) {
            Service::findOrFail($id)->delete();
            return response()->json("Deleted Successfully");
    } else {
        return response([
            'error' => 'Unauthorized',
        ], 403);
    }
    }

    //Working Time
    public function working_time()
    {
        // $company = WorkingTime::where('subscriber_id', auth()->user('sanctum')->id)->first();
        // $company_id =['company_id' => $company->id];
        $working_time  = WorkingTime::where('subscriber_id', auth()->user('sanctum')->id)->first();

        return response()->json(["working time" => $working_time]);
    }

    public function add_working_time(Request $request)
    {
        $data = request()->all();
        $subscriber = ['subscriber_id' => auth()->user('sanctum')->id];
        $company = Company::where('subscriber_id', auth()->user('sanctum')->id)->first();
        $company_id = ['company_id' => $company->id];

        WorkingTime::create(array_merge(
            $data,
            $subscriber,
            $company_id
        ));

        return response()->json([$data, $subscriber, $company_id]);
    }

    public function update_working_time(Request $request, $id)
    {

        $data = Company::query()->where('subscriber_id', auth()->user('sanctum')->id)->first();
        $post = request()->all();
        $oldData = WorkingTime::findOrFail($id);
        //   $this->authorize('view', $oldData);
        $user = ['subscriber_id' => auth()->user('sanctum')->id];
        $company = ['company_id' => $data->id];
        if ($oldData->company_id == $data->id) {
        $oldData->update(array_merge(
            $post,
            $user,
            $company
        ));
        return response()->json([$user, $post]);
    } else {
        return response([
            'error' => 'Unauthorized',
        ], 403);
    }
    }
    public function add_image(Request $request)
    {
        $data = request()->all();
        $subscriber = ['subscriber_id' => auth()->user('sanctum')->id];
        $company = Company::where('subscriber_id', auth()->user('sanctum')->id)->first();
        $company_id = ['company_id' => $company->id];

        if (!empty($request->image)) {
            foreach ($request->image as $item => $v) {
                $post2 = array(
                    'image' => $request->image[$item],
                    'user_id' => auth()->user()->id,
                    'company_id' => $company->id,
                );

                Images::create(array_merge(
                    $data,
                    $post2

                ));
            }
        }
    }
    public function delete_image($id)
    {
        $data = Company::query()->where('subscriber_id', auth()->user('sanctum')->id)->first();
        $post = Images::findOrFail($id);
        if ($data->id == $post->company_id) {
            Images::findOrFail($id)->delete();
            return response()->json("Deleted Successfully");
    } else {
        return response([
            'error' => 'Unauthorized',
        ], 403);
    }
    }

    public function check_type()
    {
        $data = Company::where('subscriber_id', auth()->user('sanctum')->id)->first();
        if ($data->company_category == 1) {
            return response()->json(["type" => "Premium"]);
        } else {
            return response()->json(["type" => "Basic"]);
        }
    }

    public function tender(){
        $company = Company::where('subscriber_id', auth()->user()->id)->first();
        $tender = Tinder::where('company_id', $company->id)->get();

        return response()->json($tender);
    }

    public function add_tender(Request $request){
        $data = request()->all();
        // $subscriber = ['subscriber_id' => auth()->user('sanctum')->id];
        $company = Company::where('subscriber_id', auth()->user('sanctum')->id)->first();
        $company_id = ['company_id' => $company->id];

        Tinder::create(array_merge(
            $data,
            // $subscriber,
            $company_id
        ));

        return response()->json($data);
    }

    public function update_tender(Request $request, $id)
    {

        $data = Company::query()->where('subscriber_id', auth()->user('sanctum')->id)->first();
        $post = request()->all();
        $oldData = Tinder::findOrFail($id);
        // $this->authorize('update', $oldData);
        $user = ['subscriber_id' => auth()->user('sanctum')->id];
        $company = ['company_id' => $data->id];
        if ($oldData->company_id == $data->id) {
        $oldData->update(array_merge(
            $post,
            $user,
            $company
        ));
        return response()->json([$user, $post]);
    } else {
        return response([
            'error' => 'Unauthorized',
        ], 403);
    }
    }
    public function delete_tender($id)
    {
        $data = Company::query()->where('subscriber_id', auth()->user('sanctum')->id)->first();
        $post = Tinder::findOrFail($id);
        // $this->authorize('delete', $post);
        if ($data->id == $post->company_id) {
        Tinder::findOrFail($id)->delete();
        return response()->json("Deleted Successfully");
    } else {
        return response([
            'error' => 'Unauthorized',
        ], 403);
    }
    }

    public function saved_tenders()
    {
        $company_owner = CompanyOwner::query()->where('id', auth()->user('sanctum')->id)->first();
        if ($company_owner == true) {
            $value = SavedTender::where('company_owner_id', $company_owner->id)->get();
            // $value = VacancyRequest::where('company_owner_id', $company_owner->id)->get();
            //        $vacanc = Vacancy::get();

            foreach ($value as $values) {
                //            if (Vacancy::where('id', $values['vacancy_id'])->exists() == true) {
                $values['tender'] = Tinder::where('id', $values['tender_id'])->first();
                // foreach ($values['vacancy'] as $vacancy) {
                //     $vacancy['job_type'] = JobType::where('id', $vacancy['job_type'])->first();
                //     $vacancy['location'] = Location::where('id', $vacancy['location'])->first();
                // }
                //            }
            }
            return response()->json($value);
        } else {
            return response([
                'error' => 'Unauthorized',
            ], 403);
        }
    }

    public function save_tender(Request $request)
    {
        $data = request()->all();
        $company_owner = CompanyOwner::query()->where('id', auth()->user('sanctum')->id)->first();
        $company_owner_id = ["company_owner_id" => $company_owner->id];
        $value = SavedTender::where('company_owner_id', auth()->user('sanctum')->id)->where('tender_id', $request->tender_id)->exists();

        if ($value == true) {
            return response()->json("exists");
        } else {
            SavedTender::create(array_merge(
                $data,
                $company_owner_id
            ));

            return response()->json($data);
        }
    }
    public function remove_saved_tender(Request $request, $id)
    {
        $company_owner = CompanyOwner::where('id', auth()->user('sanctum')->id)->first();
        $oldData = SavedTender::findOrFail($id);

        if ($oldData->company_owner_id == $company_owner->id) {
            $oldData->delete();
            return response(['message' => 'Deleted Successfully'], 200);
        } else {
            return response([
                'error' => 'Unauthorized',
            ], 403);
        }
    }

    public function vacancy_applicants($id){
        if (Vacancy::where('id', $id)->exists() == true) {
            $post = Vacancy::findOrFail($id);
            $company = Company::where('subscriber_id', auth()->user()->id)->first();
            $data = VacancyRequest::where('vacancy_id', $post->id)->get();
            $subscriber = Subscriber::get();
    
            if ($post->company_id == $company->id) {
                foreach ($data as $datas) {
                    $datas['subscriber_id'] = Subscriber::where('id', $datas['subscriber_id'])->first();
                    $datas['subscriber_id']->education_level = EducationLevel::where('id', $datas['subscriber_id']->education_level)->first();
                    $datas['subscriber_id']->career_level = EducationLevel::where('id', $datas['subscriber_id']->career_level)->first();
                    $datas['subscriber_id']->experiences = Experience::where('subscriber_id', $datas['subscriber_id']->id)->get();
                    $datas['subscriber_id']->language = Language::where('subscriber_id', $datas['subscriber_id']->id)->get();
                }

                // foreach($subscriber as $subscribers){
                //     $subscribers['experiences'] = Experience::where('subscriber_id', $subscribers['id'])->get();
                // }

                return response()->json($data);
            } else {
                return response()->json(['error' => 'Unauthorized'], 403);
            }
            } else {
                $data = [];
                return response()->json($data);
            }
    }
    public function marked_applicants($id)
    {
        if (Vacancy::where('id', $id)->exists() == true) {
        $post = Vacancy::findOrFail($id);
        $company = Company::where('subscriber_id', auth()->user()->id)->first();
        $data = VacancyRequest::where('vacancy_id', $post->id)->where('marked', 1)->get();

            if ($post->company_id == $company->id) {
                foreach ($data as $datas) {
                    $datas['subscriber_id'] = Subscriber::where('id', $datas['subscriber_id'])->first();
                    $datas['subscriber_id']->education_level = EducationLevel::where('id', $datas['subscriber_id']->education_level)->first();
                    $datas['subscriber_id']->career_level = EducationLevel::where('id', $datas['subscriber_id']->career_level)->first();

                }
                return response()->json($data);
            } else {
                return response()->json(['error' => 'Unauthorized'], 403);
            }
        } else {
            $data = [];
            return response()->json($data);
        }

    }


 public function vacancy_applicants_detail($id){
$subscriber = Subscriber::findOrFail($id);

$subscriber->experience = Experience::where('subscriber_id', $subscriber->id)->get();
$subscriber->education = Education::where('subscriber_id', $subscriber->id)->get();
$subscriber->cartificate = Certification::where('subscriber_id', $subscriber->id)->get();
$language = Language::where('subscriber_id', $subscriber->id)->get();

foreach($language as $datas){
    $datas['language_name'] = LanguageList::where('id', $datas['language_name'])->get();
    foreach($datas['language_name'] as $level){
        $level['level'] = Language::where('language_name', $level['id'])->first()->level;
    }
}
$array = data_get($language, '*.language_name');
$obj = Arr::collapse($array);
$subscriber->language = $obj;

$subscriber->hobby = Hobby::where('subscriber_id', $subscriber->id)->get();
$subscriber->reference = Reference::where('subscriber_id', $subscriber->id)->get();
$subscriber->personal_skill = PersonalSkill::where('subscriber_id', $subscriber->id)->get();
$subscriber->professional_skill = ProfessionalSkill::where('subscriber_id', $subscriber->id)->get();

return response()->json($subscriber);

    }
}
