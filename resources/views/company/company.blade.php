
@extends('layouts.admin')
@section('content')
{{-- @can('viewAny', App\Company::class) --}}
<div class="container">
            <div class="row">
                <div class="col-xl-3 col-lg-3 col-md-3">
                    <div class="col-auto d-none d-sm-block">
                        <h3><strong>Companies</strong> </h3>
                        <a href="{{ route('company.create') }}"><button class="btn btn-success">Add New Company</button></a>
                    </div>
                    <br>
                </div>
                <div class="col-xl-9 col-lg-9 col-md-9">
                    <form action="{{route('company.search')}}" method="POST">
                        @csrf
                    <div class="row col-xl-12 col-lg-12 col-md-12">
                      
                            <h4>Search Company </h4>
                            <div class="col-xl-6 col-lg-6 col-md-6 mr-2">
                                {{-- <input type="text" class="form-control  mr-2"> --}}
                                <select name='location' class="form-control">
                                    <option value="-1">Location</option>
                                    @foreach($location as $locations)
                                        <option value="{{$locations->id}}">{{$locations->name}}</option>
                                    @endforeach
                                </select>
                                <br>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6" style="display: flex; justify-content: center; align-items: center">
                                <button class="btn btn-info">Search</button>
                            </div>                  
                        <br>      
                                
                    </div>
                </form>  
                    </div>  
                    
    
            </div>

            <div class="row" style="margin-top: 3%">
<br><br>
                @can('viewAny', App\Company::class)
               {{-- @if(Auth::user()->status_id != 1)  --}}
                @foreach($all as $companies)
                @if($companies->verification != NULL)
                <div class="col-12 col-xl-4 col-lg-4 col-md-6">

		<div class="card" style="width: 100%">
            <div class="card-body">
                <div class="mb-3">
                        <div class="alert-message">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12">
                                    <h3 class="alert-heading">{{ $companies->company_name }}</h3>
                                </div>
                           
                                @if($companies->company_category == 2)
                                <div class="col-xl-6 col-lg-6 col-md-6" role="alert">
                                    <span class="badge badge-primary">Premium</span>     
                                    </div>
                                    @else
                                    <div class="col-xl-6 col-lg-6 col-md-6" role="alert">
                                        <span class="badge badge-warning">Basic</span>     
                                        </div>
                                    @endif
                                  
                                @if($companies->verification == 1)
                                <div class="alert alert-primary alert-outline-coloured alert-dismissible col-xl-2 col-lg-2 col-md-2" >
                                    {{-- <div class="alert-icon"> --}}
                                        <i class="align-middle" data-feather="check-square" style="color: blue"></i> 
                                    </div>
                                {{-- </div> --}}
                                {{-- @else --}}
                                @endif
                            </div>
                          
                            <hr>
                            <p>{!! Illuminate\Support\Str::of($companies->description)->words(9) !!}</p>
                            <hr>
                            <div class="row">
                                <div class="col-xl-12 col-lg-12"><p>Email: {{ $companies->company_email }}</p></div>
                                <div class="col-xl-12 col-lg-12"><p>Phone: {{ $companies->phone_number }}</p></div>
                                <div class="col-xl-12 col-lg-12"><p>Location: </h4></div>                           
                            </div>
                            <div class="btn-list d-flex">
                              <a href="{{ route('company.edit', $companies->id) }}" > <button class="btn btn-primary mr-2" type="button">Edit</button></a>
                              <form method="POST" action="{{ route('company.destroy', $companies->id) }}">
                                @csrf
                                @method('DELETE')
                              <a href=""><button class="btn btn-danger" >Delete</button></a>
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
    @endif
    @endforeach
   
</div>
{{ $all->links() }}
</div>
@endcan

                <div class="row">
                    @if(Auth::user()->role != 1 && Auth::user()->status_id != 1) 
                    @foreach($post as $posts)
                    @if($posts->verification != Null)
                    <div class="col-12 col-xl-4 col-lg-4 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                            <div class="alert-message">
                                <div class="row">
                                    <div class="col-xl-12 col-lg-12 col-md-12">
                                        <h3 class="alert-heading">{{ $posts->company_name }}</h3>
                                    </div>
                               
                                    @if($posts->company_category == 2)
                                    <div class="col-xl-6 col-lg-6 col-md-6" role="alert">
                                        <span class="badge badge-primary">Premium</span>     
                                        </div>
                                        @else
                                        <div class="col-xl-6 col-lg-6 col-md-6" role="alert">
                                            <span class="badge badge-warning">Basic</span>     
                                            </div>
                                        @endif
                                      
                                    @if($posts->verification == 1)
                                    <div class="alert alert-primary alert-outline-coloured alert-dismissible col-xl-2 col-lg-2 col-md-2" >
                                        {{-- <div class="alert-icon"> --}}
                                            <i class="align-middle" data-feather="check-square" style="color: blue"></i> 
                                        </div>
                                    {{-- </div> --}}
                                    {{-- @else --}}
                                    @endif
                                </div>
                                <hr>
                                <p>{!! Illuminate\Support\Str::of($posts->description)->words(9) !!}</p>
                                <hr>
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
                    @endif
        @endforeach
    </div>
    {{ $post->links() }}
</div>
        @endif

   
@endsection

