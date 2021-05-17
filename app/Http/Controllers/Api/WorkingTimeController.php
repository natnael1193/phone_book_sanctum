<?php

namespace App\Http\Controllers\Api;

use App\Company;
use App\WorkingTime;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WorkingTimeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        
        $data =  Company::query()->where('company_email',auth()->user('subscriber')->company_email)->first();
        $post = request()->all();
        $user = ['subscriber_id' => auth('subscriber')->user()->id];
        $company = ['company_id' => $data->id];

        WorkingTime::create(array_merge(
           $post,
            $user,
            $company
             
        ));

        return response()->json([$post, $company, $user]);
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
        $data = Company::query()->where('company_email',auth()->user('subscriber')->company_email)->first();
        $post = request()->all();
        $oldData = WorkingTime::findOrFail($id);
        $user = ['subscriber_id' => auth('subscriber')->user()->id];
        $company = ['company_id' => $data->id];
        
        $oldData->update(array_merge(
            $post,
            $user,
            $company
        ));
        return response()->json([ $company, $post, $user]);
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
    }
}