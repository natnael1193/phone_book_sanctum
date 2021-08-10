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
use App\WorkingTime;
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
            $vacancies['category_id'] = VacancyCategory::where('id', $vacancies['category_id'])->first(['image', 'name']);
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
        $post = Category::get()->toArray();

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
        $post = VacancyCategory::all();
        //        $post = Category::all()->sortBy('id');
        // $service = Service::where('company_id',  $id)->get();

        return response()->json($post);
    }

    public function tender_category()
    {
        $post = TenderCategory::all();
        //        $post = Category::all()->sortBy('id');
        // $service = Service::where('company_id',  $id)->get();

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
            $company[$x]['category_id'] = VacancyCategory::where('id', $company[$x]['category_id'])->first('name');
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
                $vacancies['location'] = Location::where('id', $vacancies['location'])->first('name');
                $vacancies['category'] = VacancyCategory::where('id', $vacancies['category_id'])->first(['name', 'image']);
                $vacancies['posted_date'] = Carbon::parse($vacancies['created_at'])->diffForHumans();
                $vacancies['due_date'] = Carbon::parse($vacancies['due_date'])->format('d-m-Y');
            }
        }
        if ($id != null) {
            foreach ($tender as  $tenders) {
                $tenders['category'] = TenderCategory::where('id', $tenders['category_id'])->first(['name', 'image']);
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

    public function vacancy_detail($id)
    {
        $post = Vacancy::findOrFail($id);
        $category = VacancyCategory::whereIn('id', $post)->first(['name', 'image']);
        $post->due_date = Carbon::parse($post->due_date)->format('d-m-Y');
        return response()->json(['vacancy' => $post, 'category' => $category,]);
    }


    public function tender()
    {
        $dt = Carbon::now()->toDateString();
        $post = Tinder::where('closing_date', '>=', $dt)->get()->toArray();

        // $post = Tinder::all();
        for ($x = 0; $x < sizeof($post); $x++) {
            [
                $post[$x]['category_id'] = TenderCategory::where('id', $post[$x]['category_id'])->first(['name', 'image']),
                $post[$x]['location'] = Location::where('id', $post[$x]['location'])->first('name'),
                $post[$x]['opening_date'] = Carbon::parse($post[$x]['opening_date'])->format('d-m-Y'),
                $post[$x]['closing_date'] = Carbon::parse($post[$x]['closing_date'])->format('d-m-Y'),
                $post[$x]['reference_date'] = Carbon::parse($post[$x]['reference_date'])->format('d-m-Y')

            ];
        }
        return response()->json($post);
    }

    public function tender_detail($id)
    {
        $post = Tinder::findOrFail($id);
        $category = TenderCategory::where('id', $post->category_id)->first(['name', 'image']);

        return response()->json(['tender' => $post, 'category' => $category]);
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

    public function latest_companies()
    {
        $post = Company::orderBy('id', 'DESC')->take(5)->get();

        return response()->json($post);
    }
    public function latest_vacancies()
    {
        $post = Vacancy::orderBy('id', 'DESC')->take(5)->get();

        return response()->json($post);
    }
    public function latest_tenders()
    {
        $post = Tinder::orderBy('id', 'DESC')->take(5)->get();

        return response()->json($post);
    }
}
