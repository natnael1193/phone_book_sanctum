<?php

namespace App\Http\Controllers;

use App\Bank;
use App\BlogCategroy;
use Illuminate\Http\Request;

class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banks = bank::paginate(20)->sortBy('name');
        $category = bank::all();
        return view('bank.bank', compact('banks','category'));
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

        $post = new bank();
        $post->name = $request->input('name');
        $post->name_am = $request->input('name_am');
        $post->account_no = $request->input('account_no');
        $post->save();

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function show(Bank $bank)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function edit(Bank $bank)
    {
        //
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
                //
        $post = bank::findOrFail($id);
        $post->name = $request->input('name');
        $post->name_am = $request->input('name_am');
        $post->account_no = $request->input('account_no');
        $post->save();
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
        $data = Bank::findOrFail($id);
        $data->delete();
        return redirect('/bank');
    }
}
