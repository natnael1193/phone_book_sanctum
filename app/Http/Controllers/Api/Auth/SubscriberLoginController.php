<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class SubscriberLoginController extends Controller
{
    //
   //
    
    /**
     * Show the login form.
     * 
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return response()->json(auth()->user('subscriber'));
    }

    protected function guard(){
        return Auth::guard('subscriber');
    }

    use AuthenticatesUsers;
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/subscriber';
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Login the admin.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        $this->validator($request);
    
        if(Auth::guard('subscriber')->attempt($request->only('email','password'),$request->filled('remember'))){
            //Authentication passed...
            return response()->json(auth()->user('subscriber'));
        }

    }

    /**
     * Logout the admin.
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
      //logout the admin...
    //   Session::flash('message1', 'You have been logged out!');
      Auth::guard('subscriber')->logout();
      Session::flush();
      return redirect('/subscriber/sign_in')
          ->with('message1','User has been logged out!');

    }

    /**
     * Validate the form data.
     * 
     * @param \Illuminate\Http\Request $request
     * @return 
     */
    private function validator(Request $request)
    {
    //validation rules.
    $rules = [
        'email'    => 'required|email|exists:subscribers|min:5|max:191',
        'password' => 'required|string|min:4|max:255',
    ];

    //custom validation error messages.
    $messages = [
        'email.exists' => 'These credentials do not match our records.',
    ];

    //validate the request.
    $request->validate($rules,$messages);
    }

    /**
     * Redirect back after a failed login.
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    private function loginFailed()
    {
      //Login failed...
      return redirect()
      ->back()
      ->with('message','These credentials do not match our records.');
    }
}