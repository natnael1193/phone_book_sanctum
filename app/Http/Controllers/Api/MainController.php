<?php

namespace App\Http\Controllers\Api;

use App\Blog;
use App\Category;
use App\Company;
use App\Service;
use App\Http\Controllers\Controller;
use App\Images;
use App\Rating;
use App\Review;
use App\WorkingTime;

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
        $image = Images::where('company_id', $id)->get();
        $working_time = WorkingTime::where('company_id', $id)->get();
        
        return response()->json(['company' => $post, 'service'=>$service, 'image' => $image, 'working time' => $working_time]);
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
    
    }
    public function company_category(){
        $post = Category::all()->sortBy('id');
        // $service = Service::where('company_id',  $id)->get();
        
        return response()->json(['company category' => $post]);
    }
    
      public function company_category_detail($id){
        $post = Category::findOrFail($id);
        
        if($post->id == 1)
         {
            $sub_category = Category::where('category_id', $id)->get(); 
            return response()->json(['company category' => $post, 'main category' => $sub_category]);
         }
         else{
             
        $sub_category = Category::where('category_id', $id)->get(); 
        return response()->json([' category' => $post, 'sub category' => $sub_category]);

         }
        // $service = Service::where('company_id',  $id)->get();
        
       
    }
}