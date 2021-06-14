<?php

namespace App\Http\Controllers;

use App\Blog;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        //
        $company = Blog::all();
        $user = auth()->user()->blogs()->pluck('blogs.user_id');
        $post = Blog::whereIn('user_id', $user)->orderBy('created_at', 'desc')->paginate(5);
        $all = Blog::all();
        return view('blog.blog', compact('post', 'all'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('blog.add_blog');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $data = request()->validate([
            'title' => 'required',
            'description' => 'required',
            'image' => '',
        ]);
        $user=['user_id' => auth()->user()->id];
        if(request('image')){
            $imagePath = request('image')->store('uploads','public');
            $image = Image::make(public_path("storage/{$imagePath}"))->resize(300,300);
            $image->save();
            $imageArray=['image' => $imagePath];
        }

        // dd($data,
        // $imageArray, $user);
        Blog::create(array_merge(
            $data,
            $user,
            $imageArray ?? [],
            
        ));
    //    dd($data);
return redirect('/blog');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $blog=Blog::find($id);
        $this->authorize('view', $blog);
        $post = $blog;
        return view('blog.edit_blog', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $data = request()->all();
        $oldData = Blog::findOrFail($id);
        $user=['user_id' => auth()->user()->id];
        if(request('image')){
            Storage::delete("/public/{$oldData->image}");
            $imagePath = request('image')->store('uploads','public');
            $image = Image::make(public_path("storage/{$imagePath}"))->resize(300,300);
            $image->save();
            $imageArray=['image' => $imagePath];
        }

        $oldData->update(array_merge(
            $data,
            $imageArray ?? [],
            $user
        ));
        return redirect('/blog');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        Blog::findOrFail($id)->delete();
        return redirect()->back();
    }
}