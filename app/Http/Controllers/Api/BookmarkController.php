<?php

namespace App\Http\Controllers\Api;

use App\Company;
use App\Bookmark;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BookmarkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $post = Bookmark::query()->where('subscriber_id',auth("sanctum")->user()->id )->get();
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

        return response()->json([$jobs]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        $user = ['user_id' => auth()->user()->id];
        $subscriber= ['subscriber_id' => auth()->user('subscriber')->id];
        
        Bookmark::create(array_merge(
            $user, $subscriber
        ));
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
      
    }
}