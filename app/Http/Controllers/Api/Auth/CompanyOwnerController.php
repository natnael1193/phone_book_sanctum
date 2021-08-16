<?php

namespace App\Http\Controllers\Api\Auth;

use App\Company;
use App\Images;
use App\Service;
use App\Vacancy;
use App\Category;
use App\CompanyOwner;
use App\Subscriber;
use App\WorkingTime;
use App\CompanyRating;
use App\CompanyReview;
use App\Http\Controllers\Controller;
use App\SavedTender;
use App\Tinder;
use Illuminate\Http\Request;
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
        $post =  Company::query()->where('subscriber_id', auth()->user('sanctum')->id)->get();
        $service = Service::query()->where('subscriber_id', auth()->user('sanctum')->id)->get();
        $vacancy = Vacancy::query()->where('subscriber_id', auth()->user('sanctum')->id)->get();
        $working_time = WorkingTime::query()->where('subscriber_id', auth()->user('sanctum')->id)->get();
        $image = Images::query()->where('subscriber_id', auth()->user('sanctum')->id)->get();
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
        $password = ['password' => Hash::make($data['password'])];

        if (request('image')) {
            $imagePath = request('image')->store('uploads', 'public');
            $image = Image::make(public_path("storage/{$imagePath}"))->resize(300, 300);
            $image->save();
            $imageArray = ['image' => $imagePath];
        }
        $user->update(array_merge(
            $data,
            $imageArray  ?? [],
            $password
        ));
        return response()->json($data);
    }
    public function new_company(Request $request)
    {
        $data = request()->validate([
            'subscriber_id' => 'required',
            'company_email' => 'required',
            "company_name" => 'required',
            "phone_number" => "required"
        ]);
        $oldData =  CompanyOwner::where('id', auth()->user('sanctum')->id)->first();
        $subscriber = ['subscriber_id' => auth()->user('sanctum')->id];

        Company::create(array_merge(
            $data,
            $subscriber
        ));

        $oldData->update(array_merge(
            $data,
            $subscriber
        ));

        return response()->json([$data, $subscriber]);
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

        //   $data = Company::query()->where('company_email', auth()->user('sanctum')->company_email)->first();
        $post = request()->all();
        $oldData = Vacancy::findOrFail($id);
        $this->authorize('update', $oldData);
        $user = ['subscriber_id' => auth()->user('sanctum')->id];
        // $company = ['company_id' => $data->id];

        $oldData->update(array_merge(
            $post,
            $user
            // $company
        ));
        return response()->json([$user, $post]);
    }

    public function delete_vacancy($id)
    {

        $vacancy = Vacancy::findOrFail($id);
        $this->authorize('delete', $vacancy);
        Vacancy::findOrFail($id)->delete();
        return response()->json("Deleted Successfully");
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
        $this->authorize('view', $service);
        return response()->json([$service]);
    }

    public function update_service(Request $request, $id)
    {

        //   $data = Company::query()->where('company_email', auth()->user('sanctum')->company_email)->first();
        $post = request()->all();
        $oldData = Service::findOrFail($id);
        $this->authorize('update', $oldData);
        $user = ['subscriber_id' => auth()->user('sanctum')->id];
        // $company = ['company_id' => $data->id];

        $oldData->update(array_merge(
            $post,
            $user
            // $company
        ));
        return response()->json([$user, $post]);
    }

    public function delete_service($id)
    {

        $service = Service::findOrFail($id);
        $this->authorize('delete', $service);
        Service::findOrFail($id)->delete();
        return response()->json("Deleted Successfully");
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

        $data = Company::where('subscriber_id', auth()->user('sanctum')->id)->first();
        $post = request()->all();
        $oldData = WorkingTime::findOrFail($id);
        //   $this->authorize('view', $oldData);
        $user = ['subscriber_id' => auth()->user('sanctum')->id];
        $company = ['company_id' => $data->id];

        $oldData->update(array_merge(
            $post,
            $user,
            $company
        ));
        return response()->json([$user, $post]);
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
        //    $company = Company::findOrFail($id);
        Images::findOrFail($id)->delete();
        return redirect()->back();
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

}
