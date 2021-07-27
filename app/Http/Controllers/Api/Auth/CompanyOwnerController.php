<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CompanyOwnerController extends Controller
{
    //
    protected $user;

    protected $company_owner = false;

    public function __construct()
    {
        if (Auth::guard('sanctum')->check()) {
            $this->user = Auth::guard('sanctum')->user();
            $this->company_owner = true;
        } elseif (Auth::guard()->check()) {
            $this->user = Auth::guard()->user();
            $this->company_owner = false;
        } else {
            return response()->json([
                'message' => 'Not Authorized',
            ], 401);
        }
    }

    // public function index()
    // {
    //     $post =  Company::query()->where('subscriber_id', auth()->user()->id)->first();
    //     $user = Subscriber::query()->where('email', auth()->user('sanctum')->email)->first();
    //     $service = Service::query()->where('subscriber_id', auth()->user('sanctum')->id)->get();
    //     $working_time = WorkingTime::query()->where('subscriber_id', auth()->user('sanctum')->id)->get();
    //     $image = Images::query()->where('subscriber_id', auth()->user('sanctum')->id)->get();

    //     return response()->json(["subscriber" => $user, "company" => $post, "company services" => $service, "working time" => $working_time, "images" => $image]);
    // }
}
