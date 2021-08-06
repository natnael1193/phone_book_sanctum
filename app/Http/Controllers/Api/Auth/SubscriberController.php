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
use App\SubscriberPreference;
use App\SubscriberPreferenceCareerLevel;
use App\SubscriberPreferenceCategory;
use App\SubscriberPreferenceJobType;
use App\VacancyRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use phpDocumentor\Reflection\PseudoTypes\True_;

class SubscriberController extends Controller
{
    //

    public function index()
    {

        $subscriber = Subscriber::query()->where('id', auth()->user('sanctum')->id)->first();
        $level = Subscriber::query()->where('id', auth()->user('sanctum')->id)->get('education_level')->toArray();

        if ($subscriber == true) {
            if ($subscriber->education_level == 1) {
                $subscriber->education_level = "8th Grade";
            } elseif ($subscriber->education_level == 2) {
                $subscriber->education_level = "10th Grade";
            } elseif ($subscriber->education_level == 3) {
                $subscriber->education_level = "12th Grade";
            } elseif ($subscriber->education_level == 4) {
                $subscriber->education_level = "TVET Certificate";
            } elseif ($subscriber->education_level == 5) {
                $subscriber->education_level = "Diploma";
            } elseif ($subscriber->education_level == 6) {
                $subscriber->education_level = "Bsc";
            } elseif ($subscriber->education_level == 7) {
                $subscriber->education_level = "Msc";
            } elseif ($subscriber->education_level == 8) {
                $subscriber->education_level = "Phd";
            }
            else {
                $subscriber->education_level = null;
            }

            if ($subscriber->career_level == 1) {
                $subscriber->career_level = "Fresh Graduate";
            } elseif ($subscriber->career_level == 2) {
                $subscriber->career_level = "Junior Level";
            } elseif ($subscriber->career_level == 3) {
                $subscriber->career_level = "Senior Level";
            }
            else{
                $subscriber->career_level = null;
            }

            return response()->json([$subscriber]);
        } else {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }
    }

