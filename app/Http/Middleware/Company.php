<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Company
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!Auth::check()){
            return redirect()->route('login');
        }
        
        //Admin
        if(Auth::user()->role == 1){
            return redirect()->route('admin');    
        }
       //Manager
       if(Auth::user()->role == 2){
        return redirect()->route('manager');
    }
         //User
         if(Auth::user()->role == 3){
            return redirect()->route('user');   
        }
             //Encoder
       if(Auth::user()->role == 4){
        return redirect()->route('encoder');
    }
    if(Auth::user()->role == 5){
        return redirect()->route('bloger');
    }
    if(Auth::user()->role == 6){
     return $next($request);      
    }
    }
}