@extends('layouts.admin')
@section('content')
    {{-- @can('viewAny', App\blog::class) --}}
    {{-- <div class="row">
            <div class="col-auto d-none d-sm-block">
                <h3><strong>Vacancy</strong> </h3>
           <a href="/vacancy/create"><button class="btn btn-success">Add New Vacancy</button></a>
            </div>
            </div> --}}
            <div class="row col-xl-12 col-lg-12 col-md-12 col-sm-12" role="alert">
                @if(Session::has('message'))
                <p class="alert alert-info">{{ Session::get('message') }}</p>
                @endif
                </div>
                <div class="row col-xl-12 col-lg-12 col-md-12 col-sm-12" role="alert">
                    @if(Session::has('message1'))
                    <p class="alert alert-danger">{{ Session::get('message1') }}</p>
                    @endif
                    </div>
    <div class="row">
        <a href="{{route('tender.create')}}"><button class="btn btn-success">Add New Tender</button></a>
    </div>
    <div class="row col-xl-12 col-lg-12 col-md-12">
        @if (Auth::user()->role == 1)

            @foreach ($post as $posts)
                <div class="col-xl-4 col-lg-4 col-md-6" style="margin-top: 5%">

                    <div class="card">

                        <div class="alert-message">
                            <h4 class="alert-heading">{{ $posts->title }}</h4>
                            <hr>

                            <p>{!! Illuminate\Support\Str::of($posts->description)->words(9) !!}</p>

                            <hr>
                            <div class="row">
                                <div class="btn-list" style="display: flex">
                                    <a href="{{ route('tender.edit', $posts->id) }}"> <button class="btn btn-primary mr-2"
                                            type="button">Edit</button></a>
                                    <form method="POST" action="{{ route('tender.destroy', $posts->id) }}">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-danger" type="submit">Delete</button>
                                    </form>
                                </div>
                            </div>

                            <br>
                            {{-- <p style="color: black">Posted By: @if(App\User::findOrFail($posts->user_id)->exists()) {{ App\User::findOrFail($posts->user_id)->name }} @endif</p> --}}
                        </div>
                    </div>
                </div>
            @endforeach

    </div>
@else
    <div class="row col-xl-12 col-lg-12 col-md-12">
        @foreach ($post as $posts)
            <div class="col-xl-4 col-lg-4 col-md-6" style="margin-top: 5%">
                <div class="card" style="width: 100%">
                    <div class="alert-message">
                        <h4>{{ $posts->title }}</h4>
                        <hr>
                        <p>{!! Illuminate\Support\Str::of($posts->description)->words(9) !!}</p>

                        <div class="btn-list" style="display: flex">
                            <a href="{{ route('tender.edit', $posts->id) }}"> <button class="btn btn-primary mr-2"
                                    type="button">Edit</button></a>
                            <form method="POST" action="{{ route('tender.destroy', $posts->id) }}">
                                @csrf
                                @method('delete')
                                <button class="btn btn-danger" type="submit">Delete</button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        @endforeach
        @endif
    </div>
    {{ $post->links() }}
@endsection
