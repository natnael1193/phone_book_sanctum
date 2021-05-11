<?php

namespace App\Http\Controllers\Api\Auth;

use App\Subscriber;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class SubscriberRegistrationController extends Controller
{
    //
public function index(){
    return view('company_owner.company_owner_registration');
}
    public function register(Request $request)
    {
      request()->validate([
            'email' => 'required|email|unique:subscribers',
            'name'=> 'required',
            //'contact_number' => 'required|contact_number|unique:users',
            'password' => 'required|confirmed|min:6',
        ]
        );

            $data = $request->all();
            $check = $this->create($data);
            // $remember_me = $request->has('remember') ? true : false;

            return response()->json($data);
        }

    public function create(array $data)
    {
        return Subscriber::create([
            'name' => $data['name'],
//            'lastName' => $data['lastName'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
    
        ]);
    }


    public function __construct()
    {
        $this->middleware('guest:subscriber')->except('logout');
    }
}