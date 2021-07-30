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
        $subscriber_id = ['subscriber_id' => $subscriber->id];

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

        // Certification::create(array_merge(
        //     $data,
        //     $subscriber_id
        // ));
        // Experience::create(array_merge(
        //     $data,
        //     $subscriber_id
        // ));
        // Education::create(array_merge(
        //     $data,
        //     $subscriber_id
        // ));
        // ProfessionalSkill::create(array_merge(
        //     $data,
        //     $subscriber_id
        // ));
        // PersonalSkill::create(array_merge(
        //     $data,
        //     $subscriber_id
        // ));
        // Language::create(array_merge(
        //     $data,
        //     $subscriber_id
        // ));
        // Hobby::create(array_merge(
        //     $data,
        //     $subscriber_id
        // ));
        // Reference::create(array_merge(
        //     $data,
        //     $subscriber_id
        // ));

        return response()->json($data);
    }
    public function add_certificate(Request $request)
    {
        $data = request()->all();
        $subscriber = Subscriber::where('id', auth()->user('sanctum')->id)->first();
        $subscriber_id = ['subscriber_id' => $subscriber->id];

        Certification::create(array_merge(
            $data,
            $subscriber_id
        ));
        return response()->json($data);

        // if ($request->certification_title != null) {
        //     foreach ($request->certification_title as $item => $v) {
        //         $post2 = array(
        //             'certification_title' => $request->certification_title[$item],
        //             'subscriber_id' => auth()->user('sanctum')->id,                
        //         );

        //         Certification::create(array_merge(
        //             $data,
        //             $post2

        //         ));
        //     }
        // }
    }

    public function update_certificate(Request $request, $id)
    {
        $data = request()->all();
        $subscriber = Subscriber::where('id', auth()->user('sanctum')->id)->first();
        $subscriber_id = ['subscriber_id' => $subscriber->id];
        $oldData = Certification::findOrFail($id);

        if ($oldData->subscriber_id == $subscriber->id) {
            $oldData->update(array_merge(
                $data,
                $subscriber_id
            ));
            return response()->json($data);
        } else {
            return response([
                'error' => 'Unauthorized',
            ], 403);
        }
    }
    public function delete_certificate(Request $request, $id)
    {

        $subscriber = Subscriber::where('id', auth()->user('sanctum')->id)->first();
        $oldData = Certification::findOrFail($id);

        if ($oldData->subscriber_id == $subscriber->id) {
            $oldData->delete();
            return response(['message' => 'Deleted Successfully'], 200);
        } else {
            return response([
                'error' => 'Unauthorized',
            ], 403);
        }
    }
    public function add_education(Request $request)
    {
        $data = request()->all();
        $subscriber = Subscriber::where('id', auth()->user('sanctum')->id)->first();
        $subscriber_id = ['subscriber_id' => $subscriber->id];

        Education::create(array_merge(
            $data,
            $subscriber_id
        ));
        return response()->json($data);

        // if ($request->certification_title != null) {
        //     foreach ($request->certification_title as $item => $v) {
        //         $post2 = array(
        //             'certification_title' => $request->certification_title[$item],
        //             'subscriber_id' => auth()->user('sanctum')->id,                
        //         );

        //         Certification::create(array_merge(
        //             $data,
        //             $post2

        //         ));
        //     }
        // }
    }

    public function update_education(Request $request, $id)
    {
        $data = request()->all();
        $subscriber = Subscriber::where('id', auth()->user('sanctum')->id)->first();
        $subscriber_id = ['subscriber_id' => $subscriber->id];
        $oldData = Education::findOrFail($id);

        if ($oldData->subscriber_id == $subscriber->id) {
            $oldData->update(array_merge(
                $data,
                $subscriber_id
            ));
            return response()->json($data);
        } else {
            return response([
                'error' => 'Unauthorized',
            ], 403);
        }
    }
    public function delete_education(Request $request, $id)
    {
        $subscriber = Subscriber::where('id', auth()->user('sanctum')->id)->first();
        $oldData = Education::findOrFail($id);

        if ($oldData->subscriber_id == $subscriber->id) {
            $oldData->delete();
            return response(['message' => 'Deleted Successfully'], 200);
        } else {
            return response([
                'error' => 'Unauthorized',
            ], 403);
        }
    }
    public function add_experience(Request $request)
    {
        $data = request()->all();
        $subscriber = Subscriber::where('id', auth()->user('sanctum')->id)->first();
        $subscriber_id = ['subscriber_id' => $subscriber->id];

        Experience::create(array_merge(
            $data,
            $subscriber_id
        ));
        return response()->json($data);

        // if ($request->certification_title != null) {
        //     foreach ($request->certification_title as $item => $v) {
        //         $post2 = array(
        //             'certification_title' => $request->certification_title[$item],
        //             'subscriber_id' => auth()->user('sanctum')->id,                
        //         );

        //         Certification::create(array_merge(
        //             $data,
        //             $post2

        //         ));
        //     }
        // }
    }

    public function update_experience(Request $request, $id)
    {
        $data = request()->all();
        $subscriber = Subscriber::where('id', auth()->user('sanctum')->id)->first();
        $subscriber_id = ['subscriber_id' => $subscriber->id];
        $oldData = Experience::findOrFail($id);

        if ($oldData->subscriber_id == $subscriber->id) {
            $oldData->update(array_merge(
                $data,
                $subscriber_id
            ));
            return response()->json($data);
        } else {
            return response([
                'error' => 'Unauthorized',
            ], 403);
        }
    }
    public function delete_experience(Request $request, $id)
    {
        $subscriber = Subscriber::where('id', auth()->user('sanctum')->id)->first();
        $oldData = Experience::findOrFail($id);

        if ($oldData->subscriber_id == $subscriber->id) {
            $oldData->delete();
            return response(['message' => 'Deleted Successfully'], 200);
        } else {
            return response([
                'error' => 'Unauthorized',
            ], 403);
        }
    }
    public function add_professional_skill(Request $request)
    {
        $data = request()->all();
        $subscriber = Subscriber::where('id', auth()->user('sanctum')->id)->first();
        $subscriber_id = ['subscriber_id' => $subscriber->id];
        $skill = ProfessionalSkill::where('professional_skill_title', $request->input('professional_skill_title'))->exists();

        if ($skill != true ) {
            ProfessionalSkill::create(array_merge(
                $data,
                $subscriber_id
            ));
            return response()->json($data);
        } else {
            return response()->json(["error" => "Already exist"]);
        }


        // if ($request->certification_title != null) {
        //     foreach ($request->certification_title as $item => $v) {
        //         $post2 = array(
        //             'certification_title' => $request->certification_title[$item],
        //             'subscriber_id' => auth()->user('sanctum')->id,                
        //         );

        //         Certification::create(array_merge(
        //             $data,
        //             $post2

        //         ));
        //     }
        // }
    }

    public function update_professional_skill(Request $request, $id)
    {
        $data = request()->all();
        $subscriber = Subscriber::where('id', auth()->user('sanctum')->id)->first();
        $subscriber_id = ['subscriber_id' => $subscriber->id];
        $oldData = ProfessionalSkill::findOrFail($id);

        if ($oldData->subscriber_id == $subscriber->id) {
            $oldData->update(array_merge(
                $data,
                $subscriber_id
            ));
            return response()->json($data);
        } else {
            return response([
                'error' => 'Unauthorized',
            ], 403);
        }
    }
    public function delete_professional_skill(Request $request, $id)
    {
        $subscriber = Subscriber::where('id', auth()->user('sanctum')->id)->first();
        $oldData = ProfessionalSkill::findOrFail($id);

        if ($oldData->subscriber_id == $subscriber->id) {
            $oldData->delete();
            return response(['message' => 'Deleted Successfully'], 200);
        } else {
            return response([
                'error' => 'Unauthorized',
            ], 403);
        }
    }
    public function add_personal_skill(Request $request)
    {
        $data = request()->all();
        $subscriber = Subscriber::where('id', auth()->user('sanctum')->id)->first();
        $subscriber_id = ['subscriber_id' => $subscriber->id];
        $skill = PersonalSkill::where('personal_skill_title', $request->input('personal_skill_title'))->exists();
        // $user = PersonalSkill::where('subscriber_id', $request->input('id'))->exists();

        // return response()->json("exist");
        // if ($skill != true && $user != true) {
            PersonalSkill::create(array_merge(
                $data,
                $subscriber_id
            ));
            return response()->json($data);
        // } else {
        //     return response()->json(["error" => "Already exist"]);
        // }


        // if ($request->certification_title != null) {
        //     foreach ($request->certification_title as $item => $v) {
        //         $post2 = array(
        //             'certification_title' => $request->certification_title[$item],
        //             'subscriber_id' => auth()->user('sanctum')->id,                
        //         );

        //         Certification::create(array_merge(
        //             $data,
        //             $post2

        //         ));
        //     }
        // }
    }

    public function update_personal_skill(Request $request, $id)
    {
        $data = request()->all();
        $subscriber = Subscriber::where('id', auth()->user('sanctum')->id)->first();
        $subscriber_id = ['subscriber_id' => $subscriber->id];
        $oldData = PersonalSkill::findOrFail($id);

        if ($oldData->subscriber_id == $subscriber->id) {
            $oldData->update(array_merge(
                $data,
                $subscriber_id
            ));
            return response()->json($data);
        } else {
            return response([
                'error' => 'Unauthorized',
            ], 403);
        }
    }
    public function delete_personal_skill(Request $request, $id)
    {
        $subscriber = Subscriber::where('id', auth()->user('sanctum')->id)->first();
        $oldData = PersonalSkill::findOrFail($id);

        if ($oldData->subscriber_id == $subscriber->id) {
            $oldData->delete();
            return response(['message' => 'Deleted Successfully'], 200);
        } else {
            return response([
                'error' => 'Unauthorized',
            ], 403);
        }
    }

    public function add_language(Request $request)
    {
        $data = request()->all();
        $subscriber = Subscriber::where('id', auth()->user('sanctum')->id)->first();
        $subscriber_id = ['subscriber_id' => $subscriber->id];
        // $skill = PersonalSkill::where('personal_skill_title', $request->input('personal_skill_title'))->exists();
        // $user = PersonalSkill::where('subscriber_id', $request->input('id'))->exists();

        // return response()->json("exist");
        // if ($skill != true && $user != true) {
            Language::create(array_merge(
                $data,
                $subscriber_id
            ));
            return response()->json($data);
        // } else {
        //     return response()->json(["error" => "Already exist"]);
        // }


        // if ($request->certification_title != null) {
        //     foreach ($request->certification_title as $item => $v) {
        //         $post2 = array(
        //             'certification_title' => $request->certification_title[$item],
        //             'subscriber_id' => auth()->user('sanctum')->id,                
        //         );

        //         Certification::create(array_merge(
        //             $data,
        //             $post2

        //         ));
        //     }
        // }
    }

    public function update_language(Request $request, $id)
    {
        $data = request()->all();
        $subscriber = Subscriber::where('id', auth()->user('sanctum')->id)->first();
        $subscriber_id = ['subscriber_id' => $subscriber->id];
        $oldData = Language::findOrFail($id);

        if ($oldData->subscriber_id == $subscriber->id) {
            $oldData->update(array_merge(
                $data,
                $subscriber_id
            ));
            return response()->json($data);
        } else {
            return response([
                'error' => 'Unauthorized',
            ], 403);
        }
    }
    public function delete_language(Request $request, $id)
    {
        $subscriber = Subscriber::where('id', auth()->user('sanctum')->id)->first();
        $oldData = Language::findOrFail($id);

        if ($oldData->subscriber_id == $subscriber->id) {
            $oldData->delete();
            return response(['message' => 'Deleted Successfully'], 200);
        } else {
            return response([
                'error' => 'Unauthorized',
            ], 403);
        }
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


// alter table `personal_skills` drop INDEX `personal_skill_title`;