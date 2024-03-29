<?php

namespace App\Http\Controllers;

use App\Company;
use App\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
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
        $post = Company::query()->where('company_email',auth()->user('subscriber')->company_email)->first();  
//   return response()->json($post);
        // $post = Service::all()->sortBy('name');
        return view('service.add_service', compact('post'));
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
        $data = Company::query()->where('company_email',auth()->user('subscriber')->email)->first();   
        $post = request()->all();
        //    $data = CompanyCategory::create($post)->id;
           if(count($request->name) > 0){
               foreach($request->name as $item=>$v){
               $post2=array(
                   'name' => $request->name[$item],
                //    'user_id' => $request->user_id[$item],
                //    'company_id' => $request->company_id[$item],
               );
               
               $user=['user_id' => auth()->user()->id];
               $company = ['company_id' => $data->id];
               
                     Service::create(array_merge(
            $post,         
            $post2, $user, $company
        ));
            }
        }
        // dd($post);
  
    //    dd($data);
return redirect()->back();
   
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
        $data = request()->all();
        $oldData = Service::findOrFail($id);
        $user=['user_id' => auth()->user()->id];

        $oldData->update(array_merge(
            $data,
            $user
        ));
        return redirect()->back();
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