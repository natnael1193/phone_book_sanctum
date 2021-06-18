<?php

namespace App\Http\Controllers\Api;

use App\Blog;
use App\Images;
use App\Rating;
use App\Review;
use App\Subscriber;
use App\Tinder;
use App\Company;
use App\Service;
use App\Vacancy;
use App\Category;
use App\Location;
use App\WorkingTime;
use App\CompanyRating;
use App\CompanyReview;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;

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

    public function company_detail($id)
    {
        $post = Company::findOrFail($id);

        $location = Location::where('id', $post->location_id)->get();
        $service = Service::where('company_id', $id)->get();
        $image = Images::where('company_id', $id)->get();
        $working_time = WorkingTime::where('company_id', $id)->get();
        // $company_location = Company::whereIn('location_id' ,  $location)->first();


//        $review = CompanyReview::query()->where('company_id', $id)->with('subscriber')->get();
        $review = CompanyReview::get();
        foreach ($review as $reviews){
            $reviews['company_id'] = $reviews->subscriber()->first()->name;
        }
$rating = CompanyRating::get();
        foreach ($rating as $ratings){
            $ratings['company_id'] = $ratings->subscriber()->first()->name;
        }

        $sum =  CompanyRating::query()->where('company_id', $id)->sum('rating');
        $rate = CompanyRating::query()->where('company_id', $id)->first();

        if($rate != null){
        $blog = CompanyRating::query()->where('company_id', $id)->count();
        $data =  $sum/$blog;
        $value = $data;

        // return response()->json(['blog'=>$post, 'review'=>$review, 'rating'=>$value]);
        return response()->json(['company' => $post, 'service'=>$service, 'image' => $image, 'working time' => $working_time, 'review'=> $review, 'rating' => $rating,'average_rating'=>$value, 'location' => $location]);
    }
    else{
        $blog = CompanyRating::query()->where('company_id', $id)->get();
        $data = [];
        $value = $data;

        // return response()->json(['blog'=>$post, 'review'=>$review, 'rating'=>$value]);
        return response()->json(['company' => $post, 'service'=>$service, 'image' => $image, 'working time' => $working_time, 'review'=>[ $review], 'rating'=>$value, 'location' => $location]);
    }

        // return response()->json(['company' => $post, 'service'=>$service, 'image' => $image, 'working time' => $working_time]);
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
        $company = Company::where('category_id', $id)->get();

        if($post->id == 1)
         {
return [];
         }
         else{

        // $sub_category = Category::where('category_id', $id)->get();
        return response()->json([' category' => $post, 'company' => $company]);

         }
        // $service = Service::where('company_id',  $id)->get();

    }

public function company_search(){

    // App::setLocale($lang);
    $data=request()->all();
    $keyword=$data['company_name'];
    $post=Company::query();

    if ($keyword!=null){

        $post= $post->where('company_name','LIKE','%'.$keyword.'%');
    }
    $post=$post->get();
//        dd($post);
    return response()->json($post);

}

public function blog_search(){

    // App::setLocale($lang);
    $data=request()->all();
    $keyword=$data['title'];
    $post=Blog::query();

    if ($keyword!=null){

        $post= $post->where('title','LIKE','%'.$keyword.'%');
    }
    $post=$post->get();
//        dd($post);
    return response()->json($post);

}

public function vacancy(){
    $post = Vacancy::all();
    return response()->json($post);
}
public function vacancy_detail($id){
    $post = Vacancy::findOrFail($id);
    return response()->json($post);
}


public function tender(){
    $post = Tinder::all();
    return response()->json($post);
}

public function tender_detail($id){
    $post = Tinder::findOrFail($id);
    return response()->json($post);
}

public function search_company(){

    $data = request()->all();
    $keyword = $data['keyword'];
    $location = $data['location'];
    $post = Company::query();

    if ($location != -1) {
        $post = $post->where('location_id', $location);
    }
    if ($keyword != null) {
        $post = $post->where('company_name', 'LIKE', '%' . $keyword . '%');
    }
 $post = $post->get();
  return response()->json($post );

    return view('company.search', compact('post'));
}


}
