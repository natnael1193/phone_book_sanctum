<?php

namespace App\Http\Controllers;

use App\CareerLevel;
use App\EducationLevel;
use App\JobType;
use App\StudyField;
use Illuminate\Http\Request;

class LevelController extends Controller
{
    //
    public function study_field(){
        $post = StudyField::query()->paginate(10);
        $level = StudyField::all();
        return view('level.study_field', compact('post', 'level'));
    }
    public function add_study_field(Request $request){
        $post = new StudyField();
        $post->name = $request->input('name');
        $post->save();
        return redirect()->back();
    }

    public function update_study_field(Request $request, $id){
        $post = StudyField::findOrFail($id);
        $post->name = $request->input('name');
        $post->save();
        return redirect()->back();
    }

    public function career_level(){
        $post = CareerLevel::query()->paginate(10);
        return view('level.career_level', compact('post'));
    }
    public function add_career_level(Request $request){
        $post = new CareerLevel();
        $post->name = $request->input('name');
        $post->save();
        return redirect()->back();
    }

    public function update_career_level(Request $request, $id){
        $post = CareerLevel::findOrFail($id);
        $post->name = $request->input('name');
        $post->save();
        return redirect()->back();
    }

    public function job_type(){
        $post = JobType::query()->paginate(10);
        return view('level.job_type', compact('post'));
    }
    public function add_job_type(Request $request){
        $post = new JobType();
        $post->name = $request->input('name');
        $post->save();
        return redirect()->back();
    }

    public function update_job_type(Request $request, $id){
        $post = JobType::findOrFail($id);
        $post->name = $request->input('name');
        $post->save();
        return redirect()->back();
    }

    public function education_level(){
        $post = EducationLevel::query()->paginate(10);
        $level = EducationLevel::all();
        return view('level.education_level', compact('post', 'level'));
    }
    public function add_education_level(Request $request){
        $post = new EducationLevel();
        $post->name = $request->input('name');
        $post->save();
        return redirect()->back();
    }

    public function update_education_level(Request $request, $id){
        $post = EducationLevel::findOrFail($id);
        $post->name = $request->input('name');
        $post->save();
        return redirect()->back();
    }
}
