<?php

namespace App\Http\Controllers\Api\Auth;

use App\CareerLevel;
use App\Company;
use App\JobType;
use App\Location;
use App\SavedVacancy;
use App\Vacancy;
use App\Certification;
use App\Subscriber;
use App\VacancyCategory;
use App\CompanyRating;
use App\Education;
use App\EducationLevel;
use App\Experience;
use App\Hobby;
use Carbon\Carbon;
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
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;


class SubscriberController extends Controller
{
    //

    public function index()
    {

        $subscriber = Subscriber::query()->where('id', auth()->user('sanctum')->id)->first();
        $level = Subscriber::query()->where('id', auth()->user('sanctum')->id)->get('education_level')->toArray();

        if ($subscriber == true) {
            $subscriber->education_level = EducationLevel::where('id', $subscriber->education_level)->first('name');
            $subscriber->career_level = CareerLevel::where('id', $subscriber->career_level)->first('name');
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
        // $subscriber_prefeference = SubscriberPreference::where('subscriber_id', auth()->user('sanctum')->id);
        $password = ['password' => Hash::make($data['password'])];

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
            $imageArray ?? [],
            $password
        ));

        return response()->json($data);
    }

    public function certificate(Request $request)
    {
        $subscriber = Subscriber::query()->where('id', auth()->user('sanctum')->id)->first();
        if ($subscriber == true) {
            $data = Certification::where('subscriber_id', auth()->user('sanctum')->id)->first();
            return response()->json($data);
        } else {
            return response([
                'error' => 'Unauthorized',
            ], 403);
        }
    }

    public function add_certificate(Request $request)
    {
        $data = request()->all();
        $subscriber = Subscriber::where('id', auth()->user('sanctum')->id)->first();
        $subscriber_id = ['subscriber_id' => $subscriber->id];
        if (request('file')) {
            $imagePath = request('file')->store('uploads', 'public');
            $image = Image::make(public_path("storage/{$imagePath}"))->resize(300, 300);
            $image->save();
            $imageArray = ['file' => $imagePath];
        }

        $certification = Certification::create(array_merge(
            $data,
            $subscriber_id,
            $imageArray ?? []
        ));
        return response()->json(['subscriber_id' => $certification->subscriber_id, 'certification_title' => $certification->title, 'file' => $certification->file]);

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
        if (request('file')) {
            Storage::delete("/public/{$subscriber->file}");
            $imagePath = request('file')->store('uploads', 'public');
            $image = Image::make(public_path("storage/{$imagePath}"))->resize(300, 300);
            $image->save();
            $imageArray = ['file' => $imagePath];
        }
        $oldData = Certification::findOrFail($id);

        if ($oldData->subscriber_id == $subscriber->id) {
            $oldData->update(array_merge(
                $data,
                $subscriber_id,
                // $imageArray ?? []
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

    public function education(Request $request)
    {
        $subscriber = Subscriber::query()->where('id', auth()->user('sanctum')->id)->first();
        if ($subscriber == true) {
            $data = Education::where('subscriber_id', auth()->user('sanctum')->id)->first();
            return response()->json($data);
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

    public function experience(Request $request)
    {
        $subscriber = Subscriber::query()->where('id', auth()->user('sanctum')->id)->first();
        if ($subscriber == true) {
            $data = Experience::where('subscriber_id', auth()->user('sanctum')->id)->first();
            return response()->json($data);
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

    public function professional_skill(Request $request)
    {
        $subscriber = Subscriber::query()->where('id', auth()->user('sanctum')->id)->first();
        if ($subscriber == true) {
            $data = ProfessionalSkill::where('subscriber_id', auth()->user('sanctum')->id)->first();
            return response()->json($data);
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

    public function personal_skill(Request $request)
    {
        $subscriber = Subscriber::query()->where('id', auth()->user('sanctum')->id)->first();
        if ($subscriber == true) {
            $data = PersonalSkill::where('subscriber_id', auth()->user('sanctum')->id)->get();
            return response()->json($data);
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

    public function language(Request $request)
    {
        $subscriber = Subscriber::query()->where('id', auth()->user('sanctum')->id)->first();
        if ($subscriber == true) {
            $data = Language::where('subscriber_id', auth()->user('sanctum')->id)->first();
            return response()->json($data);
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

    public function hobby(Request $request)
    {
        $subscriber = Subscriber::query()->where('id', auth()->user('sanctum')->id)->first();
        if ($subscriber == true) {
            $data = Hobby::where('subscriber_id', auth()->user('sanctum')->id)->first();
            return response()->json($data);
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

    public function reference(Request $request)
    {
        $subscriber = Subscriber::query()->where('id', auth()->user('sanctum')->id)->first();
        if ($subscriber == true) {
            $data = Reference::where('subscriber_id', auth()->user('sanctum')->id)->first();
            return response()->json($data);
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
        $post = CompanyRating::where('company_id', $company->id)->first();
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

    public function applied_vacancy()
    {
        $subscriber = Subscriber::query()->where('id', auth()->user('sanctum')->id)->first();
        if ($subscriber == true) {
            $value = SavedVacancy::where('subscriber_id', $subscriber->id)->get();
            $value = VacancyRequest::where('subscriber_id', $subscriber->id)->get();
            //        $vacanc = Vacancy::get();

            foreach ($value as $values) {
                //            if (Vacancy::where('id', $values['vacancy_id'])->exists() == true) {
                $values['vacancy'] = Vacancy::where('id', $values['vacancy_id'])->get();
                foreach ($values['vacancy'] as $vacancy) {
                    $vacancy['job_type'] = JobType::where('id', $vacancy['job_type'])->first();
                    $vacancy['location'] = Location::where('id', $vacancy['location'])->first();
                }
                //            }
            }
            return response()->json($value);
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

    public function remove_applied_vacancy(Request $request, $id)
    {
        $subscriber = Subscriber::where('id', auth()->user('sanctum')->id)->first();
        $oldData = VacancyRequest::findOrFail($id);

        if ($oldData->subscriber_id == $subscriber->id) {
            $oldData->delete();
            return response(['message' => 'Deleted Successfully'], 200);
        } else {
            return response([
                'error' => 'Unauthorized',
            ], 403);
        }
    }

    public function saved_vacancy()
    {
        $subscriber = Subscriber::query()->where('id', auth()->user('sanctum')->id)->first();
        if ($subscriber == true) {
            $value = SavedVacancy::where('subscriber_id', $subscriber->id)->get();
            //        $vacanc = Vacancy::get();

            foreach ($value as $values) {
                //            if (Vacancy::where('id', $values['vacancy_id'])->exists() == true) {
                $values['vacancy'] = Vacancy::where('id', $values['vacancy_id'])->get();
                foreach ($values['vacancy'] as $vacancy) {
                    $vacancy['job_type'] = JobType::where('id', $vacancy['job_type'])->first();
                    $vacancy['location'] = Location::where('id', $vacancy['location'])->first();
                }
                //            }
            }
            return response()->json($value);
        } else {
            return response([
                'error' => 'Unauthorized',
            ], 403);
        }
    }

    public function save_vacancy(Request $request)
    {
        $data = request()->all();
        $subscriber = Subscriber::query()->where('id', auth()->user('sanctum')->id)->first();
        $subscriber_id = ["subscriber_id" => $subscriber->id];
        $value = SavedVacancy::where('subscriber_id', auth()->user('sanctum')->id)->where('vacancy_id', $request->vacancy_id)->exists();

        if ($value == true) {
            return response()->json("exists");
        } else {
            SavedVacancy::create(array_merge(
                $data,
                $subscriber_id
            ));

            return response()->json($data);
        }
    }

    public function remove_saved_vacancy(Request $request, $id)
    {
        $subscriber = Subscriber::where('id', auth()->user('sanctum')->id)->first();
        $oldData = SavedVacancy::findOrFail($id);

        if ($oldData->subscriber_id == $subscriber->id) {
            $oldData->delete();
            return response(['message' => 'Deleted Successfully'], 200);
        } else {
            return response([
                'error' => 'Unauthorized',
            ], 403);
        }
    }

    public function subscriber_preference()
    {
        $preference = SubscriberPreferenceCareerLevel::where('id', auth()->user('sanctum')->id)->first();
        return response()->json($preference);
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

    public function subscriber_preference_vacancy()
    {
        $preference = SubscriberPreferenceCategory::where('subscriber_id', auth()->user('sanctum')->id)->get();
  

        foreach ($preference as $preferences) {

                $dt = Carbon::now()->toDateString();
                $preferences['vacancy'] = Vacancy::where('category_id', $preferences['category'])->where('due_date', '>=', $dt)
                                           ->orderBy('created_at','desc')->get();
            

                foreach ($preferences['vacancy']  as $vacancies) {
                    $vacancies['location']= Location::where('id', $vacancies->location)->first();
                    $vacancies['job_type'] = JobType::where('id', $vacancies['job_type'])->first();
                    $vacancies['due_date'] = Carbon::parse($vacancies['due_date'])->format('d-m-Y');

            }

        }
        $array = data_get($preference, '*.vacancy');
        $obj = Arr::collapse($array);
        return response()->json($obj);

    }

    public function check_cv(){
$subscriber = Subscriber::where('id', auth()->user('sanctum')->id)->first();
$education = Education::where('subscriber_id', auth()->user('sanctum')->id)->exists();

if($education == true && $subscriber->description != null){
    return response()->json(['status' => 'cv_completed']);
}
else{
    return response()->json(['status' => 'cv_incomplete']);
}

    }

}


// alter table `personal_skills` drop INDEX `personal_skill_title`;
