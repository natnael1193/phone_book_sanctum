<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;


class CustomerController extends Controller
{
    //
    // public function __construct()
    // {
    //     $this->middleware('auth:customer');
    // }
    public function index(){        
        // $post = Company::query()->where('email',auth()->user('subscriber')->email)->first();    
        // $user = Subscriber:: where('email',auth()->user('subscriber'));    
        return view('customer.customer');
       
    }
}