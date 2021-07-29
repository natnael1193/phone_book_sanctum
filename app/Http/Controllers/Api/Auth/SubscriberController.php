<?php

namespace App\Http\Controllers\Api\Auth;

use App\Company;
use App\Images;
use App\Service;
use App\Vacancy;
use App\Category;
use App\Certification;
use App\Subscriber;
use App\WorkingTime;
use App\CompanyRating;
use App\CompanyReview;
use App\Education;
use App\Experience;
use App\Hobby;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Language;
use App\PersonalSkill;
use App\ProfessionalSkill;
use App\Reference;
use App\VacancyRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;


class SubscriberController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index()
    {

        $subscriber = Subscriber::query()->where('id', auth()->user('sanctum')->id)->first();
        if ($subscriber == true) {
            return response()->json($subscriber);
        } else {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }
    }

    public function update(Request $request)
    {

        $data = request()->all();
        $subscriber = Subscriber::where('id', auth()->user('sanctum')->id)->first();
        $subscriber_id = ['subscriber_id'=>$subscriber->id];

        if (request('image')) {
            Storage::delete("/public/{$subscriber->image}");
            $imagePath = request('image')->store('uploads', 'public');
            $image = Image::make(public_path("storage/{$imagePath}"))->resize(300, 300);
            $image->save();
            $imageArray = ['image' => $imagePath];
        }

        $subscriber->update(array_merge(
            $data,
            $subscriber_id,
            $imageArray ?? []
        ));

        Certification::create(array_merge(
            $data,
            $subscriber_id
        ));
        Experience::create(array_merge(
            $data,
            $subscriber_id
        ));
        Education::create(array_merge(
            $data,
            $subscriber_id
        ));
        ProfessionalSkill::create(array_merge(
            $data,
            $subscriber_id
        ));
        PersonalSkill::create(array_merge(
            $data,
            $subscriber_id
        ));
        Language::create(array_merge(
            $data,
            $subscriber_id
        ));
        Hobby::create(array_merge(
            $data,
            $subscriber_id
        ));
        Reference::create(array_merge(
            $data,
            $subscriber_id
        ));

        return response()->json($data);
    }

    public function apply_vacancy(Request $request)
    {
        $data = request()->all();
        $subscriber = Subscriber::query()->where('id', auth()->user('sanctum')->id)->first();

        VacancyRequest::create(array_merge(
            $data,
            $subscriber
        ));
    }
}