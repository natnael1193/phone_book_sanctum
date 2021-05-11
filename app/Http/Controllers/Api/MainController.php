<?php

namespace App\Http\Controllers\Api;

use App\Blog;
use App\Company;
use App\Service;
use App\Http\Controllers\Controller;
use App\Rating;
use App\Review;

class MainController extends Controller
{
    //
    public function company(){
        $post = Company::all();
        return response()->json($post);
    }

    public function blog(){
        $post = Blog::all();   
        return response()->json($post);
    }

    public function company_detail($id){
        $post = Company::findOrFail($id);
        $service = Service::where('company_id',  $id)->get();
        
        return response()->json(['company' => $post, 'service'=>$service]);
    }
    
    public function blog_detail($id){
        $post = Blog::findOrFail($id);
        $review = Review::where('blog_id',  $id)->get();        
        // $rating = Rating::query()->where('blog_id', $id)->get();
        
        $sum =  Rating::query()->where('blog_id', $id)->sum('rating');
        $rate = Rating::query()->where('blog_id', $id)->first();

        if($rate != null){
        $blog = Rating::query()->where('blog_id', $id)->count();
        $data =  $sum/$blog;
        $value = $data;
    
        return response()->json(['blog'=>$post, 'review'=>$review, 'rating'=>$value]);
    }
    else{
        $blog = Rating::query()->where('blog_id', $id)->get();
        $data = [];
        $value = $data; 
    
        return response()->json(['blog'=>$post, 'review'=>$review, 'rating'=>$value]);
    }


        // $data =  ($sum/$post) ;

        // $data =  ($sum/$post) ;
    
    
    }
}