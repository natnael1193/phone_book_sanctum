<?php

namespace App\Http\Controllers\Api\Auth;

use App\Company;
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
        $company = $request->company_email;
      
        if($company!= null){
                
      request()->validate([
            'email' => 'required|email|unique:subscribers',
            'name'=> 'required',
            'company_email' => 'unique:subscribers',
            'phone_number' => 'unique:companies',
            //'contact_number' => 'required|contact_number|unique:users',
            'password' => 'required|confirmed|min:6',
        ]
        );
        }
        else{
            request()->validate([
                'email' => 'required|email|unique:subscribers',
                'name'=> 'required',
                // 'company_email' => 'unique:subscribers',
                // 'phone_number' => 'unique:companies',
                //'contact_number' => 'required|contact_number|unique:users',
                'password' => 'required|confirmed|min:6',
            ]);
        }

            // dd($data);
            $data = request()->all();
               $check = $this->save($data);
                // $check = $this->save($data);

            $user = $request->validate([
                'email' => 'required',
                'password' => 'required',
            ]);
            $subscriber = Subscriber::whereEmail($request->email)->first();
            if (!$subscriber || !Hash::check($request->password, $subscriber->password)) {
                return response([
                    'email' => ['The provided credentials are incorrect.'],
                ], 404);
            }
            return [$subscriber->createToken('my-token')->plainTextToken, $data];

        }

        public function store(Request $request)
        {
          request()->validate([
                'email' => 'required|email|unique:subscribers',
                'name'=> 'required',
                // 'company_email' => 'unique:subscribers',
                'password' => 'required|confirmed|min:6',
            ]
            );

            // $items = request()
                $data = $request->all();
                $check = $this->create($data);
                // $post = $this->save($data);
                // dd($check);
                // $remember_me = $request->has('remember') ? true : false;
                
                return redirect('/company/create')->with('alert', 'User registered, please add ccompany profile');
            }

            
    public function create(array $data)
    {
        return [Subscriber::create([
            'name' => $data['name'],
//            'lastName' => $data['lastName'],
            'email' => $data['email'],
            'company_email' => $data['company_email'],
            'password' => Hash::make($data['password']),
    
        ])
        ];
    }

    
    public function subscriber_company_register(Request $request)
    {
      request()->validate([
            'email' => 'required|email|unique:subscribers',
            'name'=> 'required',
            // 'company_email' => 'unique:companies',
            //'contact_number' => 'required|contact_number|unique:users',
            'password' => 'required|confirmed|min:6',
        ]
        );
            $data = $request->all();
            // dd($data);
               $check = $this->save($data);

            return redirect('/subscriber/sign_in')->with('alert', 'You have Successfully Registered, Please Login');
        }

        public function save(array $data)
        {
          
            
              $user =  Subscriber::create([
                'name' => $data['name'],
    //            'lastName' => $data['lastName'],
                'email' => $data['email'],
                'company_email' => $data['company_email'],
                'password' => Hash::make($data['password']),
        
            ]);
            $userId = $user->id;
            // $userCompanyEmail =  $user->company_email;
            
            if($user ->company_email != null){
            Company::create([
                'company_name' => $data['name'],
               'subscriber_id' => $userId,
               'company_email' => $data['company_email'],
                'phone_number' => $data['phone_number'],
            
            ]);
         
        }
    
    }

    
    public function __construct()
    {
        $this->middleware('guest:subscriber')->except('logout');
    }
}