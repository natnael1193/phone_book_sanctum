<?php

namespace App\Http\Controllers;

use App\Company;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Support\Renderable;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
        /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    //
    public function index()
    {
        //
        // $user = User::all()->sortBy('name');
        return view('user.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $role = Role::all();
        $user = User::all()->sortBy('name');
        return view('user.add_user', compact('role', 'user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function register(Request $request)
    {
        request()->validate([
            'name' => 'required', 'string', 'max:255',
            'email' => 'required', 'string', 'email', 'max:255', 'unique:users',
            'password' => 'required', 'string', 'min:8', 'confirmed',
            'role' => 'required'
        ]);
        $data = $request->all();
        $check = $this->store($data);
        return redirect()->back();
    }
  

    protected function store(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
        ]);
        
       
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
        $user = User::findOrfail($id);
        $post = Company::query()->where('user_id', $id)->get();
        return view('user.user_status', compact('user', 'post'));
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
        $user = User::findOrfail($id);
        return view('user.edit_user', compact('user'));
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
        // $data = request()->all();
        $user = User::findOrFail($id);
    
        $user->status_id = $request->input('status_id');
        $user->save();
    
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

    public function edit_user($id){
        
        $user = User::query()->where('id', auth()->user()->id)->first();
        return view('user.update_user', compact('user'));
    }
    public function update_user(Request $request)
    {
        $data = request()->all();
        $check = $this->save($data);

        return response()->json([$data]);
    }

    public function save(array $data)
    {

        $user = User::query()->where('id', auth()->user()->id)->first();

        $user->update([
            'name' => $data['name'],
            //            'lastName' => $data['lastName'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),

        ]);
    }
}