    public function update(Request $request)
    {

        $data = request()->all();
        $subscriber = Subscriber::where('id', auth()->user('sanctum')->id)->first();
        $subscriber_id = ['subscriber_id' => $subscriber->id];
        // $subscriber_prefeference = SubscriberPreference::where('subscriber_id', auth()->user('sanctum')->id);

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

        if ($skill != true) {
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
    public function add_hobby(Request $request)
    {
        $data = request()->all();
        $subscriber = Subscriber::where('id', auth()->user('sanctum')->id)->first();
        $subscriber_id = ['subscriber_id' => $subscriber->id];
        $hobby = Hobby::where('subscriber_id', auth()->user('sanctum')->id)->where('hobby_name', $request->hobby_name)->exists();
        // $user = PersonalSkill::where('subscriber_id', $request->input('id'))->exists();

        // return response()->json("exist");
        if ($hobby != true) {
            Hobby::create(array_merge(
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

    public function update_hobby(Request $request, $id)
    {
        $data = request()->all();
        $subscriber = Subscriber::where('id', auth()->user('sanctum')->id)->first();
        $subscriber_id = ['subscriber_id' => $subscriber->id];
        $oldData = Hobby::findOrFail($id);

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
    public function delete_hobby(Request $request, $id)
    {
        $subscriber = Subscriber::where('id', auth()->user('sanctum')->id)->first();
        $oldData = Hobby::findOrFail($id);

        if ($oldData->subscriber_id == $subscriber->id) {
            $oldData->delete();
            return response(['message' => 'Deleted Successfully'], 200);
        } else {
            return response([
                'error' => 'Unauthorized',
            ], 403);
        }
    }

    public function add_reference(Request $request)
    {
        $data = request()->all();
        $subscriber = Subscriber::where('id', auth()->user('sanctum')->id)->first();
        $subscriber_id = ['subscriber_id' => $subscriber->id];
        // $skill = PersonalSkill::where('personal_skill_title', $request->input('personal_skill_title'))->exists();
        // $user = PersonalSkill::where('subscriber_id', $request->input('id'))->exists();

        // return response()->json("exist");
        // if ($skill != true && $user != true) {
        Reference::create(array_merge(
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

    public function update_reference(Request $request, $id)
    {
        $data = request()->all();
        $subscriber = Subscriber::where('id', auth()->user('sanctum')->id)->first();
        $subscriber_id = ['subscriber_id' => $subscriber->id];
        $oldData = Reference::findOrFail($id);

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
    public function delete_reference(Request $request, $id)
    {
        $subscriber = Subscriber::where('id', auth()->user('sanctum')->id)->first();
        $oldData = Reference::findOrFail($id);

        if ($oldData->subscriber_id == $subscriber->id) {
            $oldData->delete();
            return response(['message' => 'Deleted Successfully'], 200);
        } else {
            return response([
                'error' => 'Unauthorized',
            ], 403);
        }
    }

    public function company_rating($id)
    {
        $company = Company::findOrFail($id);
        $post =  CompanyRating::where('company_id', $company->id)->first();
        $rate = CompanyRating::where('subscriber_id', auth()->user('sanctum')->id)->exists();
        //        $company_id =['company_id' => $company->id];

        if ($rate == true) {

            return response()->json($post);
        } else {
            return response()->json(["rating" => null]);
        }
    }
    public function add_company_rating(Request $request)
    {
        $data = request()->all();
        $subscriber = ['subscriber_id' => auth()->user('sanctum')->id];
        $company = Company::where('subscriber_id', auth()->user('sanctum')->id)->first();
        $value = CompanyRating::where('subscriber_id', auth()->user('sanctum')->id)->where('company_id', $request->company_id)->exists();
        //        $company_id =['company_id' => $company->id];
        if ($value == true) {
            return response()->json("exists");
        } else {
            CompanyRating::create(array_merge(
                $data,
                $subscriber
            ));

            return response()->json([$data, $subscriber]);
        }
    }


    public function update_company_rating(Request $request, $id)
    {
        $post = request()->all();
        $oldData = CompanyRating::findOrFail($id);
        //        $this->authorize('view', $oldData);
        $user = ['subscriber_id' => auth('sanctum')->user()->id];
        // $company = ['company_id' => $data->id];

        $oldData->update(array_merge(
            $post,
            $user
            // $company
        ));
        return response()->json([$user, $post]);
    }
    public function apply_vacancy(Request $request)
    {
        $data = request()->all();
        $subscriber = Subscriber::query()->where('id', auth()->user('sanctum')->id)->first();
        $subscriber_id = ["subscriber_id" => $subscriber->id];
        $value = VacancyRequest::where('subscriber_id', auth()->user('sanctum')->id)->where('vacancy_id', $request->vacancy_id)->exists();

        if ($value == true) {
            return response()->json("exists");
        } else {
            VacancyRequest::create(array_merge(
                $data,
                $subscriber_id
            ));

            return response()->json($data);
        }
    }

    public function subscriber_preference()
    {
    }


    public function subscriber_add_preference(Request $request)
    {
        $data = request()->all();
        $subscriber = Subscriber::where('id', auth()->user('sanctum')->id)->first();
        $subscriber_id = ['subscriber_id' => $subscriber->id];

        if ($request->career_level != null) {

            foreach ($request->career_level as $item => $v) {
                $post2 = array(
                    'career_level' => $request->career_level[$item],
                    'subscriber_id' => auth()->user('sanctum')->id,
                );
                SubscriberPreferenceCareerLevel::create(array_merge(
                    // $data,
                    $post2,
                    $subscriber_id
                ));
            }
        }
        if ($request->category != null) {
            foreach ($request->category as $item => $v) {
                $post2 = array(
                    'category' => $request->category[$item],
                    'subscriber_id' => auth()->user('sanctum')->id,
                );
                SubscriberPreferenceCategory::create(array_merge(
                    $data,
                    $post2
                ));
            }
        }
        if ($request->job_type != null) {
            foreach ($request->job_type as $item => $v) {
                $post2 = array(
                    'job_type' => $request->job_type[$item],
                    'subscriber_id' => auth()->user('sanctum')->id,
                );
                SubscriberPreferenceJobType::create(array_merge(
                    $data,
                    $post2
                ));
            }
        }

        return response()->json($data);
    }
}


// alter table `personal_skills` drop INDEX `personal_skill_title`;