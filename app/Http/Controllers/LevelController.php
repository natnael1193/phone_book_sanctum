<?php

namespace App\Http\Controllers;

use App\CareerLevel;
use App\Company;
use App\CompanyVerificationList;
use App\EducationLevel;
use App\JobType;
use App\StudyField;
use App\Subscriber;
use Illuminate\Http\Request;

class LevelController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function study_field()
    {
        $post = StudyField::query()->paginate(10);
        $level = StudyField::all();
        return view('level.study_field', compact('post', 'level'));
    }
    public function add_study_field(Request $request)
    {
        $post = new StudyField();
        $post->name = $request->input('name');
        $post->save();
        return redirect()->back();
    }

    public function update_study_field(Request $request, $id)
    {
        $post = StudyField::findOrFail($id);
        $post->name = $request->input('name');
        $post->save();
        return redirect()->back();
    }
    public function delete_study_field($id)
    {

        $post = StudyField::findOrFail($id);
        $level = Subscriber::query()->where('study_field', $post->id)->exists();

        if (auth()->user()->role == 1 || auth()->user()->status_id == 1) {
            if ($level == false) {
                $post->delete();
                return redirect()->back()->with('message', 'Deleted Successfully');
            } else {
                return redirect()->back()->with('message', 'Users registerd with this study field, Delete the users first');
            }
        } else {
            return redirect()->back()->with('message', 'You can`t delete, Please contact your admin( manager )');
        }
    }
    public function career_level()
    {
        $post = CareerLevel::query()->paginate(10);
        $level = CareerLevel::all();
        return view('level.career_level', compact('post', 'level'));
    }
    public function add_career_level(Request $request)
    {
        $post = new CareerLevel();
        $post->name = $request->input('name');
        $post->save();
        return redirect()->back();
    }

    public function update_career_level(Request $request, $id)
    {
        $post = CareerLevel::findOrFail($id);
        $post->name = $request->input('name');
        $post->save();
        return redirect()->back();
    }
    public function delete_career_level($id)
    {

        $post = CareerLevel::findOrFail($id);
        $level = Subscriber::query()->where('career_level', $post->id)->exists();

        if (auth()->user()->role == 1 || auth()->user()->status_id == 1) {
            if ($level == false) {
                $post->delete();
                return redirect()->back()->with('message', 'Deleted Successfully');
            } else {
                return redirect()->back()->with('message', 'Users registerd with this job type, Delete the users first');
            }
        } else {
            return redirect()->back()->with('message', 'You can`t delete, Please contact your admin( manager )');
        }
    }
    public function job_type()
    {
        $post = JobType::query()->paginate(10);
        $level = JobType::all();
        return view('level.job_type', compact('post', 'level'));
    }
    public function add_job_type(Request $request)
    {
        $post = new JobType();
        $post->name = $request->input('name');
        $post->save();
        return redirect()->back();
    }

    public function update_job_type(Request $request, $id)
    {
        $post = JobType::findOrFail($id);
        $post->name = $request->input('name');
        $post->save();
        return redirect()->back();
    }
    public function delete_job_type($id)
    {

        $post = JobType::findOrFail($id);

        if (auth()->user()->role == 1 || auth()->user()->status_id == 1) {
            $post->delete();
            return redirect()->back()->with('message', 'Deleted Successfully');
        } else {
            return redirect()->back()->with('message', 'You can`t delete, Please contact your admin( manager )');
        }
    }

    public function education_level()
    {
        $post = EducationLevel::query()->paginate(10);
        $level = EducationLevel::all();
        return view('level.education_level', compact('post', 'level'));
    }
    public function add_education_level(Request $request)
    {
        $post = new EducationLevel();
        $post->name = $request->input('name');
        $post->save();
        return redirect()->back();
    }

    public function update_education_level(Request $request, $id)
    {
        $post = EducationLevel::findOrFail($id);
        $post->name = $request->input('name');
        $post->save();
        return redirect()->back();
    }

    public function delete_education_level($id)
    {

        $post = EducationLevel::findOrFail($id);
        $level = Subscriber::query()->where('education_level', $post->id)->exists();

        if (auth()->user()->role == 1 || auth()->user()->status_id == 1) {
            if ($level == false) {
                $post->delete();
                return redirect()->back()->with('message', 'Deleted Successfully');
            } else {
                return redirect()->back()->with('message', 'Users registerd with this education level, Delete the users first');
            }
        } else {
            return redirect()->back()->with('message', 'You can`t delete, Please contact your admin( manager )');
        }
    }
    public function company_verification_list()
    {
        $post = CompanyVerificationList::query()->paginate(10);
        $level = CompanyVerificationList::all();
        return view('level.company_verification_list', compact('post', 'level'));
    }
    public function add_company_verification_list(Request $request)
    {
        $post = new CompanyVerificationList();
        $post->name = $request->input('name');
        $post->save();
        return redirect()->back();
    }

    public function update_company_verification_list(Request $request, $id)
    {
        $post = CompanyVerificationList::findOrFail($id);
        $post->name = $request->input('name');
        $post->save();
        return redirect()->back();
    }

    public function delete_company_verification_list($id)
    {

        $post = CompanyVerificationList::findOrFail($id);
        $level = Company::query()->where('verification', $post->id)->exists();

        if (auth()->user()->role == 1 || auth()->user()->status_id == 1) {
            if ($level == false) {
                $post->delete();
                return redirect()->back()->with('message', 'Deleted Successfully');
            } else {
                return redirect()->back()->with('message', 'Users registerd with this education level, Delete the users first');
            }
        } else {
            return redirect()->back()->with('message', 'You can`t delete, Please contact your admin( manager )');
        }
    }
}
