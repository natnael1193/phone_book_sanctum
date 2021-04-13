@extends('layouts.admin')
@section('content')

<main class="content">
    <div class="container-fluid p-0">

        {{-- <h1 class="h3 mb-3">Tables</h1> --}}

        <div class="row">
            <div class="col-4 col-xl-4">
                <div class="card">
                    <div class="card-header">           
                        <h4>
                           User Status
                        </h4>
                    </div>
     <div class="card-body">
<h2>User Name: {{ $user->name }}</h2>
<h4>Number Of Posts: {{ $post->count() }}</h4>
<h4>Previlage:  @if($user->status_id == null)<span>Not Previlaged</span>@else<span> Previlaged</span>@endif</h4>
<div class="row">
    <form method="post" action="{{ route('admin.update', $user->id) }}">
        @csrf
        @method('PATCH')
        
        <input type="hidden" value="{{ $user->role }}" name="role">
        <input type="hidden" value="{{ $user->name }}" name="name">
        <input type="hidden" value="{{ $user->email }}" name="email">
        <input type="hidden" value="{{ $user->password }}" name="password">
        @if($user->status_id == null) 
            <input type="hidden" value="1" name="status_id">
            <button class="btn btn-primary">
            <span>Give Previlage</span></button>
            @else
            <input type="hidden" value="" name="status_id">
            <button class="btn btn-danger" value=""><span>Terminate Previlage</span></button>@endif

    </form>
</div>
     </div>
                </div>
            </div>
            <div class="col-8 col-xl-8">
                <div class="card">
<table class="table table-light">
    <thead>
        <tr>
            <th>Company Name</th>
            <th>Created Date</th>
        </tr>
   
    </thead>
   
    <tbody>
        @foreach($post as $posts)
        <tr>
            <td>{{ $posts->company_name }}</td>
            <td>{{ $posts->created_at->todatestring() }}</td>
        </tr>
        @endforeach
        <hr>
    </tbody>
</table>
                </div>
            </div>

        </div>
    </div>
    </main>
    
    @endsection