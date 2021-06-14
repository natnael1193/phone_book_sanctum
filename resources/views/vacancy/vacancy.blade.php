@extends('layouts.admin')
@section('content')


    <div class="row">
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
        <a href="{{route('vacancy.create')}}"><button class="btn btn-success">Add New Vacancy</button></a>
    </div>

    @if (Auth::user()->role == 1)
    <div class="row col-xl-12 col-lg-12 col-md-12">
        

            @foreach ($post as $posts)
                <div class="col-xl-4 col-lg-4 col-md-6" style="margin-top: 5%">

                    <div class="card">

                        <div class="alert-message">
                            <h4 class="alert-heading">{{ $posts->title }}</h4>
                            <hr>

                            <p>{!! Illuminate\Support\Str::of($posts->description)->words(9) !!}</p>

                            <hr>
                            {{-- <div class="row"> --}}
                                <div class=" row btn-list">
                                    <a href="{{ route('vacancy.edit', $posts->id) }}"> <button class="btn btn-primary mr-2"
                                            type="button">Edit</button></a>
                                    <form method="POST" action="{{ route('vacancy.destroy', $posts->id) }}">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-danger mr-2" type="submit">Delete</button>
                                    </form>
                                </div>
                            {{-- </div> --}}

                            <br>
                            @if($posts->user_id != null)
                            <p style="color: black">Posted By: {{ App\User::findOrFail($posts->user_id)->name }}</p>
                            @endif
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

                        <div class="row btn-list">
                            <a href="{{ route('vacancy.edit', $posts->id) }}"> <button class="btn btn-primary mr-2"
                                    type="button">Edit</button></a>
                            <form method="POST" action="{{ route('vacancy.destroy', $posts->id) }}">
                                @csrf
                                @method('delete')
                                <button class="btn btn-danger" type="submit">Delete</button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        @endforeach
        
    </div>
    @endif
    {{ $post->links() }}
    
@endsection
