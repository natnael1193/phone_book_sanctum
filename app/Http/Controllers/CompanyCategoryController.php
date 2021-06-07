<?php

namespace App\Http\Controllers;

use App\CompanyCategory;
use Illuminate\Http\Request;

class CompanyCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $post = CompanyCategory::all()->sortBy('name');
        return view('company_category.company_category', compact('post'));
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
    //    $post = request()->all();
    //    if(count($request->name) > 0){
    //        foreach($request->name as $item=>$v){
    //        $post2=array(
    //            'name' => $request->name[$item],
    //        );
    //     CompanyCategory::create(array_merge(
    //         $post,
    //         $post2
            
    //     ));
    //    }}
       
       $post = new CompanyCategory();
       $post->name = $request->input('name');
       $post->save();
           return redirect()->back();
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
    // public function submitData()
}