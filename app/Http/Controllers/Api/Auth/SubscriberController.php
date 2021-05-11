<?php

namespace App\Http\Controllers\Api\Auth;

use App\Company;
use App\Category;
use App\Subscriber;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class SubscriberController extends Controller
{
    //
    protected $user;

    protected $subscriber = false;

    public function __construct()
    {
        if(Auth::guard('subscriber')->check()) {
            $this->user = Auth::guard('subscriber')->user();
            $this->subscriber = true;
        } elseif(Auth::guard()->check()) {
            $this->user = Auth::guard()->user();
            $this->subscriber = false;
        } else {
            return response()->json([
                'message' => 'Not Authorized',
            ], 401);
        }
    }

    
    public function index(){        
        $post =  Company::where('subscriber_id', auth()->user('subscriber')->id)->first();
        // $user = Subscriber:: where('email',auth()->user('subscriber'));    
        return response()->json($post);
       
    }
    public function edit(){
        
        $post =  Company::where('subscriber_id', auth()->user('subscriber')->id)->first();
        
        return response()->json($post);
    }
    public function store(Request $request){

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

    
public function new_company(){        
    // $post = Company::query()->where('email',auth()->user('subscriber')->email)->first();    
    // $user = Subscriber:: where('email',auth()->user('subscriber'));    
    $post = Category::all()->sortBy('name');
    return response()->json($post);
   
}

public function create(){       
    
    
    $data = request()->all();
//    $user=['user_id' => auth()->user()->id];
//    dd( $data, $user);
   Company::create(array_merge(
       $data
   ));
   return response()->json($data);
   
}

}