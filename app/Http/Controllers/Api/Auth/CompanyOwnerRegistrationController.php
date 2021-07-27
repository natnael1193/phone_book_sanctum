<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\CompanyOwner;
use App\Company;
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
        $data = request()->validate([ 
        'first_name' => 'required',
        'last_name' => 'required',
        'email' => 'required|unique:company_owners',
         'company_email' => 'required',
         'company_name' => 'required',
        'phone_number' => 'required',
        'password' => 'required|confirmed|min:6',
        'image' => ""]);
       
        // $check = $this->save($data);
        $check = $this->save($data);
       
        $user = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        $subscriber = CompanyOwner::whereEmail($request->email)->first();
        $company = Company::where('subscriber_id', $subscriber->id)->first();
        if (!$subscriber || !Hash::check($request->password, $subscriber->password)) {
            return response([
                'email' => ['The provided credentials are incorrect.'],
            ], 404);
        }

        $subscriber_company = CompanyOwner::where('company_email', $subscriber->company_email)->first();  
            return ["id" => $subscriber->id, "first_name" => $subscriber->first_name,"last_name" => $subscriber->last_name, 'image' => $subscriber->image,  "email" => $subscriber->email, "company_id" => $company->id, "company_name" => $company->company_name, "company_email" => $company->company_email, "company_phone" => $company->phone_number, "token" => $subscriber->createToken('API Token')->plainTextToken];   
        }
        
    public function save(array $data)
    {
        if(request('image')){
            $imagePath = request('image')->store('uploads','public');
            $image = Image::make(public_path("storage/{$imagePath}"))->resize(300,300);
            $image->save();
            $imageArray=['image' => $imagePath];



            $user = CompanyOwner::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'company_email' => $data['company_email'],
            'password' => Hash::make($data['password']),
            'image' => $imagePath

        ]);
    }
        else {
            $user = CompanyOwner::create([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'company_email' => $data['company_email'],
                'password' => Hash::make($data['password']),
                
            ]);
        }
        $userId = $user->id;
        Company::create([
            'company_name' => $data['company_name'],
            'subscriber_id' => $userId,
            'company_email' => $data['company_email'],
            'phone_number' => $data['phone_number'],
            'phone_number' => $data['phone_number'],

        ]);
        }

    public function __construct()
    {
        $this->middleware('guest:subscriber')->except('logout');
    }
}
