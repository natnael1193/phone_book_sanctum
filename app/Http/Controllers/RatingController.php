<?php

namespace App\Http\Controllers;

use App\Rating;
use App\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RatingController extends Controller
{
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
        $post = new Rating();
        $post->user_id = auth()->user()->id;
        $post->blog_id = $request->input('blog_id');
        $post->rating = $request->input('rating');

        // dd($post);
        $post->save();
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
        $data = Company::findOrFail($id);
        $rating = Rating::query()->where('blog_id', $id)->get();
        $sum =  Rating::query()->where('blog_id', $id)->sum('rating') ;
        $post = Rating::query()->where('blog_id', $id)->count();
        // $data =  ($sum/$post) ;
        $data = 0 ? array() : $data= $sum/$post ;
        $value = $data;
        return view('rating.rating', compact('rating', 'sum', 'value'));
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