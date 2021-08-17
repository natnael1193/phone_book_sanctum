<?php

namespace App\Http\Controllers;

use App\Tinder;
use App\Company;
use App\CompanyOwner;
use App\Notifications\TenderNotification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Location;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Mail;

class TinderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        //

        // $user = auth()->user()->tinders()->pluck('tinders.user_id');
        // $post = Tinder::whereIn('user_id', $user)->orderBy('created_at', 'desc')->paginate(5);
        $post = Tinder::orderBy('created_at', 'desc')->paginate(5);
        // return response()->json($post);
        return view('tinder.tinder', compact('post'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $company = Company::all()->sortBy('name');
        $locations = Location::all()->sortBy('name');
        return view('tinder.add_tinder', compact('company', 'locations'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd(request()->all());
        $data = request()->validate([
            'title' => 'required',
            'description' => '',
            'title_am' => 'required',
            'description_am' => '',
            'image' => '',
            'price' => 'required',
            'bond' => '',
            'type' => '',
            'location' => 'required',
            'company_id' => 'required',
            'reference' => 'required',
            'reference_date' => 'required',
            'location' => '',
            'sub_category_id' => '',
            'opening_date' => 'required',
            'closing_date' => 'required',
            'tender_sub_category_id' => ''
        ]);
        $user = ['user_id' => auth()->user()->id];
        if (request('image')) {
            $imagePath = request('image')->store('uploads', 'public');
            $image = Image::make(public_path("storage/{$imagePath}"))->resize(300, 300);
            $image->save();
            $imageArray = ['image' => $imagePath];
        }

        // dd($data,
        // $imageArray, $user);
        Tinder::create(array_merge(
            $data,
            $user,
            $imageArray ?? [],

        ));

        //    dd($data);
        return redirect('/tender')->with('message', 'Tender Added Successfully');
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
        $locations = Location::all()->sortBy('name');
        $tinder = Tinder::find($id);
        // $this->authorize('view', $tinder);
        $post = $tinder;
        // return response()->json($post);
        $company = Company::all()->sortBy('name');
        return view('tinder.edit_tinder', compact('post', 'company', 'locations'));
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
        $oldData = Tinder::findOrFail($id);
        $user = ['user_id' => auth()->user()->id];
        if (request('image')) {
            Storage::delete("/public/{$oldData->image}");
            $imagePath = request('image')->store('uploads', 'public');
            $image = Image::make(public_path("storage/{$imagePath}"))->resize(300, 300);
            $image->save();
            $imageArray = ['image' => $imagePath];
        }

        $oldData->update(array_merge(
            $data,
            $imageArray ?? [],
            $user
        ));
        return redirect('/tender')->with('message', 'Tender Updated Successfully');;
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
        $post = Tinder::findOrFail($id)->delete();
        // return response()->json($post);
        return redirect()->back()->with('message1', 'Tender Deleted Successfully');
    }
}
