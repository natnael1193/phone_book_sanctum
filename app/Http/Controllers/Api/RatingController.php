<?php

namespace App\Http\Controllers\Api;

use App\Blog;
use App\Rating;
use App\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RatingController extends Controller
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
        $post->user_id = auth('sanctum')->user()->id;
        $post->blog_id = $request->input('blog_id');
        $post->rating = $request->input('rating');

        // dd($post);
        $post->save();
        return response()->json($post);
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
        $data = Blog::findOrFail($id);
        // $item = Company::query()->where($id, $data )->get();
        $rating = Rating::query()->where('blog_id', $id)->get();
        $sum =  Rating::query()->where('blog_id', $id)->sum('rating') ;
        $post = Rating::query()->where('blog_id', $id)->count();
        // $data =  ($sum/$post) ;
        

        
        $data = null ? array() : $data= $sum/$post ;
        // $data =  ($sum/$post) ;
        $value = $data;
        return response()->json($value);
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
        $post =  Rating::findOrFail($id);
        $post->user_id = auth('sanctum')->user()->id;
        $post->blog_id = $request->input('blog_id');
        $post->rating = $request->input('rating');

        // dd($post);
        $post->save();
        return response()->json($post);
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