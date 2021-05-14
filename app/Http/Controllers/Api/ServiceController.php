<?php

namespace App\Http\Controllers\Api;

use App\Company;
use App\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ServiceController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $company = Company::where('subscriber_id', auth()->user('subscriber')->id)->first();
        $post = Service::where('company_id', $company->id)->get();
        //   return response()->json($post);
        // $post = Service::all()->sortBy('name');
        return response()->json(["Company Name" => $company->company_name, "services" => $post]);
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
        $data = Company::query()->where('company_email', auth()->user('subscriber')->company_email)->first();
        $post = request()->all();
        //    $data = CompanyCategory::create($post)->id;
        //    if(count($request->name) > 0){
        //        foreach($request->name as $item=>$v){
        //        $post2=array(
        //            'name' => $request->name[$item],
        //        );

        $user = ['subscriber_id' => auth('sanctum')->user()->id];
        $company = ['company_id' => $data->id];

        Service::create(array_merge(
            $post,
            $user,
            $company
        ));
        // }
        // }

        return response()->json([$post, $user, $company]);
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
        $data = Company::query()->where('company_email', auth()->user('subscriber')->company_email)->first();
        $post = request()->all();
        $oldData = Service::findOrFail($id);
        $user = ['subscriber_id' => auth('sanctum')->user()->id];
        $company = ['company_id' => $data->id];

        $oldData->update(array_merge(
            $post,
            $user,
            $company
        ));
        return response()->json([$user, $post, $company]);
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