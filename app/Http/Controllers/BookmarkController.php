<?php

namespace App\Http\Controllers;

use App\Company;
use App\Bookmark;
use Illuminate\Http\Request;
use Symfony\Component\Console\Input\Input;

class BookmarkController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:subscriber');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $post = Company::query()->paginate(5);

        return view('bookmark.bookmark', compact('post'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        // if (User::where('email', '=', Input::get('email'))->count() > 0) {
            // user found
        $post = Bookmark::query()->where('subscriber_id',auth("subscriber")->user()->id )->get();
        $jobs=array();
    $i=0;
    foreach($post as  $saved) {
        $job = Company::query()->where('id', $saved["company_id"])->first();
        if ($job != null) {
            $jobs[$i] = $job;
            $i++;
            // $jobs =  $post ;
        }
        else{
               $jobs[$i] = $job;
            // $i++;
               // $jobs =  $post ;
        }
        }

        return view('bookmark.saved_bookmarks', compact('post', 'jobs'));
    }
    // }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
      $data = request()->all();
    // $company = ['company_id' => 'company_id'];
        $subscriber=['subscriber_id' => auth()->user()->id];
        
        Bookmark::create(array_merge(
            $data, 
            // $company,
            $subscriber
        ));
        return redirect()->back()->with('alert', 'Successfully added');
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
        Bookmark::findOrFail($id)->delete();
        return redirect()->back();
    }
}