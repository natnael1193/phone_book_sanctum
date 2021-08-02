<?php

namespace App\Http\Controllers;

use App\Company;
use App\Premium;
use Illuminate\Http\Request;

class PremiumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Premium::paginate(20)->sortBy('name');
        $category = Premium::all();
        return view('premium.premium', compact('companies','category'));
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
        // dd(request()->all());
        $post = new Premium();
        $post->name = $request->input('name');
        $post->email = $request->input('email');
        $post->bank = $request->input('bank');
        $post->deposited_by = $request->input('deposited_by');
        $post->txn_no = $request->input('txn_no');
        $post->date = $request->input('date');
        $post->company_id = $request->input('company_id');
        $post->save();
        return response()->json($post, 200);
    }    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        // dd(request('company_category'));
        $post = Premium::findOrFail($id);
        $company = Company::findOrFail($post->company_id);
        $company->company_category = $request->input('company_category');
        $company->save();
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Premium::findOrFail($id);
        $data->delete();
        return redirect('/bank');
    }
}
