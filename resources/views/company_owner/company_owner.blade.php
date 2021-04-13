@extends('layouts.subscriber')
@section('content')
{{-- @if($post->email == $id->email)  --}}
{{-- {{  $post}} --}}
@if(App\Company::where('email',auth()->user('subscriber')->email, '=', Request::get('email'))->exists())
{{-- @else --}}
<div class="container-fluid p-0">

    <h1 class="h3 mb-3">Profile</h1>
    {{-- {{ $post->email }}
    {{ $id->email}} --}}
    <div class="row">
        <div class="col-md-4 col-xl-3">
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">Profile Details</h5>
                </div>
                <div class="card-body text-center">
                    {{-- <img src="img/avatars/avatar-4.jpg" alt="Christina Mason" class="img-fluid rounded-circle mb-2" width="128" height="128" /> --}}
                    <h3>{{ $post->company_name }}</h3>
                    <div class="text-muted mb-2">Lead Developer</div>

                    {{-- <div>
                        <a class="btn btn-primary btn-sm" href="#">Follow</a>
                        <a class="btn btn-primary btn-sm" href="#"><span data-feather="message-square"></span> Message</a>
                    </div> --}}
                </div>
                <hr class="my-0" />
                <div class="card-body">
                    <h5 class="h6 card-title">About</h5>
                    <ul class="list-unstyled mb-0">
                        {{-- <li class="mb-1"><span data-feather="home" class="feather-sm mr-1"></span> Address San Francisco, SA</li>

                        <li class="mb-1"><span data-feather="briefcase" class="feather-sm mr-1"></span> Works at GitHub</li> --}}
                        <li class="mb-1"><span data-feather="map-pin" class="feather-sm mr-1"></span> Location: {{ $post->location_path_image }}</li>
                        <li class="mb-1"><span class="fas fa-globe fa-fw mr-1"></span> {{ $post->website }}</li>
                        <li class="mb-1"><i class="align-middle mr-2" data-feather="mail"></i> <span class="align-middle"></span> {{ $post->email }}</li>
                        <li class="mb-1"><span class="fas fa-phone fa-fw mr-1"></span> {{ $post->phone_number }}</li>
                        <li class="mb-1"><span class="fas fa-phone fa-fw mr-1"></span>{{ $post->phone_number_2 }}</li>

                    </ul>
                </div>
                {{-- <hr class="my-0" />
                <div class="card-body">
                    <h5 class="h6 card-title">Elsewhere</h5>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-1"><span class="fas fa-globe fa-fw mr-1"></span> <a href="#">{{ $post->wedsite }}</a></li>
                    </ul>
                </div> --}}
            </div>
        </div>

        <div class="col-md-8 col-xl-9">
            <div class="card">
                <div class="card-body h-100">
                    <h3>Description</h3>             
                    <div class="media">
                        {{-- <img src="img/avatars/avatar-5.jpg" width="36" height="36" class="rounded-circle mr-2" alt="Vanessa Tucker"> --}}
                        <div class="media-body">
                            {{-- <small class="float-right text-navy">5m ago</small> --}}
                         <p>{{ $post->description }}</p><br />
                            <small class="text-muted">Today 7:51 pm</small><br />

                        </div>
                    </div>

                    <hr />
                    <h3>Services</h3>                     
                    <div class="media">
                        {{-- <img src="img/avatars/avatar-5.jpg" width="36" height="36" class="rounded-circle mr-2" alt="Vanessa Tucker"> --}}
                        <div class="media-body">
                            {{-- <small class="float-right text-navy">5m ago</small> --}}
                            <p>{{ $post->description }}</p><br />
                            <small class="text-muted">Today 7:51 pm</small><br />

                        </div>
                    </div>

             

                    <hr />
                    <a href="subscriber/edit" class="btn btn-primary btn-block">Edit</a>
                </div>
            </div>
        </div>
    </div>

</div>
{{-- @else --}}
{{-- @endif --}}
@endif
@endsection