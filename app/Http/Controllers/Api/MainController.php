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
use App\CompanyOwner;
use App\Location;
use App\VacancyCategory;
use App\TenderSubCategory;
use App\WorkingTime;
use App\CareerLevel;
use App\CompanyRating;
use App\CompanyReview;
use \Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use App\JobType;
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

        return response()->json($post);
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

        $location = Location::where('id', $post->location_id)->first();
        $service = Service::where('company_id', $id)->get();
        $image = Images::where('company_id', $id)->get();
        $working_time = WorkingTime::where('company_id', $id)->get();
        $map = Map::where('company_id', $id)->first();
        //        $date = Vacancy::where('company_id', $id);
        $vacancy = Vacancy::where('company_id', $id)->get();
        $tender = Tinder::where('company_id', $id)->get();
        // $company_location = Company::whereIn('location_id' ,  $location)->first();

        foreach ($vacancy as  $vacancies) {
            $vacancies['job_type'] = JobType::where('id', $vacancies['job_type'])->first()->name;
            $vacancies['location'] = Location::where('id', $vacancies['location'])->first()->name;
            $vacancies['category_id'] = VacancyCategory::where('id', $vacancies['category_id'])->first(['id', 'image', 'name']);
        }

        //        $review = CompanyReview::query()->where('company_id', $id)->with('subscriber')->get();
        // $review = CompanyReview::where('company_id', $id)->get();
        // foreach ($review as $reviews) {
        //     $reviews['subscriber_name'] = $reviews->subscriber()->first()->name;
        //      $reviews['subscriber_image'] = $reviews->subscriber()->first()->image;
        // }


        $rating = CompanyRating::where('company_id', $id)->get();
        foreach ($rating as $ratings) {
            $ratings['subscriber_name'] = $ratings->subscriber()->first(['image', 'first_name', 'last_name']);
            $ratings['rating'] = number_format($ratings->rating, 1);
        }

        $sum = CompanyRating::query()->where('company_id', $id)->sum('rating');
        $rate = CompanyRating::query()->where('company_id', $id)->first();

        if ($rate != null) {
            $blog = CompanyRating::query()->where('company_id', $id)->count();
            $data = $sum / $blog;
            $value = number_format($data, 1);

            // return response()->json(['blog'=>$post, 'review'=>$review, 'rating'=>$value]);
            return response()->json(['company' => $post, 'service' => $service, 'images' => $image, 'working_time' => $working_time, 'rating' => $rating, 'average_rating' => $value, 'location' => $location, 'google map' => $map, 'vacancy' => $vacancy, 'tender' => $tender]);
        } else {
            $blog = CompanyRating::query()->where('company_id', $id)->get();
            $data = null;
            $value = $data;

            // return response()->json(['blog'=>$post, 'review'=>$review, 'rating'=>$value]);
            return response()->json(['company' => $post, 'service' => $service, 'images' => $image, 'working_time' => $working_time, 'rating' => $rating, 'average_rating' => $data, 'location' => $location, 'google map' => $map, 'vacancy' => $vacancy, 'tender' => $tender]);
        }

        // return response()->json(['company' => $post, 'service'=>$service, 'image' => $image, 'working_time' => $working_time]);
    }

    public function blog_detail($id)
    {
        $post = Blog::findOrFail($id);
        $review = Review::where('blog_id', $id)->get();
        // $rating = Rating::query()->where('blog_id', $id)->get();

        foreach ($review as $reviews) {
            $reviews['subscriber_name'] = $reviews->subscriber()->first()->name;
            $reviews['subscriber_image'] = $reviews->subscriber()->first()->image;
        }

        return response()->json(['blog' => $post, 'review' => $review]);
    }

    public function company_category()
    {
        $post = Category::orderBy('name', 'asc')->get()->toArray();

        for ($x = 0; $x < sizeof($post); $x++) {
            $post[$x]['companies'] = Company::where('category_id', $post[$x]['id'])->count();
        }
        return response()->json($post);
    }

    public function company_category_detail($id)
    {
        //    $post = Category::findOrFail($id);
        $value = Category::where('id', $id)->exists();
        $company = Company::where('category_id', $id)->get()->toArray();
        $count = Company::where('category_id', $id)->count();


        if ($value == true) {
            for ($x = 0; $x < sizeof($company); $x++) {

                $company[$x]['category'] = Category::where('id', $company[$x]['category_id'])->first('name');
                $company[$x]['average_rating'] = CompanyRating::where('company_id', $company[$x]['id'])->avg('rating');
                $company[$x]['location'] = Location::where('id', $company[$x]['category_id'])->first('name');
            }

            return response()->json($company);
        } else {
            return response()->json(["message" => "No Companies Found"]);
        }
    }


    public function vacancy_category()
    {
        $post = VacancyCategory::get();
        foreach ($post as $posts) {
            $posts['number_of_vacancies'] = Vacancy::where('category_id',  $posts['id'])->count();
        }

        return response()->json($post);
    }

    public function some_vacancy_categories()
    {
        $post = VacancyCategory::take(7)->get();
        //        $post = Category::all()->sortBy('id');
        // $service = Service::where('company_id',  $id)->get();

        foreach ($post as $posts) {
            $dt = Carbon::now()->toDateString();
            $posts['number_of_vacancies'] = Vacancy::where('category_id',  $posts['id'])->where('due_date', '>=', $dt)->count();
        }

        return response()->json($post);
    }

    public function number_of_vacancy_categories()
    {
        $post = VacancyCategory::take(9)->get();
        //        $post = Category::all()->sortBy('id');
        // $service = Service::where('company_id',  $id)->get();

        foreach ($post as $posts) {
            $dt = Carbon::now()->toDateString();
            $posts['number_of_vacancies'] = Vacancy::where('category_id',  $posts['id'])->where('due_date', '>=', $dt)->count();
        }

        return response()->json($post);
    }
    public function featured_vacancies()
    {
        $company = Company::where('company_category', 1)->get();

        foreach ($company as $companies) {
            // $companies['vacancies'] = Vacancy::where('company_id',  $companies['id'])->get();
            $dt = Carbon::now()->toDateString();
            $companies['number_of_vacancies'] = Vacancy::where('company_id',  $companies['id'])->where('due_date', '>=', $dt)->count();
        }
        $collection = collect($company);
        $filtered = $collection->where('number_of_vacancies', '!=', 0)->values();

        return response()->json($filtered);
    }
    public function tender_category()
    {
        $post = TenderCategory::all();
        //        $post = Category::all()->sortBy('id');
        // $service = Service::where('company_id',  $id)->get();
        foreach ($post as $posts) {
            $posts['sub_category'] = TenderSubCategory::where('tender_category_id', $posts['id'])->get();
        }

        return response()->json($post);
    }

    public function vacancy_category_detail($id)
    {
        $post = VacancyCategory::findOrFail($id);
        $company = Vacancy::where('category_id', $post->id)->get()->toArray();
        //        $cat

        // for ($x = 0; $x < sizeof($company); $x++) {

        //     $company[$x]['category'] = VacancyCategory::where('id', $company[$x]['category_id'])->first('name');
        //     if ($company[$x]['job_type'] == 1) {
        //         $company[$x]['job_type'] = 'Temporary';
        //     } elseif ($company[$x]['job_type'] == 2) {
        //         $company[$x]['job_type'] = 'Permanent';
        //     } else {
        //         $company[$x]['job_type'] = 'Remotely';
        //     }
        // }
        for ($x = 0; $x < sizeof($company); $x++) {
            $company[$x]['category'] = VacancyCategory::where('id', $company[$x]['category_id'])->first('name');
            $company[$x]['location'] = Location::where('id', $company[$x]['location'])->first('name');
            $company[$x]['job_type'] = JobType::where('id', $company[$x]['job_type'])->first('name');
        }


        return response()->json($company);
    }


    public function any_search($id)
    {

        $post = Company::where('company_name', 'LIKE', '%' . $id . '%')->get();
        $vacancy = Vacancy::where('title', 'LIKE', '%' . $id . '%')->get();
        $tender = Tinder::where('title', 'LIKE', '%' . $id . '%')->get();


        if ($id != null) {
            foreach ($post as  $posts) {
                $posts['rating'] = CompanyRating::all()->where('company_id', $posts['id'])->avg('rating');
                $posts['approximate'] = number_format($posts['rating'], 1);
                $posts['location'] = Location::where('id', $posts['location_id'])->first('name');
                $posts['category'] = Category::where('id', $posts['category_id'])->first(['name', 'image']);
                $posts['company_type'] = CompanyCategory::where('id', $posts['company_category'])->first('name');
            }
        }
        if ($id != null) {
            foreach ($vacancy as  $vacancies) {
                $vacancies['company'] = Company::where('id', $vacancies['company_id'])->first(['id', 'company_name']);
                $vacancies['location'] = Location::where('id', $vacancies['location'])->first('name');
                $vacancies['category'] = VacancyCategory::where('id', $vacancies['category_id'])->first(['name', 'image']);
                $vacancies['posted_date'] = Carbon::parse($vacancies['created_at'])->diffForHumans();
                $vacancies['due_date'] = Carbon::parse($vacancies['due_date'])->format('d-m-Y');
            }
        }
        if ($id != null) {
            foreach ($tender as  $tenders) {
                $tenders['company'] = Company::where('id', $tenders['company_id'])->first(['id', 'company_name']);
                $tenders['category'] = TenderCategory::where('id', $tenders['category_id'])->first(['id', 'name', 'image']);
                $tenders['posted_date'] = Carbon::parse($tenders['created_at'])->diffForHumans();
                $tenders['opening_date'] = Carbon::parse($tenders['opening_date'])->format('d-m-Y');
                $tenders['closing_date'] = Carbon::parse($tenders['closing_date'])->format('d-m-Y');
                $tenders['reference_date'] = Carbon::parse($tenders['reference_date'])->format('d-m-Y');
            }
        }

        return response()->json(['company' => $post, 'vacancy' => $vacancy, 'tender' => $tender]);
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
        $dt = Carbon::now()->toDateString();
        $post = Vacancy::where('due_date', '>=', $dt)->get()->toArray();

        for ($x = 0; $x < sizeof($post); $x++) {
            [
                $post[$x]['company'] = Company::where('id', $post[$x]['company_id'])->first('company_name'),
                $post[$x]['location'] = Location::where('id', $post[$x]['location'])->first('name'),
                $post[$x]['category'] = VacancyCategory::where('id', $post[$x]['category_id'])->first(['id', 'name', 'image']),
                $post[$x]['job_type'] = JobType::where('id', $post[$x]['job_type'])->first('name'),
                $post[$x]['posted_date'] = Carbon::parse($post[$x]['created_at'])->diffForHumans(),
                $post[$x]['due_date'] = Carbon::parse($post[$x]['due_date'])->format('d-m-Y')
                // $post[$x]['date'] =  Carbon::createFromFormat('Y-m-d', $post[$x]['created_at'])->format('d/m/Y')
            ];
        }


        return response()->json($post);
    }

    public function vacancy_detail($id)
    {
        $post = Vacancy::findOrFail($id);
        $post->company = Company::where('id', $post->company_id)->first();
        $post->due_date = Carbon::parse($post->due_date)->format('d-m-Y');
        $post->location = Location::where('id', $post->location)->first();
        $post->job_type = JobType::where('id', $post->job_type)->first();
        // $post->category_id = VacancyCategory::where('id', $post->category_id)->first();

        $related = Vacancy::where('category_id', $post->category_id)->where('id', '!=', $post->id)->get();
        foreach ($related as $relates) {
            $relates['company'] = Company::where('id', $relates['company_id'])->first('company_name');
            $relates['job_type'] = JobType::where('id', $relates['job_type'])->first();
            $relates['location'] = Location::where('id', $relates['location'])->first();
            $relates['category_id'] = VacancyCategory::where('id', $relates['category_id'])->first();
        }
        return response()->json(['vacancy' => $post, 'related' => $related]);
    }


    public function tender()
    {
        $dt = Carbon::now()->toDateString();
        $post = Tinder::where('closing_date', '>=', $dt)->orderBy('created_at', 'desc')->get();

        // $post = Tinder::all();
        foreach ($post as $posts) {
            $posts['company'] = Company::where('id', $posts['company_id'])->first(['id', 'company_name']);
            $posts['category_id'] = TenderSubCategory::where('id', $posts['tender_sub_category_id'])->first(['id', 'name']);
            $posts['location'] = Location::where('id', $posts['location'])->first('name');
            //                $oDates['oDate'] = DateTime::createFromFormat('d.m.Y H:i:s A.', 'opening_date');
            $posts['opening_date'] = Carbon::parse($posts['opening_date'])->format('G:ia d-m-Y');
            $posts['closing_date'] = Carbon::parse($posts['closing_date'])->format('G:ia d-m-Y');
            $posts['reference_date'] = Carbon::parse($posts['reference_date'])->format('d-m-Y');
            $posts['posted_date'] = Carbon::parse($posts['created_at'])->diffForHumans();

            // foreach($posts['category_id'] as $categories){
            //     $categories['sub_category'] = TenderSubCategory::where('tender_category_id', $categories['id'])->get();
            // }

        }
        return response()->json($post);
    }

    public function tender_detail($id)
    {
        $post = Tinder::findOrFail($id);
        $category = TenderCategory::where('id', $post->category_id)->first(['id', 'name', 'image']);

        return response()->json(['tender' => $post, 'category' => $category]);
    }

    public function tender_category_detail($id)
    {
        $post = TenderSubCategory::findOrFail($id);
        $dt = Carbon::now()->toDateString();
        $tender = Tinder::where('tender_sub_category_id', $id)->orderBy('created_at', 'desc')->where('closing_date', '>=', $dt)->get();

        for ($x = 0; $x < sizeof($tender); $x++) {

            $tender[$x]['category'] = TenderSubCategory::where('id', $tender[$x]['tender_sub_category_id'])->first('name');
            $tender[$x]['location'] = Location::where('id', $tender[$x]['location'])->first();
            $tender[$x]['opening_date'] = Carbon::parse($tender[$x]['opening_date'])->format('G:ia d-m-Y');
            $tender[$x]['closing_date'] = Carbon::parse($tender[$x]['closing_date'])->format('G:ia d-m-Y');
            $tender[$x]['reference_date'] = Carbon::parse($tender[$x]['reference_date'])->format('d-m-Y');
            $tender[$x]['posted_date'] = Carbon::parse($tender[$x]['created_at'])->diffForHumans();
        }

        return response()->json($tender);

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


    public function vacancy_search($id)
    {

        // App::setLocale($lang);
        $data = request()->all();
        //        $keyword = $data['company_name'];
        $post = Vacancy::query();

        if ($id != null) {
            $post = $post->where('title', 'LIKE', '%' . $id . '%');
        }

        $dt = Carbon::now()->toDateString();
        $post = $post->where('due_date', '>=', $dt)->get();
        foreach ($post as $posts) {
            $posts['company'] = Company::where('id', $posts['company_id'])->first(['id', 'company_name']);
            $posts['due_date'] = Carbon::parse($posts['due_date'])->format('d-m-Y');
            $posts['category'] = TenderCategory::where('id', $posts['category_id'])->first();
            $posts['location'] = Location::where('id', $posts['location'])->first();
            $posts['job_type'] = JobType::where('id', $posts['job_type'])->first();
        }
        return response()->json($post);
    }
    public function vacancy_category_search()
    {
        $data = request()->all();
        $keyword = $data['keyword'];
        $category = $data['category'];
        $location = $data['location'];
        $post = Vacancy::query();

        if ($category != null) {
            $post = $post->where('category_id', $category);
        }
        if ($keyword != null) {
            $post = $post->where('title', 'LIKE', '%' . $keyword . '%');
        }
        if ($location != null) {
            $post = $post->where('location', $location);
        }
        $dt = Carbon::now()->toDateString();
        $post = $post->where('due_date', '>=', $dt)->get();
        // $post = $post->get();
        foreach ($post as $posts) {
            $posts['company'] = Company::where('id', $posts['company_id'])->first(['id', 'company_name']);
            $posts['due_date'] = Carbon::parse($posts['due_date'])->format('d-m-Y');
            $posts['category'] = TenderCategory::where('id', $posts['category_id'])->first();
            $posts['location'] = Location::where('id', $posts['location'])->first();
            $posts['job_type'] = JobType::where('id', $posts['job_type'])->first();
        }

        return response()->json($post);
    }
    public function tender_search($id)
    {


        $data = request()->all();
        $post = Tinder::query();

        if ($id != null) {

            $post = $post->where('title', 'LIKE', '%' . $id . '%');
        }
        $dt = Carbon::now()->toDateString();
        $post = $post->where('closing_date', '>=', $dt)->get();
        foreach ($post as $posts) {
            $posts['company'] = Company::where('id', $posts['company_id'])->first(['id', 'company_name']);
            $posts['category'] = TenderSubCategory::where('id', $posts['tender_sub_category_id'])->first('name');
            $posts['location'] = Location::where('id', $posts['location'])->first();
            $posts['opening_date'] = Carbon::parse($posts['opening_date'])->format('d-m-Y');
            $posts['closing_date'] = Carbon::parse($posts['closing_date'])->format('d-m-Y');
            $posts['reference_date'] = Carbon::parse($posts['reference_date'])->format('d-m-Y');
            $posts['posted_date'] = Carbon::parse($posts['created_at'])->diffForHumans();
        }
        return response()->json($post);
    }
    public function tender_category_search()
    {
        $data = request()->all();
        $keyword = $data['keyword'];
        $category = $data['tender_sub_category_id'];
        $location = $data['location'];
        $post = Tinder::query();

        if ($category != null) {
            $post = $post->where('tender_sub_category_id', $category);
        }
        if ($keyword != null) {
            $post = $post->where('title', 'LIKE', '%' . $keyword . '%');
        }
        if ($location != null) {
            $post = $post->where('location', $location);
        }
        $dt = Carbon::now()->toDateString();
        $post = $post->where('closing_date', '>=', $dt)->get();
        // $post = $post->get();
        foreach ($post as $posts) {
            $posts['company'] = Company::where('id', $posts['company_id'])->first(['id', 'company_name']);
            $posts['category'] = TenderSubCategory::where('id', $posts['tender_sub_category_id'])->first('name');
            $posts['location'] = Location::where('id', $posts['location'])->first();
            $posts['opening_date'] = Carbon::parse($posts['opening_date'])->format('d-m-Y');
            $posts['closing_date'] = Carbon::parse($posts['closing_date'])->format('d-m-Y');
            $posts['reference_date'] = Carbon::parse($posts['reference_date'])->format('d-m-Y');
            $posts['posted_date'] = Carbon::parse($posts['created_at'])->diffForHumans();
        }

        return response()->json($post);
    }
    public function top_rated()
    {

        $company = Company::get();
        // $rating = CompanyRating::where('company_id', $company->id)->get();

        foreach ($company as  $companies) {
            $companies['rating'] = CompanyRating::where('company_id', $companies['id'])->avg('rating');

            // $vacancies['category'] = VacancyCategory::where('id', $vacancies['category_id'])->first(['name', 'image']);
            // $vacancies['posted_date'] = Carbon::parse($vacancies['created_at'])->diffForHumans();
            // $vacancies['due_date'] = Carbon::parse($vacancies['due_date'])->format('d-m-Y');
        }
        $value = $company->where('rating', '>=', 3);

        return response()->json($value);
    }

    // return response()->json($value);




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

    public function latest_companies()
    {
        $post = Company::orderBy('id', 'DESC')->take(5)->get();

        return response()->json($post);
    }
    public function similar_business($id)
    {
        $post = Category::findOrFail($id);
        $company = Company::where('category_id', $post->id)->take(3)->get();

        for ($x = 0; $x < sizeof($company); $x++) {

            $company[$x]['category_id'] = Category::where('id', $company[$x]['category_id'])->first('name');
            $company[$x]['average_rating'] = CompanyRating::where('company_id', $company[$x]['id'])->avg('rating');
            $company[$x]['location_id'] = Location::where('id', $company[$x]['category_id'])->first('name');
        }

        return response()->json($company);
    }
    public function latest_vacancies()
    {
        $dt = Carbon::now()->toDateString();
        $post = Vacancy::where('due_date', '>=', $dt)->orderBy('id', 'DESC')->take(5)->get()->toArray();

        for ($x = 0; $x < sizeof($post); $x++) {
            [
                $post[$x]['company'] = Company::where('id', $post[$x]['company_id'])->first('company_name'),
                $post[$x]['location'] = Location::where('id', $post[$x]['location'])->first('name'),
                $post[$x]['category_id'] = VacancyCategory::where('id', $post[$x]['category_id'])->first(['name', 'image']),
                $post[$x]['job_type'] = JobType::where('id', $post[$x]['job_type'])->first('name'),
                $post[$x]['posted_date'] = Carbon::parse($post[$x]['created_at'])->diffForHumans(),
                $post[$x]['due_date'] = Carbon::parse($post[$x]['due_date'])->format('d-m-Y')
                // $post[$x]['date'] =  Carbon::createFromFormat('Y-m-d', $post[$x]['created_at'])->format('d/m/Y')
            ];
        }
        return response()->json($post);
    }
    public function latest_tenders()
    {
        $dt = Carbon::now()->toDateString();
        $post = Tinder::where('closing_date', '>=', $dt)->orderBy('id', 'DESC')->take(5)->get();

        foreach ($post as $posts) {
            $posts['category_id'] = TenderSubCategory::where('id', $posts['tender_sub_category_id'])->get(['id', 'name']);
            $posts['location'] = Location::where('id', $posts['location'])->first('name');
            $posts['opening_date'] = Carbon::parse($posts['opening_date'])->format('G:ia d-m-Y');
            $posts['closing_date'] = Carbon::parse($posts['closing_date'])->format('G:ia d-m-Y');
            $posts['reference_date'] = Carbon::parse($posts['reference_date'])->format('d-m-Y');
            $posts['posted_date'] = Carbon::parse($posts['created_at'])->diffForHumans();
        }

        return response()->json($post);
    }
    public function job_type_vacancy($id)
    {
        $dt = Carbon::now()->toDateString();
        $post = Vacancy::where('job_type', $id)->where('due_date', '>=', $dt)->orderBy('id', 'DESC')->get();
        return response()->json($post);
    }
    public function featured_companies()
    {
        $post = Company::orderBy('id', 'DESC')->where('company_category', 1)->get();

        foreach ($post as $posts) {
            $posts['company'] = Company::where('id', $posts['company_id'])->first(['id', 'company_name']);
            $posts['vacancies'] = Vacancy::where('company_id', $posts['id'])->get();
        }
        return response()->json($post);
    }
    public function career_levels()
    {
        $post = CareerLevel::orderBy('name', 'asc')->get();

        return response()->json($post);
    }
    public function job_types()
    {
        $post = JobType::orderBy('name', 'asc')->get();
        return response()->json($post);
    }
    public function vacancy_categories()
    {
        $post = VacancyCategory::orderBy('name', 'asc')->get();
        return response()->json($post);
    }
    public function last_tenders()
    {
        $dt = Carbon::now()->toDateString();
        $date = Carbon::yesterday()->toDateString();
        $post = Tinder::where('created_at', '>=', $date)->where('created_at', '<=', $dt)->orderBy('created_at', 'desc')->count();
        return response()->json($post);
    }

    public function location()
    {
        $post = Location::orderBy('name', 'asc')->get();
        return response()->json($post);
    }

    // public function category()
    // {
    //     $post = Category::orderBy('name', 'asc')->get();
    //     return response()->json($post);
    // }
}
