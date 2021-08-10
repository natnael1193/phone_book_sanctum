<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Subscriber;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Mail\ForgetPassword;

class ForgotPasswordController extends Controller
{
  /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

  // use SendsPasswordResetEmails;

  public function postEmail(Request $request)
  {
      $request->validate([
          'email' => 'required|email|exists:subscribers',
      ]);

      $token = Str::random(60);

      DB::table('password_resets')->insert(
          ['email' => $request->email, 'token' => $token, 'created_at' => Carbon::now()]
      );

      Mail::send('auth.subscriber_email',['token' => $token], function($message) use ($request) {
                $message->from($request->email);
                $message->to($request->email);
                $message->subject('Reset Password Notification');
             });

      return response()->json(['message' => 'We have e-mailed your password reset link!']);
  }
}
