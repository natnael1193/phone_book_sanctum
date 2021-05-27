<?php

namespace App\Http\Controllers;

use App\Rating;
use App\Company;
use App\Category;
use Carbon\Carbon;
use App\CompanyCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

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
        if (Auth::guard('subscriber')->check()) {
            $this->user = Auth::guard('subscriber')->user();
            $this->subscriber = true;
        } elseif (Auth::guard()->check()) {
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

        if (Auth::guard('subscriber')->check()) {
            $this->user = Auth::guard('subscriber')->user();
            $this->subscriber = true;
        } elseif (Auth::guard()->check()) {
            $this->user = Auth::guard()->user();
            $this->subscriber = false;
            $company = Company::all();
            $user = auth()->user()->companies()->pluck('companies.user_id');
            $post = Company::whereIn( 'user_id',$user)->orderBy('created_at', 'desc')->paginate(15);
            $all = Company::orderBy('created_at', 'desc')->paginate(15);

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
        if (Auth::guard()->check()) {
            $post = Category::all()->sortBy('name');
            $company_category = CompanyCategory::all()->sortBy('name');
            return view('company.add_company', compact('post', 'company_category'));
        } else {
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
        $user = ['user_id' => auth()->user()->id];
        if (request('company_logo_path')) {
            $imagePath = request('company_logo_path')->store('uploads', 'public');
            $image = Image::make(public_path("storage/{$imagePath}"))->resize(300, 300);
            $image->save();
            $imageArray = ['company_logo_path' => $imagePath];
        }
        //    $subscriber =['user_id' => auth()->user('subscriber')->id];
        //    dd( $data, $user, $imageArray);
        Company::create(array_merge(
            $data,
            $user,
            $imageArray
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

        $company = Company::find($id);
        $this->authorize('view', $company);
        $post = $company;
        $category = Category::all();
        $company_category = CompanyCategory::all()->sortBy('name');

        return view('company.edit_company', compact('post', 'category', 'company_category'));
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

        // $oldData = $job;\
        $oldData = Company::findOrFail($id);
        $user = ['user_id' => auth()->user()->id];
        if(request('company_logo_path')){
            Storage::delete("/public/{$oldData->company_logo_path}");
            $imagePath = request('company_logo_path')->store('uploads', 'public');
            $image = Image::make(public_path("storage/{$imagePath}"))->resize(300, 300);
            $image->save();
            $imageArray = ['company_logo_path' => $imagePath];
        }

        $oldData->update(array_merge(
            $data,
            $user,
            $imageArray ?? [],
        ));

        return redirect('/company');
    }

    public function verified(Request $request, $id)
    {
        //

        $data = request()->all();

        // $oldData = $job;\
        $oldData = Company::findOrFail($id);
        $user = ['user_id' => auth()->user()->id];
        $verification = ['verification' => 1];
        // dd($data,   $user,
        // $verification
        // );
        $oldData->update(array_merge(
            $data,
            $user,
            $verification
        ));

        return redirect()->back();
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
        $company = Company::find($id);
        $this->authorize('delete', $company);
        Company::findOrfail($id)->delete();
        return redirect()->back();
    }

    public function register(Request $request)
    {
        //
        if (Auth::guard('subscriber')->check()) {
            $this->user = Auth::guard('subscriber')->user();
            $this->subscriber = true;
            $data = request()->all();
            //    $user=['user_id' => auth()->user()->id];
            // $subscriber = ['subscriber_id' => auth()->user('subscriber')->id];
            //    dd( $data);
            Company::create(array_merge(
                $data

            ));
            return redirect()->back();
        }
    }

    public function automatic_update($id, Request $request)
    {
        $post = Company::findOrFail($id);

        $post->verification = 1;
        $post->save();

        abort_if(
            $post->created_at < Carbon::now()->subHours(24),
            422,
            "Updating is no longer available."
        );

        // proceed as ussual (validate, save, fire events, etc)
    }
}