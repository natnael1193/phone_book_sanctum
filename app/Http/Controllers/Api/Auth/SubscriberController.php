<?php

namespace App\Http\Controllers\Api\Auth;

use App\Company;
use App\Service;
use App\Vacancy;
use App\Category;
use App\Subscriber;
use App\WorkingTime;
use App\CompanyRating;
use App\CompanyReview;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class SubscriberController extends Controller
{
    //
    protected $user;

    protected $subscriber = false;

    public function __construct()
    {
        if (Auth::guard('subscriber')->check()) {
            $this->user = Auth::guard('subscriber')->user();
            $this->subscriber = true;
        } elseif (Auth::guard()->check()) {
            $this->user = Auth::guard()->user();
            $this->subscriber = false;
        } else {
            return response()->json([
                'message' => 'Not Authorized',
            ], 401);
        }
    }



    public function update(Request $request)
    {
        $data = request()->all();
        $check = $this->save($data);

        return response()->json([$data]);
    }

    public function save(array $data)
    {

        $user = Subscriber::query()->where('id', auth()->user('subscriber')->id)->first();

        $user->update([
            'name' => $data['name'],
            //            'lastName' => $data['lastName'],
            'email' => $data['email'],
            "company_email" => $data['company_email'],
            'password' => Hash::make($data['password']),

        ]);
    }

    public function index()
    {
        $post =  Company::query()->where('subscriber_id', auth()->user('subscriber')->id)->first();
        $user = Subscriber::query()->where('email', auth()->user('subscriber')->email)->first();
        $service = Service::query()->where('subscriber_id', auth()->user('subscriber')->id)->get();
        $working_time = WorkingTime::query()->where('subscriber_id', auth()->user('subscriber')->id)->get();

        return response()->json(["subscriber" => $user, "company" => $post, "company services" => $service, "working time" => $working_time]);
    }
    public function edit()
    {

        $post =  Company::where('subscriber_id', auth()->user('subscriber')->id)->first();

        return response()->json($post);
    }
    public function store(Request $request)
    {

        $data = request()->all();
        $oldData =  Company::where('subscriber_id', auth()->user('subscriber')->id)->first();

        // $company_category=['company_category' =>$request->company_category];
        // $category_id=['category_id' =>$request->category_id];
        // $user=['user_id' =>auth()->user()->id];

        $oldData->update(array_merge(
            $data
        ));
        return response()->json($data);
    }


    public function new_company(Request $request)
    {
        $data = request()->validate([
            'subscriber_id' => 'unique:companies',
            'company_email' => 'unique:companies',
            "company_name" => 'required',
            "phone_number" => "required|unique:companies"
        ]);
        $oldData =  Subscriber::where('id', auth()->user('subscriber')->id)->first();
        $subscriber = ['subscriber_id' => auth('subscriber')->user()->id];

        Company::create(array_merge(
            $data,
            $subscriber
        ));

        $oldData->update(array_merge(
            $data
        ));

        return response()->json([$data, $subscriber]);
    }


    public function create()
    {
        $data = request()->all();
        //    $user=['user_id' => auth()->user()->id];
        //    dd( $data, $user);
        Company::create(array_merge(
            $data
        ));
        return response()->json($data);
    }

    public function subscriber_company()
    {

        $company = Company::where('company_email', auth()->user('subscriber')->company_email)->first();

        return response()->json($company);
    }

    public function subscriber_company_update()
    {
        // $company = Company::where('company_email', auth()->user('subscriber')->company_email)->first();
        $data = request()->validate([
            'subscriber_id' => 'unique:companies',
            'company_email' => 'unique:companies',
            "company_name" => 'required',
            "phone_number" => "required",

            "company_category" => "",
            "category_id"=> "",
            "location_id" => "",
            "company_name"=> "",
            "company_name_am"=> "",
            "phone_number"=> "",
            "phone_number_2"=> "",
            "company_email"=> "",
            "description"=> "",
            "description_am"=> "",
            "fax"=> "",
            "website"=> "",
            "company_logo_path"=> "",
            "location_image_id"=> "",
            "tin_number"=> "",
            "verification"=> "",
            "called"=> "",
            "facebook"=> "",
            "twitter"=> "",
            "telegram"=> "",
        ]);
        $oldData =  Subscriber::where('id', auth()->user('subscriber')->id)->first();
        $company = Company::where('subscriber_id', auth()->user('subscriber')->id)->first();

        // $subscriber=['subscriber_id' => auth('subscriber')->user()->id];
        // $               $company = Company::where('subscriber_id', auth()->user('subscriber')->id)->first();
        $company->update(array_merge(
            $data,
        ));

        $oldData->update(array_merge(
            $data
        ));

        $data = request()->all();
        return response()->json(["company" => $data]);
    }

    //Vacancy
    public function vacancy(Request $request)
    {
        $company = Company::where('subscriber_id', auth()->user('subscriber')->id)->first();
        $company_id =['company_id' => $company->id];
        $vacancy =   Vacancy::where('company_id',  $company_id)->get();
        
        return response()->json([$vacancy]);
    }
    public function add_vacancy(Request $request)
    {
        $data = request()->all();
        $subscriber = ['subscriber_id' => auth()->user('subscriber')->id];
        $company = Company::where('subscriber_id', auth()->user('subscriber')->id)->first();
        $company_id =['company_id' => $company->id];
        
        Vacancy::create(array_merge(
            $data,
            $subscriber,
            $company_id
        ));

        return response()->json([$data, $subscriber, $company_id]);
    }

    public function edit_vacancy($id){

        $vacancy = Vacancy::findOrFail($id);
             $this->authorize('view', $vacancy);
        return response()->json([ $vacancy]);
    }

public function update_vacancy(Request $request, $id){
    
//   $data = Company::query()->where('company_email', auth()->user('subscriber')->company_email)->first();
        $post = request()->all();
        $oldData = Vacancy::findOrFail($id);
             $this->authorize('view', $oldData);
        $user = ['subscriber_id' => auth('subscriber')->user()->id];
        // $company = ['company_id' => $data->id];

        $oldData->update(array_merge(
            $post,
            $user,
            // $company
        ));
        return response()->json([$user, $post]);
}

public function delete_vacancy($id){

    $service = Vacancy::findOrFail($id)->delete();
    $this->authorize('delete', $service);
    return response()->json([ $service]);
    
}
    //Service
    public function service()
    {
        $company = Company::where('subscriber_id', auth()->user('subscriber')->id)->first();
        $company_id =['company_id' => $company->id];
        $service  = Service::where('company_id',  $company_id)->get();
        
        return response()->json([$service]);
    }

    public function add_service(Request $request)
    {
        $data = request()->all();
        $subscriber = ['subscriber_id' => auth()->user('subscriber')->id];
        $company = Company::where('subscriber_id', auth()->user('subscriber')->id)->first();
        $company_id =['company_id' => $company->id];
        
        Service::create(array_merge(
            $data,
            $subscriber,
            $company_id
        ));

        return response()->json([$data, $subscriber, $company_id]);
    }

    public function edit_service($id){
        
        $service = Service::findOrFail($id);
             $this->authorize('view', $service);
        return response()->json([ $service]);
        
    }

public function update_service(Request $request, $id){
    
//   $data = Company::query()->where('company_email', auth()->user('subscriber')->company_email)->first();
        $post = request()->all();
        $oldData = Service::findOrFail($id);
             $this->authorize('view', $oldData);
        $user = ['subscriber_id' => auth('subscriber')->user()->id];
        // $company = ['company_id' => $data->id];

        $oldData->update(array_merge(
            $post,
            $user,
            // $company
        ));
        return response()->json([$user, $post]);
}
    
public function delete_service($id){

    $service = Service::findOrFail($id)->delete();
    $this->authorize('delete', $service);
    return response()->json([ $service]);
    
}

//Working Time
public function working_time()
{
    // $company = WorkingTime::where('subscriber_id', auth()->user('subscriber')->id)->first();
    // $company_id =['company_id' => $company->id];
    $working_time  = WorkingTime::where('subscriber_id', auth()->user('subscriber')->id)->first();
    
    return response()->json(["working time" => $working_time]);
}

public function add_working_time(Request $request)
{
    $data = request()->all();
    $subscriber = ['subscriber_id' => auth()->user('subscriber')->id];
    $company = Company::where('subscriber_id', auth()->user('subscriber')->id)->first();
    $company_id =['company_id' => $company->id];
    
    WorkingTime::create(array_merge(
        $data,
        $subscriber,
        $company_id
    ));

    return response()->json([$data, $subscriber, $company_id]);
}
public function edit_working_time($id){
        
    $working_time = WorkingTime::findOrFail($id);
        //  $this->authorize('view', $service);
    return response()->json([ $working_time]);
    
}

public function update_working_time(Request $request, $id){
    
      $data = Company::where('subscriber_id', auth()->user('subscriber')->id)->first();
            $post = request()->all();
            $oldData = WorkingTime::findOrFail($id);
                //  $this->authorize('view', $oldData);
            $user = ['subscriber_id' => auth('subscriber')->user()->id];
            $company = ['company_id' => $data->id];
    
            $oldData->update(array_merge(
                $post,
                $user,
                $company
            ));
            return response()->json([$user, $post]);
    }

    public function add_company_rating(Request $request)
{
    $data = request()->all();
    $subscriber = ['subscriber_id' => auth()->user('subscriber')->id];
    $company = Company::where('subscriber_id', auth()->user('subscriber')->id)->first();
    $company_id =['company_id' => $company->id];
    
    CompanyRating::create(array_merge(
        $data,
        $subscriber,
        $company_id
    ));

    return response()->json([$data, $subscriber, $company_id]);
}
   
public function add_company_review(Request $request)
{
    $data = request()->all();
    $subscriber = ['subscriber_id' => auth()->user('subscriber')->id];
    $company = Company::where('subscriber_id', auth()->user('subscriber')->id)->first();
    $company_id =['company_id' => $company->id];
    
    CompanyReview::create(array_merge(
        $data,
        $subscriber,
        $company_id
    ));

    return response()->json([$data, $subscriber, $company_id]);
}
}