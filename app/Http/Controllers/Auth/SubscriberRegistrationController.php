<?php

namespace App\Http\Controllers\Auth;

use App\Company;
use App\Subscriber;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

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
            // 'company_email' => 'unique:companies',
            //'contact_number' => 'required|contact_number|unique:users',
            'password' => 'required|confirmed|min:6',
              'image'=> ''
        ]
        );
            $data = $request->all();
//             dd($data);
//               $check = $this->create($data);
                 $check = $this->save($data);


            // dd($data);
            // $remember_me = $request->has('remember') ? true : false;
            return redirect('/subscriber/sign_in')->with('alert', 'You have Successfully Registered, Please Login');
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
                // $check = $this->save($data);


            // dd($data);
            // $remember_me = $request->has('remember') ? true : false;
            return redirect('/subscriber/sign_in')->with('alert', 'You have Successfully Registered, Please Login');
        }

        public function save(array $data)
        {
            if (request('image')) {
                $imagePath = request('image')->store('uploads', 'public');
                $image = Image::make(public_path("storage/{$imagePath}"))->resize(300, 300);
                $image->save();
                $imageArray = ['image' => $imagePath];
            }

              $user =  Subscriber::create([
                'name' => $data['name'],
    //            'lastName' => $data['lastName'],
                'email' => $data['email'],
                'company_email' => $data['company_email'],
                'password' => Hash::make($data['password']),
                 'image' => $imagePath

            ]);
            $userId = $user->id;

            if($user ->company_email != null)
            Company::create([
                'company_name' => $data['name'],
               'subscriber_id' => $userId,
                'company_email' => $data['company_email'],
                'phone_number' => $data['phone_number'],
'image' => $data[$imagePath]
            ]);

        }


    public function __construct()
    {
        $this->middleware('guest:subscriber')->except('logout');
    }
}
