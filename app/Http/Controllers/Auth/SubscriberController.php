<?php

namespace App\Http\Controllers\Auth;

use App\Company;
use App\Subscriber;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class SubscriberController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:subscriber');
    }
    public function index(){        
        $post = Company::query()->where('email',auth()->user('subscriber')->email)->first();     
        return view('company_owner.company_owner', compact('post'));
       
    }
    public function edit(){
        
        $post = Company::where('email',auth()->user('subscriber')->email)->first();   
        
        return view('company_owner.company_owner_edit', compact('post'));
    }
    public function store(Request $request){

        $data = request()->all();
        $oldData = Company::where('email',auth()->user('subscriber')->email)->first();   
//    $user=['user_id' => auth()->user()->id];
//    dd( $data, $user);
//    Company::create(array_merge(
//        $data
//    ));
   $oldData->update(array_merge(
    $data,
));
        return redirect('/subscriber');
    }
}