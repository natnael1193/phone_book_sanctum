<?php

namespace App\Http\Controllers\Api;

use App\Blog;
use App\CompanyCategory;
use App\Images;
use App\Map;
use App\Rating;
use App\Review;
use App\Subscriber;
use App\TenderCategory;
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


            $post[$x]['approximate'] = number_format($post[$x]['rating'], 1);
            $post[$x]['location'] = Location::where('id', $post[$x]['location_id'])->first('name');
            $post[$x]['category'] = Category::where('id', $post[$x]['category_id'])->first(['name', 'image']);
            $post[$x]['company_type'] = CompanyCategory::where('id', $post[$x]['company_category'])->first('name');

            if ($post[$x]['verification'] == 1) {
                $post[$x]['verification'] = 'verified';
            } else {
                $post[$x]['verification'] = 'not verified';
            }
//            $category[$x]['rating'] = CompanyRating::where('rating' , '>' , 3.9)->get();
        }


        return response()->json(['company' => $post]);

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

//    public function company_detail($id)
//    {
//
//        $post = Company::findOrFail($id);
//        $post->count = $post->count + 1;
//        $post->save();
//
//        $location = Location::where('id', $post->location_id)->first();
//        $service = Service::where('company_id', $id)->get();
//        $image = Images::where('company_id', $id)->get();
//        $working_time = WorkingTime::where('company_id', $id)->get();
//        $map = Map::where('company_id', $id)->first();
//        $vacancy = Vacancy::where('company_id', $id)->get();
//        $tender = Tinder::where('company_id', $id)->get();
//
//        $review = CompanyReview::where('company_id', $id)->get();
//        foreach ($review as $reviews) {
//            $reviews['subscriber_name'] = $reviews->subscriber()->first()->name;
//        }
//
//        $rating = CompanyRating::where('company_id', $id)->get();
//        foreach ($rating as $ratings) {
//            $ratings['subscriber_name'] = $ratings->subscriber()->first()->name;
//        }
//
//        $sum = CompanyRating::query()->where('company_id', $id)->sum('rating');
//        $rate = CompanyRating::query()->where('company_id', $id)->first();
//
//        if ($rate != null) {
//            $blog = CompanyRating::query()->where('company_id', $id)->count();
//            $data = $sum / $blog;
//            $value = number_format($data, 1);
//
//            // return response()->json(['blog'=>$post, 'review'=>$review, 'rating'=>$value]);
//            return response()->json(['company' => $post, 'service' => $service, 'image' => $image, 'working time' => $working_time, 'review' => $review, 'rating' => $rating, 'average_rating' => $value, 'location' => $location, 'google map' => $map, 'vacancy' => $vacancy, 'tender' => $tender]);
//        } else {
//            $blog = CompanyRating::query()->where('company_id', $id)->get();
//            $data = [];
//            $value = $data;
//
//            // return response()->json(['blog'=>$post, 'review'=>$review, 'rating'=>$value]);
//            return response()->json(['company' => $post, 'service' => $service, 'image' => $image, 'working time' => $working_time, 'review' => $review, 'rating' => $value, 'location' => $location, 'google map' => $map, 'vacancy' => $vacancy, 'tender' => $tender]);
//        }
//
//    }

    public function company_detail($id)
    {
        $post = Company::where('id', $id)->get()->toArray();
        $count = Company::findOrFail($id);
        $count->count = $count->count + 1;
        $count->save();


        for ($x = 0; $x < sizeof($post); $x++) {

            $post[$x]['location'] = Location::where('id', $post[$x]['location_id'])->first();
            $post[$x]['service'] = Service::where('company_id', $post[$x]['id'])->get();
            $post[$x]['image'] = Images::where('company_id', $post[$x]['id'])->get();
            $post[$x]['working_time'] = WorkingTime::where('company_id', $post[$x]['id'])->get();
// if(($post[$x]['working_time'] >= 12)? 'pm' : 'am'){

// }
// $post[$x]['working_time'] = $post([$x]['working_time'] >= 12)? 'pm' : 'am';
            $post[$x]['review'] = CompanyReview::where('company_id', $post[$x]['id'])->get();
            foreach ($post[$x]['review'] as $reviews) {
             $reviews['subscriber_name'] = $reviews->subscriber()->first()->name;
             $reviews['subscriber_image'] = $reviews->subscriber()->first()->image;
            }
            $post[$x]['rating'] = CompanyRating::where('company_id', $id)->get();
            foreach ($post[$x]['rating'] as $ratings) {
                $ratings['subscriber_name'] = $ratings->subscriber()->first()->name;
            }
            $post[$x]['average_rating'] = CompanyRating::where('company_id', $id)->avg('rating');
            $post[$x]['vacancy'] = Vacancy::where('company_id', $post[$x]['id'])->get();
            foreach ($post[$x]['vacancy'] as $job_type) {

                if( $job_type['job_type'] == 1){
                    $job_type['job_type'] = 'Full Time';
                }
                elseif( $job_type['job_type'] == 1){
                    $job_type['job_type'] = 'Per Time';
                }
               else{
                    $job_type['job_type'] = 'Remotely';
                }
               
            }
            $post[$x]['tender'] = Tinder::where('company_id', $post[$x]['id'])->get();
         
    }



    return response()->json(['company' => $post]);
}


