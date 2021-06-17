<?php

namespace App\Http\Controllers;

use App\Company;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CompanyRequestsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $post = Company::query()->where('user_id', NULL)->orWhere('verification', NULL)->get();
        return view('company_requests.company_requests', compact('post'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        // $post = Company::where('user_id', '=', !NULL)->where('description', '=', NULL)->orWhere('company_logo_path', '=', NULL)->get();

        $post = Company::where(function ($query) {
            $user = auth()->user()->companies()->pluck('companies.user_id');
            $query->where('user_id', '=', $user )
                  ->where('description', '=', Null)->where('company_logo_path', '=', Null)->orWhere('company_name_am', '=', Null)->orWhere('description_am', '=', Null)->orWhere('location_id', '=', Null)
                ->orWhere('category_id', '=', Null)->orWhere('company_email', '=', Null)->orWhere('tin_number', '=', Null)->orWhere('facebook', '=', Null)->orWhere('telegram', '=', Null)->orWhere('twitter', '=', Null);
        })->paginate(25);

        $count = Company::where(function ($query) {
            $user = auth()->user()->companies()->pluck('companies.user_id');
            $query->where('user_id', '=', $user )
                ->where('description', '=', Null)->where('company_logo_path', '=', Null)->orWhere('company_name_am', '=', Null)->orWhere('description_am', '=', Null)->orWhere('location_id', '=', Null)
                ->orWhere('category_id', '=', Null)->orWhere('company_email', '=', Null)->orWhere('tin_number', '=', Null)->orWhere('facebook', '=', Null)->orWhere('telegram', '=', Null)->orWhere('twitter', '=', Null);
        })->get();
        return view('company.data_incompelete_companies', compact('post', 'count'));
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
        $post = Company::findOrFail($id);

        $today = Carbon::today();

        if($post->created_at != $today){

            $post->verfication = 1;

            $post->save();

        }
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

    public function verified_company(){
        $post = Company::where('verification', 1)->paginate(25);
        $count = Company::where('verification', 1)->get();
        return view('company.verified_companies', compact('post', 'count'));
    }
}
