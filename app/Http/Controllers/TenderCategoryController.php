<?php

namespace App\Http\Controllers;

use App\TenderCategory;
use App\Tinder;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class TenderCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $post  = TenderCategory::query()->get()->sortBy('name');
        $category  = TenderCategory::query()->get()->sortBy('name');

        return  view('category.tender_category', compact('post', 'category'));
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

        if(request('image')){
            $imagePath = request('image')->store('uploads','public');
            $image = Image::make(public_path("storage/{$imagePath}"))->resize(300,300);
            $image->save();
            $imageArray=['image' => $imagePath];
        }

        // dd($data,
        // $imageArray, $user);
        TenderCategory::create(array_merge(
            $data,

            $imageArray ?? []

        ));
//        dd($data);
        return redirect()->back();

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
        $data = request()->all();
        $oldData = TenderCategory::findOrFail($id);

        if(request('image')){
            Storage::delete("/public/{$oldData->image}");
            $imagePath = request('image')->store('uploads','public');
            $image = Image::make(public_path("storage/{$imagePath}"))->resize(300,300);
            $image->save();
            $imageArray=['image' => $imagePath];
        }

        $oldData->update(array_merge(
            $data,
            $imageArray ?? []

        ));
        return redirect('/tender_category');
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
        $post = TenderCategory::findOrFail($id);
        $student = Tinder::where('batch_id', $post->id)->exists();

        if($student != true){
            TenderCategory::findOrFail($id)->delete();
            return redirect()->back();
        }
        else{
            return redirect()->back()->with('message', 'Tender Registered With This Tender Category, Please Delete The Tender First');
        }
    }
}
