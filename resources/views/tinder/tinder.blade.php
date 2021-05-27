
@extends('layouts.admin')
@section('content')
{{-- @can('viewAny', App\blog::class) --}}
                <div class="row">
                <a href="/vacancy/create"><button class="btn btn-success">Add New Vacancy</button></a>            
            </div>
            <div class="row">
                @if(Auth::user()->role == 1)
 
                @foreach($post as $posts)
                <div class="col-xl-4 col-lg-4 col-md-6" style="margin-top: 5%">

		<div class="card">
 
                <div class="alert-message">
                    <h4>{{ $posts->title }}</h4> 
                        <hr>
                 
<p>{!! Illuminate\Support\Str::of($posts->description)->words(9) !!}</p>        

    <hr>
            <div class="btn-list">
                <a href="{{ route('tinder.edit', $posts->id) }}" > <button class="btn btn-primary" type="button">Edit</button></a>
                  <button class="btn btn-danger" type="button">Delete</button>
              </div>
              <br>
              <p style="color: black">Posted By: {{ App\User::findOrFail($posts->user_id)->name }}</p>
               </div>
                </div>
                </div>
    @endforeach
                @else
                @foreach($post as $posts)
       

	                <div class="col-xl-4 col-lg-4 col-md-6" style="margin-top: 5%">
                        <div class="card">           
                                <div class="alert-message">
                                    <h4 class="alert-heading">{{ $posts->company }}</h3>
                                        <hr>
                                    <h4>{{ $posts->title }}</h4> 
                <p>{!! Illuminate\Support\Str::of($posts->description)->words(9) !!}</p>        
                           
                            <div class="btn-list">
                                <a href="{{ route('tinder.edit', $posts->id) }}" > <button class="btn btn-primary" type="button">Edit</button></a>
                                  <button class="btn btn-danger" type="button">Delete</button>
                              </div>
                               </div>
         
                                </div>
                                </div>
    @endforeach
    @endif
</div>
{{ $post->links() }}
@endsection