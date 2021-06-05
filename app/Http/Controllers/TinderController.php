<?php

namespace App\Http\Controllers;

use App\Tinder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class TinderController extends Controller
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
       
        // $user = auth()->user()->tinders()->pluck('tinders.user_id');
        // $post = Tinder::whereIn('user_id', $user)->orderBy('created_at', 'desc')->paginate(5);
        $post = Tinder::orderBy('created_at', 'desc')->paginate(5);
        // return response()->json($post);
        return view('tinder.tinder', compact('post'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('tinder.add_tinder');
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
        Tinder::create(array_merge(
            $data,
            $user,
            $imageArray ?? [],
            
        ));
    //    dd($data);
return redirect('/tender');
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
        $tinder=Tinder::find($id);
        // $this->authorize('view', $tinder);
        $post = $tinder;
        // return response()->json($post);
        return view('tinder.edit_tinder', compact('post'));
        
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
        $oldData = Tinder::findOrFail($id);
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
        return redirect('/tender');
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
       $post = Tinder::findOrFail($id)->delete();
        // return response()->json($post);
        return redirect()->back();
    }
}