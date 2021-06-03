
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
                                <input type="text" class="form-control  mr-2" name="keyword">
                                <br>
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

            <div class="row" style="margin-top: 5%">
                @if(Auth::user()->role == 1 || Auth::user()->status_id == 1) 
                @foreach($company as $posts)
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
{{ $company->links() }}
</div>
    @endif
</div>


                <div class="row" style="margin-top: 5%">
                    @if(Auth::user()->role != 1 && Auth::user()->status_id != 1) 
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
    {{ $post->links() }}
</div>


        @endif

   


        {{-- <script type="text/javascript">
        $document(.)
        </script> --}}

@endsection

