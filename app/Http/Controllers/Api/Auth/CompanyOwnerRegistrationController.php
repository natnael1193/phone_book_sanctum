<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\CompanyOwner;
use App\Company;
use App\Subscriber;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

class CompanyOwnerRegistrationController extends Controller
{
    public function index()
    {
        return view('company_owner.company_owner_registration');
    }

    public function register(Request $request)
    {
        $company = $request->company_email;
        if ($company != null) {

            request()->validate([
                'email' => 'required|email|unique:company_owners',
                'first_name' => 'required',
                'last_name' => 'required',
                'company_name' => 'required',
                'company_email' => 'required',
                'phone' => 'required',
                'password' => 'required|confirmed|min:6',
                'image' => ""
            ]);
        } else {
            request()->validate([
                'email' => 'required|email|unique:subscribers',
                'first_name' => 'required',
                'last_name' => 'required',
                'phone' => 'required',
                'image' => "",
                'status_id' => "",
                'password' => 'required|confirmed|min:6',
            ]);
        }
if(CompanyOwner::whereEmail($request->email)->exists() || Subscriber::whereEmail($request->email)->exists())
{
    return response()->json(['errors' => "The email has already been taken."]);
}
else{
    $data = request()->all();
    $check = $this->save($data);

    $user = $request->validate([
        'email' => 'required',
        'password' => 'required',
    ]);
    $company_owner = CompanyOwner::whereEmail($request->email)->first();
    $owner = CompanyOwner::where('company_email', $request->company_email)->first();
    $subscriber = Subscriber::whereEmail($request->email)->first();
    $sub = Subscriber::first();

    if ($owner == true) {
        $company = Company::where('subscriber_id', $company_owner->id)->first();
        // $subscriber_company = CompanyOwner::where('company_email', $company_owner->company_email)->first();

        return ["id" => $company_owner->id, "first_name" => $company_owner->first_name, "last_name" => $company_owner->last_name, 'image' => $company_owner->image,  "email" => $company_owner->email, "company_id" => $company->id, "company_name" => $company->company_name, "company_email" => $company->company_email, "company_phone" => $company->phone_number, 'type' => 'company_owner',"token" => $company_owner->createToken('API Token')->plainTextToken];
    } elseif ($sub == true) {
        if($request->status_id == 1){
            return ["id" => $subscriber->id, "first_name" => $subscriber->first_name, "last_name" => $subscriber->last_name,  "email" => $subscriber->email, 'type' => 'job_seeker', "token" => $subscriber->createToken('API Token')->plainTextToken];
        }else{
            return ["id" => $subscriber->id, "first_name" => $subscriber->first_name, "last_name" => $subscriber->last_name,  "email" => $subscriber->email, 'type' => 'normal_user', "token" => $subscriber->createToken('API Token')->plainTextToken];
        }

    } else {
        return response([
            'email' => ['The provided credentials are incorrect.'],
        ], 404);
    }
    // return response($data);
}
}

    //
    // }
    public function save(array $data)
    {


        if (request('company_email')) {
            if (request('image')) {
                $imagePath = request('image')->store('uploads', 'public');
                $image = Image::make(public_path("storage/{$imagePath}"))->resize(300, 300);
                $image->save();
                $imageArray = ['image' => $imagePath];



                $user = CompanyOwner::create([
                    'first_name' => $data['first_name'],
                    'last_name' => $data['last_name'],
                    'email' => $data['email'],
                    'company_email' => $data['company_email'],
                    'phone' => $data['phone'],
                    'password' => Hash::make($data['password']),
                    'image' => $imagePath

                ]);
            } else {
                $user = CompanyOwner::create([
                    'first_name' => $data['first_name'],
                    'last_name' => $data['last_name'],
                    'email' => $data['email'],
                    'company_email' => $data['company_email'],
                    'phone' => $data['phone'],
                    'password' => Hash::make($data['password']),

                ]);
            }
            $userId = $user->id;
            Company::create([
                'company_name' => $data['company_name'],
                'subscriber_id' => $userId,
                'company_email' => $data['company_email'],
                'phone_number' => $data['phone_number'],
//                'phone_number' => $data['phone_number'],

            ]);
        } else {
            if (request('status_id')) {
                $status_id = "1";
                Subscriber::create([
                    'first_name' => $data['first_name'],
                    'last_name' => $data['last_name'],
                    'email' => $data['email'],
                    'phone' => $data['phone'],
                    'password' => Hash::make($data['password']),
                    'status_id' =>  1,


                ]);
            } else {
                Subscriber::create([
                    'first_name' => $data['first_name'],
                    'last_name' => $data['last_name'],
                    'email' => $data['email'],
                    'phone' => $data['phone'],
                    'password' => Hash::make($data['password']),

                ]);
            }
        }
    }
    public function __construct()
    {
        $this->middleware('guest:subscriber')->except('logout');
    }
}
