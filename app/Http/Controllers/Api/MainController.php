<?php

namespace App\Http\Controllers\Api;

use App\Blog;
use App\CompanyCategory;
use App\Images;
use App\Map;
use App\Rating;
use App\Review;
use App\Subscriber;
use App\Tinder;
use App\Company;
use App\Service;
use App\Vacancy;
use App\Category;
use App\Location;
use App\VacancyCategory;
use App\WorkingTime;
use App\CompanyRating;
use App\CompanyReview;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class MainController extends Controller
{
    //
    public function company()
    {
        $post = Company::all()->toArray();

        for ($x = 0; $x < sizeof($post); $x++) {

            $post[$x]['rating'] = CompanyRating::all()->where('company_id', $post[$x]['id'])->avg('rating');

            [
                $post[$x]['approximate'] = number_format($post[$x]['rating'], 1),
                $post[$x]['location'] = Location::where('id', $post[$x]['location_id'])->first('name'),
                $post[$x]['category'] = Category::where('id', $post[$x]['location_id'])->first('name'),
                $post[$x]['company_type'] = CompanyCategory::where('id', $post[$x]['company_category'])->first('name')
            ];
//            $category[$x]['rating'] = CompanyRating::where('rating' , '>' , 3.9)->get();
        }


        return response()->json($post);

//        $post = Company::all();
////        $post = Company::all();
//        for ($x=0; $x<sizeof($post); $x++ ){
//            return response()->json($post);
//        }
    }

    public function blog()
    {
        $post = Blog::all();
        return response()->json($post);
    }

    public function company_detail($id)
    {

        $post = Company::findOrFail($id);
        $post->count = $post->count + 1;
        $post->save();

        $location = Location::where('id', $post->location_id)->get();
        $service = Service::where('company_id', $id)->get();
        $image = Images::where('company_id', $id)->get();
        $working_time = WorkingTime::where('company_id', $id)->get();
        $map = Map::where('company_id', $id)->first();
//        $date = Vacancy::where('company_id', $id);
        $vacancy = Vacancy::where('company_id', $id)->get();
        $tender = Tinder::where('company_id', $id)->get();
        // $company_location = Company::whereIn('location_id' ,  $location)->first();


//        $review = CompanyReview::query()->where('company_id', $id)->with('subscriber')->get();
        $review = CompanyReview::where('company_id', $id)->get();
        foreach ($review as $reviews) {
            $reviews['subscriber_name'] = $reviews->subscriber()->first()->name;
        }


        $rating = CompanyRating::where('company_id', $id)->get();
        foreach ($rating as $ratings) {
            $ratings['subscriber_name'] = $ratings->subscriber()->first()->name;
        }

        $sum = CompanyRating::query()->where('company_id', $id)->sum('rating');
        $rate = CompanyRating::query()->where('company_id', $id)->first();

        if ($rate != null) {
            $blog = CompanyRating::query()->where('company_id', $id)->count();
            $data = $sum / $blog;
            $value = number_format($data, 1);

            // return response()->json(['blog'=>$post, 'review'=>$review, 'rating'=>$value]);
            return response()->json(['company' => $post, 'service' => $service, 'image' => $image, 'working time' => $working_time, 'review' => $review, 'rating' => $rating, 'average_rating' => $value, 'location' => $location, 'google map' => $map, 'vacancy' => $vacancy, 'tender' => $tender]);
        } else {
            $blog = CompanyRating::query()->where('company_id', $id)->get();
            $data = [];
            $value = $data;

            // return response()->json(['blog'=>$post, 'review'=>$review, 'rating'=>$value]);
            return response()->json(['company' => $post, 'service' => $service, 'image' => $image, 'working time' => $working_time, 'review' => $review, 'rating' => $value, 'location' => $location, 'google map' => $map, 'vacancy' => $vacancy, 'tender' => $tender]);
        }

        // return response()->json(['company' => $post, 'service'=>$service, 'image' => $image, 'working time' => $working_time]);
    }

    public function blog_detail($id)
    {
        $post = Blog::findOrFail($id);
        $review = Review::where('blog_id', $id)->get();
        // $rating = Rating::query()->where('blog_id', $id)->get();

        $sum = Rating::query()->where('blog_id', $id)->sum('rating');
        $rate = Rating::query()->where('blog_id', $id)->first();

        if ($rate != null) {
            $blog = Rating::query()->where('blog_id', $id)->count();
            $data = $sum / $blog;
            $value = number_format($data, 2);

            return response()->json(['blog' => $post, 'review' => $review, 'rating' => $value]);
        } else {
            $blog = Rating::query()->where('blog_id', $id)->get();
            $data = [];
            $value = $data;

            return response()->json(['blog' => $post, 'review' => $review, 'rating' => $value]);
        }

    }

    public function company_category()
    {
        $post = Category::get()->sortBy('name')->skip(1);
        // $service = Service::where('company_id',  $id)->get();

        return response()->json(['company category' => $post]);
    }

    public function company_category_detail($id)
    {
        $post = Category::findOrFail($id);
        $company = Company::where('category_id', $id)->get();

        if ($post->id == 1) {
            return [];
        } else {

            // $sub_category = Category::where('category_id', $id)->get();
            return response()->json(['category' => $post, 'company' => $company]);

        }
        // $service = Service::where('company_id',  $id)->get();

    }


    public function vacancy_category()
    {
        $post = Category::all()->sortBy('name')->skip(1);
//        $post = Category::all()->sortBy('id');
        // $service = Service::where('company_id',  $id)->get();

        return response()->json(['company category' => $post]);
    }

    public function vacancy_category_detail($id)
    {
        $post = Category::findOrFail($id);
        $vacancy = Vacancy::where('category_id', $id)->get();

        if ($post->id == 1) {
            return [];
        } else {

            // $sub_category = Category::where('category_id', $id)->get();
            return response()->json([' category' => $post, 'vacancy' => $vacancy]);

        }
        // $service = Service::where('company_id',  $id)->get();

    }

    public function company_search($id)
    {

        // App::setLocale($lang);
        $data = request()->all();
//        $keyword = $data['company_name'];
        $post = Company::query();

        if ($id != null) {

            $post = $post->where('company_name','LIKE', '%' . $id . '%');
        }
        $post = $post->get();
//        dd($post);
        return response()->json($post);

    }

    public function blog_search()
    {

        // App::setLocale($lang);
        $data = request()->all();
        $keyword = $data['title'];
        $post = Blog::query();

        if ($keyword != null) {

            $post = $post->where('title', 'LIKE', '%' . $keyword . '%');
        }
        $post = $post->get();
//        dd($post);
        return response()->json($post);

    }

    public function vacancy()
    {
        $post = Vacancy::all()->toArray();
//        $location = Location::all();

//        foreach ($post as $posts) {
//            $posts['location'] = $posts->location()->first()->name;
//        }


        for ($x = 0; $x < sizeof($post); $x++) {
          [  $post[$x]['location'] = Location::where('id', $post[$x]['location'])->first('name'),
              $post[$x]['category'] = VacancyCategory::where('id', $post[$x]['category_id'])->first(['name', 'image']),



];
          if($post[$x]['job_type'] == 1){
              $post[$x]['job_type'] = 'permanent';
          }
          elseif ($post[$x]['job_type'] == 2){
              $post[$x]['job_type'] = 'Temporary';
          }
          else{
              $post[$x]['job_type'] = 'Remotely';
          }
        }


        return response()->json($post);
    }

    public function vacancy_detail($id)
    {
        $post = Vacancy::findOrFail($id);
        return response()->json($post);
    }


    public function tender()
    {
        $post = Tinder::all();
        return response()->json($post);
    }

    public function tender_detail($id)
    {
        $post = Tinder::findOrFail($id);
        return response()->json($post);
    }

    public function search_company()
    {

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
        return response()->json($post);

//        return view('company.search', compact('post'));
    }


    public function vacancy_search()
    {

        $data = request()->all();
        $keyword = $data['keyword'];
        $post = Vacancy::query();


        if ($keyword != null) {
            $post = $post->where('title', 'LIKE', '%' . $keyword . '%');
        }
        $post = $post->get();
        return response()->json($post);

//        return view('company.search', compact('post'));
    }

    public function tender_search()
    {

        $data = request()->all();
        $keyword = $data['keyword'];
        $post = Tinder::query();


        if ($keyword != null) {
            $post = $post->where('title', 'LIKE', '%' . $keyword . '%');
        }
        $post = $post->get();
        return response()->json($post);

//        return view('company.search', compact('post'));
    }

    public function top_rated(Request $request)
    {


//    $company = Company::join('company_ratings', 'company_ratings.company_id', '=', 'companies.id')
////            ->where('companies.status', 'active')
//        ->where('company_ratings.company_id', 16)
////            ->sum('rating');
//        ->get(['companies.*','company_ratings.rating']);


//        $stock = DB::table("companies")->pluck("id");
//        $products = DB::table("company_ratings")->whereIn('company_id', $stock)->pluck("rating","id");
//        $value = DB::table("company_ratings")->whereIn('company_id', $stock)->sum('rating');
//       $rating =  CompanyRatings::with('company_id')->whereHas('ratings', function($query) {
//            $query->whereIn('product_filters.filter_id',array(2,3));
//})->get();

//return response()->json($company);

        $category = Company::all()->toArray();

        for ($x = 0; $x < sizeof($category); $x++) {
            $category[$x]['rating'] = CompanyRating::all()->where('company_id', $category[$x]['id'])->avg('rating');
            if ($category[$x]['rating'] >= 4) {
                $category[$x]['approximate'] = number_format($category[$x]['rating'], 1);
            }
        }

        $res = array_values($category);
        return response()->json($res);

//        foreach ($category as $categories){
//            $res = array_values($categories);
//            return  response()->json($res);
//        }


    }
}