//    public function blog_detail($id)
//    {
//        $post = Blog::findOrFail($id);
//        $review = Review::where('blog_id', $id)->get();
//
//
//        $sum = Rating::query()->where('blog_id', $id)->sum('rating');
//        $rate = Rating::query()->where('blog_id', $id)->first();
//
//        if ($rate != null) {
//            $blog = Rating::query()->where('blog_id', $id)->count();
//            $data = $sum / $blog;
//            $value = number_format($data, 2);
//
//            return response()->json(['blog' => $post, 'review' => $review, 'rating' => $value]);
//        } else {
//            $blog = Rating::query()->where('blog_id', $id)->get();
//            $data = [];
//            $value = $data;
//
//            return response()->json(['blog' => $post, 'review' => $review, 'rating' => $value]);
//        }
//
//    }
    public function blog_detail($id)
    {
        $post = Blog::where('id', $id)->get()->toArray();
        for ($x = 0; $x < sizeof($post); $x++) {
            $post[$x]['review'] = Review::where('blog_id', $post[$x]['id'])->get();
            foreach ($post[$x]['review'] as $reviews) {
                $reviews['subscriber_name'] = $reviews->subscriber()->first()->name;
            }
//            $post[$x]['rating'] = Rating::where('blog_id', $id)->get();
//            foreach ($post[$x]['rating'] as $ratings) {
//                $ratings['subscriber_name'] = $ratings->subscriber()->first()->name;
//            }
//            $post[$x]['average_rating'] = Rating::where('blog_id', $id)->avg('rating');
        }

        return response()->json($post);
}
    public function company_category()
    {
        $post = Category::get();
        // $service = Service::where('company_id',  $id)->get();

        return response()->json($post);
    }

    public function company_category_detail($id)
    {
        $post = Category::findOrFail($id);
        $company = Company::where('category_id', $post->id)->get()->toArray();
//        $cat

        for ($x = 0; $x < sizeof($company); $x++) {

            $company[$x]['category'] = Category::where('id', $company[$x]['category_id'])->first('name');
            $company[$x]['average_rating'] = CompanyRating::where('company_id', $company[$x]['id'])->avg('rating');
            $company[$x]['location'] = Location::where('id', $company[$x]['category_id'])->first('name');
        }

        return response()->json($company);

    }


    public function vacancy_category()
    {
        $post = VacancyCategory::all()->sortBy('name');
//        $post = Category::all()->sortBy('id');
        // $service = Service::where('company_id',  $id)->get();

        return response()->json($post);
    }

    public function tender_category()
    {
        $post = TenderCategory::all()->sortBy('name');
//        $post = Category::all()->sortBy('id');
        // $service = Service::where('company_id',  $id)->get();

        return response()->json($post);
    }

    public function vacancy_category_detail($id)
    {
        $post = VacancyCategory::findOrFail($id);
        $company = Vacancy::where('category_id', $post->id)->get()->toArray();
//        $cat

        for ($x = 0; $x < sizeof($company); $x++) {

            $company[$x]['category'] = VacancyCategory::where('id', $company[$x]['category_id'])->first('name');
            if ($company[$x]['job_type'] == 1) {
                $company[$x]['job_type'] = 'Full Time';
            } elseif ($company[$x]['job_type'] == 2) {
                $company[$x]['job_type'] = 'Per Time';
            } else {
                $company[$x]['job_type'] = 'Remotely';
            }

        }

        return response()->json($company);

    }

    public function company_search($id)
    {

        // App::setLocale($lang);
        $data = request()->all();
//        $keyword = $data['company_name'];
        $post = Company::query();

        if ($id != null) {

            $post = $post->where('company_name', 'LIKE', '%' . $id . '%');
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
            [$post[$x]['location'] = Location::where('id', $post[$x]['location'])->first('name'),
                $post[$x]['category'] = VacancyCategory::where('id', $post[$x]['category_id'])->first(['name', 'image']),


            ];
            if ($post[$x]['job_type'] == 1) {
                $post[$x]['job_type'] = 'Full Time';
            } elseif ($post[$x]['job_type'] == 2) {
                $post[$x]['job_type'] = 'Per Time';
            } else {
                $post[$x]['job_type'] = 'Remotely';
            }
        }


        return response()->json($post);
    }

    public function vacancy_detail($id)
    {
        $post = Vacancy::findOrFail($id);
//        $category = VacancyCategory::whereIn('id', $post)->first(['name', 'image']);
        $vacancy = Vacancy::where('category_id', $post->category_id)->get();


        return response()->json([$post, $vacancy]);
    }


    public function tender()
    {
        $post = Tinder::all();
        for ($x = 0; $x < sizeof($post); $x++) {
            [
                $post[$x]['category'] = TenderCategory::where('id', $post[$x]['category_id'])->first(['name', 'image'])
            ];

        }
        return response()->json($post);
    }

    public function tender_detail($id)
    {
        $post = Tinder::findOrFail($id);
//        $category = TenderCategory::where('id', $post->category_id)->first(['name', 'image']);
        $tender = Tinder::where('category_id', $post->category_id)->get();


        return response()->json([$post, $tender]);
    }

    public function tender_category_detail($id)
    {
        $post = TenderCategory::findOrFail($id);
        $company = Tinder::where('category_id', $post->id)->get()->toArray();
//        $cat

        for ($x = 0; $x < sizeof($company); $x++) {

            $company[$x]['category'] = TenderCategory::where('id', $company[$x]['category_id'])->first('name');
        }

        return response()->json($company);

//        }
        // $service = Service::where('company_id',  $id)->get();

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

        $data = CompanyRating::query()->groupBy('company_id')->get()->toArray();

        for ($x = 0; $x < sizeof($data); $x++) {
            $data[$x]['company'] = Company::where('id', $data[$x]['company_id'])->first();
            $data[$x]['rating'] = CompanyRating::whereIn('company_id', $data[$x]['company'])->avg('rating');


        }

//        $post = Company::get();
//        foreach ($post as $datum) {
//            return $datum;
//        }
        return response()->json($data);

    }


    public function verified_companies(Request $request)
    {
        $post = Company::where('verification', 1)->get();

        return response()->json($post);

    }

    public function recommended_companies(Request $request)
    {
        $post = Company::where('company_category', 2)->get();

        return response()->json($post);

    }
}
