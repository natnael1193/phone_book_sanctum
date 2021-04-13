<?php

namespace App\Http\Controllers;

use App\Company;
use App\Category;
use App\CompanyCategory;
use Illuminate\Http\Request;
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
    public function index()
    {
        //
        if(Auth::guard('subscriber')->check()) {
            $this->user = Auth::guard('subscriber')->user();
            $this->subscriber = true;    

}
elseif(Auth::guard()->check()) {
    $this->user = Auth::guard()->user();
    $this->subscriber = false;
    $company = Company::all();
    $user = auth()->user()->companies()->pluck('companies.user_id');
    $post = Company::whereIn('user_id', $user)->orderBy('created_at', 'desc')->paginate(5);
    $all = Company::all();
   
return view('company.company', compact('post', 'company', 'all'));
} else {
    return redirect('/login');
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
            if(Auth::guard()->check()) {
        $post = Category::all()->sortBy('name');
        $company_category = CompanyCategory::all()->sortBy('name');
        return view('company.add_company', compact('post', 'company_category'));
            }
            else{
                return redirect('/login');
            }
        // return view('company.add_company');
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
   return redirect('/company');
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
        return view('company.edit_company', compact('post', 'category','company_category'));
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

return redirect('/company');
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
    }
}