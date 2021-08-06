<?php

namespace App\Http\Controllers;

use App\TenderSubCategory;
use App\Tinder;
use Illuminate\Http\Request;

class TenderSubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $post  = TenderSubCategory::query()->get()->sortBy('name');
        $category  = TenderSubCategory::query()->get()->sortBy('name');

        return  view('category.tender_subcategory', compact('post', 'category'));
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
        $data = request()->all();
        
        TenderSubCategory::create($data);
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
        $oldData = TenderSubCategory::findOrFail($id);

        $oldData->update($data);
        return redirect('/tender_sub_category');
    }

    /**
     * Remove the specified resource from storage.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = TenderSubCategory::findOrFail($id);
        $student = Tinder::where('batch_id', $post->id)->exists();

        if ($student != true) {
            TenderSubCategory::findOrFail($id)->delete();
            return redirect()->back();
        } else {
            return redirect()->back()->with('message', 'Tender Registered With This Tender Category, Please Delete The Tender First');
        }
    }
}
