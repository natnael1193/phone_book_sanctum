<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function edit(){
        $user = User::findOrFail($id);
        return view('user.edit_user', compact('user'));
    }
    public function update(Request $request)
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