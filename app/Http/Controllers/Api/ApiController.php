<?php

namespace App\Http\Controllers;

use App\Blog;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ApiController extends Controller
{
    //
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function store(Request $request)
    {
        //
        $data = request()->validate([
            'title' => 'required',
            'description' => 'required',
            'image' => '',
        ]);
        $user = ['user_id' => auth()->user()->id];
        if (request('image')) {
            $imagePath = request('image')->store('uploads', 'public');
            $image = Image::make(public_path("storage/{$imagePath}"))->resize(300, 300);
            $image->save();
            $imageArray = ['image' => $imagePath];
        }

        // dd($data,
        // $imageArray, $user);
        Blog::create(array_merge(
            $data,
            $user,
            $imageArray ?? [],

        ));
    }
    //    dd($data);
    public function blog(Request $request)
    {
        // return C;
        if ($request->user() != null) {
            if ($request->user()->id == 1) {
                $post = Blog::all();
                $res = $post;
                return  response()->json($res);
            } else {
                $user = auth()->user()->blogs()->pluck('blogs.user_id');
                $post = Blog::whereIn('user_id', $user)->orderBy('created_at', 'desc')->get();
                $res = $post;
                return  response()->json($res);
            }
        } else {
            return 'please login first';
        }
    }

    public function blogStore(Request $request)
    {
        $data = request()->validate([
            'title' => 'required',
            'description' => 'required',
            'image' => '',
        ]);
        $user=['user_id' =>auth()->user()->id];
        // if(request('image')){
        //     $imagePath = request('image')->store('uploads','public');
        //     $image = Image::make(public_path("storage/{$imagePath}"))->resize(300,300);
        //     $image->save();
        //     $imageArray=['image' => $imagePath];
        // }

        // dd($data,
        // $imageArray, $user);
        Blog::create(array_merge(
            $data,
            $user,
            // $imageArray ?? [],
            
        ));
    }
}