@extends('layouts.subscriber')
@section('content')

<div class="container">
            
    @if(Session::has('alert'))
    <div class="alert alert-success alert-dismissible" role="alert">
                                            <strong>Great!  </strong>{{ Session::get('alert') }}
                                        </div>     
        
    @endif
    <div class="row">

        @foreach($jobs as $posts)
    
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    {{-- @if(App\Bookmark::where('company_id',$posts, '=', Request::get('company_id')->exist())) --}}
            <h4>{{$posts->company_name }}</h4>
            {{-- @endif --}}
                </div>
                <div class="card-body">
            {{-- <p>{{ $posts->description }}</p> --}}
                </div>
                @foreach($post as $jobs)
                @if($posts->id == $jobs->company_id)
                <form method="POST" action="{{ route('bookmark.destroy', $jobs->id) }}">
                    @csrf
                    @method('DELETE')
                 <button class="btn btn-danger">Delete</button>
                  </form>
                    @endif
                        @endforeach
               
            </div>
            <br>
        
        </div>
        <br>
    @endforeach
</div>

</div>



@endsection