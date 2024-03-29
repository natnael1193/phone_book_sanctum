<?php

namespace App\Http\Controllers\Auth;

use App\Company;
use App\Service;
use App\Category;
use App\Subscriber;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;


class SubscriberController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:subscriber');
    }

    public function index()
    {
        // $post = Company::query()->where('subscriber_email',auth()->user('subscriber')->company_email)->first();
        $user = auth()->user('subscriber')->company()->pluck('companies.subscriber_id');
        $post = Company::whereIn('subscriber_id', $user)->first();
        $subscriber = Company::where('subscriber_id', auth()->user('subscriber')->id)->first();
        // $subscriber = Company::where('email',auth()->user('subscriber')->email, '=', Request::get('email'))->exists();
        $service = Service::all();
        // $user = Subscriber:: where('email',auth()->user('subscriber'));
        return view('company_owner.company_owner', compact('post', 'subscriber'));

    }

    public function edit()
    {

        $post = Company::where('subscriber_id', auth()->user('subscriber')->id)->first();

        return view('company_owner.company_owner_edit', compact('post'));
    }

    public function store(Request $request)
    {

        $data = request()->all();
        $oldData = Company::where('subscriber_id', auth()->user('subscriber')->id)->first();

        if (request('image')) {
            Storage::delete("/public/{$oldData->image}");
            $imagePath = request('image')->store('uploads', 'public');
            $image = Image::make(public_path("storage/{$imagePath}"))->resize(300, 300);
            $image->save();
            $imageArray = ['image' => $imagePath];
        }

        $oldData->update(array_merge(
            $data,
            $imageArray ?? []
        ));
        return redirect('/subscriber');
    }


    public function new_company()
    {
        // $post = Company::query()->where('email',auth()->user('subscriber')->email)->first();
        // $user = Subscriber:: where('email',auth()->user('subscriber'));
        $post = Category::all()->sortBy('name');
        return view('company_owner.new_company', compact('post'));

    }

    public function create()
    {
        $data = request()->all();
        $subscriber = ['subscriber_id' => auth()->user('subscriber')->id];
//    $user=['user_id' => auth()->user()->id];

//    dd( $data, $user);
        Company::create(array_merge(
            $data, $subscriber
        ));
        return redirect('/subscriber');

    }

}
