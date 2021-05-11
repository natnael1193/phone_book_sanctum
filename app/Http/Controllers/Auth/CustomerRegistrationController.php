<?php

namespace App\Http\Controllers\Auth;

use App\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class CustomerRegistrationController extends Controller
{
    //
    public function index(){
        return view('customer.customer_registration');
    }
        public function register(Request $request)
        {
          request()->validate([
                'email' => 'required|email|unique:customers',
                'phone' => 'required|unique:customers',
                'name'=> 'required',
                //'contact_number' => 'required|contact_number|unique:users',
                'password' => 'required|confirmed|min:6',
            ]
            );
    
                $data = $request->all();
                $check = $this->create($data);
                // $remember_me = $request->has('remember') ? true : false;
    
                return redirect()->back()->with('alert', 'Great! You have Successfully Registered, Please Login');
            }
    
        public function create(array $data)
        {
            return Customer::create([
                'name' => $data['name'],
    //            'lastName' => $data['lastName'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'password' => Hash::make($data['password']),
        
            ]);
        }
    
    
        public function __construct()
        {
            $this->middleware('guest:subscriber')->except('logout');
        }
}