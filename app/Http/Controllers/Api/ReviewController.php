<?php

namespace App\Http\Controllers\Api;

use App\Review;
use App\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReviewController extends Controller
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
        $post = new Review();
        $post->user_id = auth('sanctum')->user()->id;
        $post->blog_id = $request->input('blog_id');
        $post->review = $request->input('review');

        // dd($post);
        $post->save();
        return response($post);
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
        $rating = Review::query()->where('blog_id', $id)->get();

        $post = Review::query()->where('blog_id', $id)->count();

        return response($rating);
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
          //
          $post =  Review::findOrFail($id);
          $post->user_id = auth('sanctum')->user()->id;
          $post->blog_id = $request->input('blog_id');
          $post->review = $request->input('review');
  
          // dd($post);
          $post->save();
          return response($post);
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