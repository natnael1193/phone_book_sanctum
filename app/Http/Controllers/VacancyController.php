<?php

namespace App\Http\Controllers;

use App\Company;
use App\Vacancy;
use App\Category;
use App\VacancyCategory;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class VacancyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        //
        $post = Vacancy::query()->orderBy('created_at', "DESC")->paginate(10);
        return view('vacancy.vacancy', compact('post'));
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
        $category = VacancyCategory::all()->sortBy('name');
        return view('vacancy.add_vacancy', compact('company', 'category'));
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
        if(request('image')){
            $imagePath = request('image')->store('uploads','public');
            $image = Image::make(public_path("storage/{$imagePath}"))->resize(300,300);
            $image->save();
            $imageArray=['image' => $imagePath];
        }

        // dd($data, $user);
        Vacancy::create(array_merge(
            $data,
            $user,
            $imageArray ?? []
        ));
        return redirect()->back()->with('message', 'Vacancy Added Successfully');
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
        $post = Vacancy::findOrFail($id);
        $category = VacancyCategory::all()->sortBy('name');

        return view('vacancy.edit_vacancy', compact('post', 'category'));
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
        $oldData = Vacancy::findOrFail($id);
        $user = ['user_id' => auth()->user()->id];
        if(request('image')){
            Storage::delete("/public/{$oldData->image}");
            $imagePath = request('image')->store('uploads','public');
            $image = Image::make(public_path("storage/{$imagePath}"))->resize(300,300);
            $image->save();
            $imageArray=['image' => $imagePath];
        }

        $oldData->update(array_merge(
            $data,
            $imageArray ?? [],
            $user
        ));

        return redirect('/vacancy')->with('message', 'Vacancy Updated Successfully');
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
        Vacancy::findOrFail($id)->delete();
        return redirect()->back()->with('message1', 'Vacancy Deleted Successfully');
    }
}
