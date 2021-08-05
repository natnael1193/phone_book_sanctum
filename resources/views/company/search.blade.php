
@extends('layouts.admin')
@section('content')
    {{-- @can('viewAny', App\Company::class) --}}

    <div class="container">


    <div class="row" style="margin-top: 5%">
        @if(sizeof($post)==0)
            <div class="col-lg-9 col-md-9 text-center">
                <h2>{{"No Companies found "}}</h2>
            </div>
        @endif
  

            @foreach($post as $posts)
                {{-- @if($posts->verification != Null) --}}
                <div class="col-xl-4 col-lg-4 col-md-6">
                    <div class="card">
                        <div class="card-body">

                            <div class="mb-3">
                                <div class="row  col-xl-12 col-lg-12 col-md-12">
                                    <div class="alert-message">

                                        <div class="col-xl-12 col-lg-12 col-md-12">
                                            <h3 class="alert-heading">{{ $posts->company_name }}</h3>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-6 col-lg-6 col-md-6" role="alert">
                                                @if($posts->company_category == 2)
                                                    <span class="badge badge-primary">Premium</span>
                                                @else
                                                    <span class="badge badge-warning">Basic</span>
                                                @endif
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6" role="alert">
                                                @if($posts->verification == 1)
                                                    <div class="alert alert-primary alert-outline-coloured alert-dismissible col-xl-2 col-lg-2 col-md-2" >

                                                        <i class="align-middle" data-feather="check-square" style="color: blue"></i>
                                                    </div>

                                                @endif
                                            </div>
                                        </div>
                                        <hr>
                                        <p>{!! Illuminate\Support\Str::of($posts->description)->words(9) !!}</p>
                                        <hr>
                                    </div>

                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12"><p>Email: {{ $posts->email }}</p></div>
                                        <div class="col-xl-12 col-lg-12"><p>Phone: {{ $posts->phone_number }}</p></div>
                                        <div class="col-xl-12 col-lg-12"><p>Location: {{ $posts->location }}</h4></div>
                                    </div>
                                    <div class="btn-list d-flex">
                                        <a href="{{ route('company.edit', $posts->id) }}" > <button class="btn btn-primary mr-2" type="button">Edit</button></a>
                                        <form method="POST" action="{{ route('company.destroy', $posts->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <a href=""><button class="btn btn-danger" >Delete</button></a>
                                        </form>
                                    </div>
                                    <br>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                {{-- @endif --}}
            @endforeach

    </div>
    <div class="row col-xl-12 ol-lg-12" style="display: flex; justify-content: center; align-items: center">
{{--        {{ $post->links() }}--}}
    </div>





    {{-- <script type="text/javascript">
    $document(.)
    </script> --}}

@endsection



