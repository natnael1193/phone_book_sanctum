
@extends('layouts.admin')
@section('content')
{{-- @can('viewAny', App\blog::class) --}}
            <div class="row m-3">
            <div class="col-auto d-none d-sm-block">
                <h3><strong>Blog</strong> </h3>
           <a href="/blog/create"><button class="btn btn-success">Add New blog</button></a>
            </div>
            </div>

            <div class="row">

                {{-- @if(Auth::user()->role_id == 1) --}}
                @can('viewAny', App\Blog::class)
               {{-- @if(Auth::user()->status_id != 1)  --}}
                @foreach($all as $companies)
                <div class="col-12 col-xl-4 col-lg-4 col-md-6">

		<div class="card">
            <div class="card-body">

                <div class="mb-3">
                    {{-- <div class="alert alert-primary alert-outline alert-dismissible" role="alert"> --}}
                        {{-- <button type="button" class="close" data-dismiss="alert" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button> --}}

                        <div class="alert-message">
                            <h3 class="alert-heading">{{ $companies->title }}</h3>
                            <hr>
                            <p>{!! Illuminate\Support\Str::of($companies->description)->words(9) !!}</p>
                            <hr>
                            <div class="row">
                                <div class="col-xl-12 col-lg-12"><p>Phone: {{ $companies->phone_number }}</p></div>
                                <div class="col-xl-12 col-lg-12"><p>Location: </h4></div>
                            </div>
                            <div class="row btn-list">
                              <a href="{{ route('blog.edit', $companies->id) }}" > <button class="btn btn-primary mr-2" type="button">Edit</button></a>
                              <form method="POST" action="{{ route('blog.destroy', $companies->id) }}">
                                @csrf
                                @method('delete')
                              <button class="btn btn-danger" type="submit">Delete</button>
                              </form>
                            </div>
                            <br>
                            @if($companies->user_id != null)
                            <p style="color: black">Posted By: {{ App\User::findOrFail($companies->user_id)->name }}</p>
                            @endif
                        </div>
                    {{-- </div> --}}
                </div>

            </div>
        </div>

    </div>
    @endforeach
    {{-- @endif --}}
    @endcan
                {{-- @else --}}

                @if(Auth::user()->role != 1 && Auth::user()->status_id != 1)
                @foreach($post as $posts)
                <div class="col-12 col-xl-4 col-lg-4 col-md-6">

		<div class="card">
            <div class="card-body">

                <div class="mb-3">
                    {{-- <div class="alert alert-primary alert-outline alert-dismissible" role="alert"> --}}
                        {{-- <button type="button" class="close" data-dismiss="alert" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button> --}}

                        <div class="alert-message">
                            <h3 class="alert-heading">{{ $posts->title }}</h3>
                            <hr>
                            <p>Aww yeah, you successfully read this important alert message.  so that you can see how spacing within an
                                alert works with this kind of content.</p>
                            <hr>
                            <div class="row">
                                <div class="col-xl-6 col-lg-6"><p>Phone: {{ $posts->phone_number }}</p></div>
                                <div class="col-xl-6 col-lg-6"><p>Location:</h4></div>


                            </div>
                            <div class="row btn-list">
                              <a href="{{ route('blog.edit', $posts->id) }}" > <button class="btn btn-primary mr-2" type="button">Edit</button></a>
                              <form method="POST" action="{{ route('blog.destroy', $posts->id) }}">
                                @csrf
                                @method('delete')
                              <button class="btn btn-danger" type="button">Delete</button>
                              </form>
                            </div>
                            <br>
                            {{-- <h4 style="color: black">Posted By: {{ App\User::findOrFail($posts->user_id)->name }}</h4> --}}
                        </div>
                    {{-- </div> --}}
                </div>

            </div>
        </div>

    </div>
    @endforeach
    @endif
</div>
{{-- @endcan --}}
{{-- </div>
</main> --}}
@endsection
