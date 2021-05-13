<?php

namespace App\Http\Controllers;

use App\Images;
use App\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;


class ImageController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth:subscriber');
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $user = Company::query()->where('email',Auth::user()->email)->first();
        return view('image.add_image', compact('user'));
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
     $data = request()->validate([
        'user_id' => '',
        'company_id' => '',
        'image1' => '',
        'image2' => '',
        'image3' => '',
        'image4' => '',
        'image5' => '',
    ]);
    $user=['user_id' => auth()->user('subscriber')->id];
    
    if(request('image1')){
        $imagePath = request('image1')->store('uploads','public');
        $image = Image::make(public_path("storage/{$imagePath}"))->resize(300,300);
        $image->save();
        $imageArray1=['image1' => $imagePath];
    }
    if(request('image2')){
        $imagePath = request('image2')->store('uploads','public');
        $image = Image::make(public_path("storage/{$imagePath}"))->resize(300,300);
        $image->save();
        $imageArray2=['image2' => $imagePath];
    }
    if(request('image3')){
        $imagePath = request('image3')->store('uploads','public');
        $image = Image::make(public_path("storage/{$imagePath}"))->resize(300,300);
        $image->save();
        $imageArray3=['image3' => $imagePath];
    }
    if(request('image4')){
        $imagePath = request('image4')->store('uploads','public');
        $image = Image::make(public_path("storage/{$imagePath}"))->resize(300,300);
        $image->save();
        $imageArray4=['image4' => $imagePath];
    }    if(request('image5')){
        $imagePath = request('image5')->store('uploads','public');
        $image = Image::make(public_path("storage/{$imagePath}"))->resize(300,300);
        $image->save();
        $imageArray5=['image5' => $imagePath];
    }
    // dd($data,
    // $imageArray1 ?? [],
    // $imageArray2 ?? [],
    // $imageArray3 ?? [],
    // $imageArray4 ?? [],
    // $imageArray5 ?? [],$user);
    
    Images::create(array_merge(
        $data,
        $user,
        $imageArray1 ?? [],
        $imageArray2 ?? [],
        $imageArray3 ?? [],
        $imageArray4 ?? [],
        $imageArray5 ?? [],
        
    ));
//    dd($data);
return redirect('/image');
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