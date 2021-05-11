@extends('layouts.subscriber')
@section('content')

<div class="container">
            
    @if(Session::has('alert'))
    <div class="alert alert-success alert-dismissible" role="alert">
                                            <strong>Great!  </strong>{{ Session::get('alert') }}
                                        </div>     
        
    @endif
    <div class="row">

        @foreach($post as $posts)
    
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
            <h4>{{ $posts->company_name }}</h4>
                </div>
                <div class="card-body">
            <p>{{ $posts->description }}</p>
                </div>
                <form method="POST" action="{{ route('bookmark.store') }}">
                    @csrf
                    <input hidden name="company_id" value="{{ $posts->id }}">
                    <input hidden name="subscriber_id">
                   <button class="btn btn-success">Add to bookmark</button>
                    <br>
                </form>
               
            </div>
            <br>
        
        </div>
        <br>
    @endforeach
</div>

</div>



@endsection