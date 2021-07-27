
@extends('layouts.admin')
@section('content')
    <h3><strong>Blog</strong> </h3>
            <div class="row col-lg-12 col-md-12 col-sm-12 col-xm-12">
           <a href="/blog/create"><button class="btn btn-success">Add New blog</button></a>
            </div>


                @can('viewAny', App\Blog::class)
                @if(Auth::user()->role == 5)
                    <div class="row col-xl-12 col-lg-12 col-md-12">
                @foreach($post as $posts)

                            <div class="col-xl-4 col-lg-4 col-md-6" style="margin-top: 5%">

                                <div class="card">

                                    <div class="alert-message">
                                        <h4 class="alert-heading">{{ $posts->title }}</h4>
                                        <hr>

                                        <p>{!! Illuminate\Support\Str::of($posts->description)->words(9) !!}</p>

                                        <hr>
                                        <div class="row">
                                            <div class="btn-list" style="display: flex">
                                                <a href="{{ route('blog.edit', $posts->id) }}"> <button class="btn btn-primary mr-2"
                                                                                                          type="button">Edit</button></a>
                                                <form method="POST" action="{{ route('blog.destroy', $posts->id) }}">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="btn btn-danger" type="submit">Delete</button>
                                                </form>
                                            </div>
                                        </div>

                                        <br>
{{--                                        <p style="color: black">Posted By: {{ App\User::findOrFail($posts->user_id)->name }}</p>--}}
                                    </div>
                                </div>
                            </div>


    @endforeach
                    </div>
     @endif
    @endcan
                {{-- @else --}}

                @if(Auth::user()->role == 1 && Auth::user()->status_id == 1)
                    <div class="row col-xl-12 col-lg-12 col-md-12">
                        @foreach($all as $items)

                            <div class="col-xl-4 col-lg-4 col-md-6" style="margin-top: 5%">

                                <div class="card">

                                    <div class="alert-message">
                                        <h4 class="alert-heading">{{ $items->title }}</h4>
                                        <hr>

                                        <p>{!! Illuminate\Support\Str::of($items->description)->words(9) !!}</p>

                                        <hr>
                                        <div class="row">
                                            <div class="btn-list" style="display: flex">
                                                <a href="{{ route('blog.edit', $items->id) }}"> <button class="btn btn-primary mr-2"
                                                                                                        type="button">Edit</button></a>
                                                <form method="POST" action="{{ route('blog.destroy', $items->id) }}">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="btn btn-danger" type="submit">Delete</button>
                                                </form>
                                            </div>
                                        </div>

                                        <br>
                                        <p style="color: black">Posted By: {{ App\User::findOrFail($items->user_id)->name }}</p>
                                    </div>
                                </div>
                            </div>


                        @endforeach
                    </div>
    @endif

{{-- @endcan --}}
{{-- </div>
</main> --}}
@endsection
