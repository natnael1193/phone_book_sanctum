<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Company;
use App\Category;
use App\CompanyCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $user;

    protected $subscriber = false;

    // public function __construct()
    // {
    //     if(Auth::guard('subscriber')->check()) {
    //         $this->user = Auth::guard('subscriber')->user();
    //         $this->subscriber = true;
    //     } elseif(Auth::guard()->check()) {
    //         $this->user = Auth::guard()->user();
    //         $this->subscriber = false;
    //     } else {
    //         return response()->json([
    //             'message' => 'Not Authorized',
    //         ], 401);
    //     }
    // }

    
    public function index()
    {
        //
        // $user = Company::where('user_id', auth()->user()->id)->get();
        $this->authorize('viewAny', Company::class);

        if(Auth::guard('subscriber')->check()) {
            $this->user = Auth::guard('subscriber')->user();
            $this->subscriber = true;    
}
elseif(Auth::guard()->check()) {
    $this->user = Auth::guard()->user();
    $this->subscriber = false;
    $company = Company::all();
    $user = auth()->user()->companies()->pluck('companies.user_id');
    $post = Company::whereIn('user_id', $user)->orderBy('created_at', 'desc')->get();
    $all = Company::all();
   
    
    return  response()->json($company);
// return view('company.company', compact('post', 'company', 'all'));
} else {
    return response([
        'email' => ['The provided credentials are incorrect.'],
    ], 404);
}
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $data = request()->all();
   $user=['user_id' => auth()->user()->id];
//    dd( $data, $user);
   Company::create(array_merge(
       $data, $user
   ));
   return response([
    $data, $user
], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $company=Company::find($id);
        $this->authorize('view', $company);
        $post = $company;
        $category = Category::all();
        $company_category = CompanyCategory::all()->sortBy('name');

        return  response()->json($post);
  
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $data = request()->all();
        $user=['user_id' => auth()->user()->id];
        // $oldData = $job;\
        $oldData = Company::findOrFail($id);

    $oldData->update(array_merge(
            $data,
            $user
        ));
        return response([
            $data, $user
        ], 200);
        
    }

    public function verified(Request $request, $id)
    {
        //
        $data = request()->all();
        $user=['user_id' => auth()->user()->id];
        // $oldData = $job;\
        $oldData = Company::findOrFail($id);

    $oldData->update(array_merge(
            $data,
            $user
        ));
        return response([
            $data, $user
        ], 200);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $company=Company::find($id);
        $this->authorize('delete', $company);
        Company::findOrfail($id)->delete();
        return response(
            'Company Deleted'
       );
    }

    public function register(Request $request)
    {
        //
          
        $data = request()->validate([
            'subscriber_id' => 'unique:companies',        
            
        ]);
   $subscriber=['subscriber_id' => auth('subscriber')->user()->id];
   Company::create(array_merge(
       $data,  $subscriber      
   ));
   return response()->json([$data, $subscriber]);
    }    

}