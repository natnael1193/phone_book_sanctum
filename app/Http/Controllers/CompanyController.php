<?php

namespace App\Http\Controllers;

use App\Rating;
use App\Company;
use App\Service;
use App\Category;
use App\Location;
use Carbon\Carbon;
use App\WorkingTime;

use App\CompanyCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
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
            $company = Company::query()->orderBy('created_at', 'desc')->paginate(15);;
            $user = auth()->user()->companies()->pluck('companies.user_id');
            $post = Company::query()->whereIn( 'user_id',$user)->where('verification', !NULL)->orderBy('created_at', 'desc')->paginate(15);
            $all = Company::query()->orderBy('created_at', 'desc')->paginate(15);
            $location = Location::all();

            return view('company.company', compact('post', 'company', 'all', 'location'));
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
            $location = Location::all()->sortBy('name');
            $all = Company::all()->sortBy('name');
            return view('company.add_company', compact('post', 'company_category', 'location', 'all'));
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

        $data = $request->all();
        // dd($data);
           $check = $this->save($data);
        
        return redirect('/company');
    }

    public function save(array $data){
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
     $company = Company::create(array_merge(
            $data,
            $user,
            $imageArray ?? []
     ));


 
        // $company_id = ['company_id' => $company->id];
        // $user =  auth()->user('subscriber')->id;
        

            
        WorkingTime::create([
            'user_id' => auth()->user()->id,
            'company_id' => $company->id,
            'monday_open' => $data['monday_open'],
            'tuesday_open' => $data['tuesday_open'],
            'wednesday_open' => $data['wednesday_open'],
            'thursday_open' => $data['thursday_open'],
            'friday_open' => $data['friday_open'],
            'saturday_open' => $data['saturday_open'],
           
            
            'monday_closed' => $data['monday_closed'],
            'tuesday_closed' => $data['tuesday_closed'],
            'wednesday_closed' => $data['wednesday_closed'],
            'thursday_closed' => $data['thursday_closed'],
            'friday_closed' => $data['friday_closed'],
            'saturday_closed' => $data['saturday_closed'],
            
        
        ]);
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

        $company = Company::findOrFail($id);
        $this->authorize('view', $company);
        $post = $company;
        $category = Category::all();
        $company_category = CompanyCategory::all()->sortBy('name');
        $location = Location::all()->sortBy('name');
        $available_hour = WorkingTime::where('company_id', $id)->first();
        $service = Service::where('company_id', $id)->get();
        $all = Company::all()->sortBy('name');
        
        return view('company.edit_company', compact('post', 'category', 'company_category', 'location', 'available_hour', 'service', 'all'));
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
        $available_hour = WorkingTime::where('company_id', $id)->first();
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

        
        $company_id = ['company_id' => $oldData->id];
$check_company  = WorkingTime::where('company_id', '=', \Request::get($oldData->id))->first();
        
if($check_company === true){
    WorkingTime::create(array_merge(
        $data,
        $user,
        $company_id
    ));
    }
    else{
        $available_hour->update(array_merge(
            $data,
            $user,
            $company_id
        ));
    }
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

    public function call_update(Request $request, $id)
    {
        $data = request()->all();

        // $oldData = $job;\
        $oldData = Company::findOrFail($id);
        $user = ['user_id' => auth()->user()->id];
        // $call = ['called' => 1];
        // dd($data,   $user,
        // $verification
        // );
        $oldData->update(array_merge(
            $data,
            $user,
            // $call
        ));

        return redirect()->back();

        // proceed as ussual (validate, save, fire events, etc)
    }


    public function search_location(){
        
        $data = request()->all();
        $location = $data['location'];
        $post = Company::query();

        if ($location != -1) {
            $post = $post->where('location_id', $location);
        }
     $post = $post->get();
      return response()->json($post );

        return view('company.search', compact('post'));
    }
    
    public function search_company(){
        
    $data = request()->all();
    $keyword = $data['keyword'];
    $location = $data['location'];
    $post = Company::query();

    if ($location != -1) {
        $post = $post->where('location_id', $location);
    }
    if ($keyword != null) {
        $post = $post->where('company_name', 'LIKE', '%' . $keyword . '%');
    }
 $post = $post->get();
  return response()->json($post );

    return view('company.search', compact('post'));
}
}