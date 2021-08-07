@extends('layouts.admin')
@section('content')

<table class="table table-light">
    <thead>
        <tr>
            <th>Name</th>
            <th>Status</th>
            <th>Model</th>
            <th colspan="2">Action</th>
        </tr>
    </thead>
    <tbody>
        {{-- <td>  {{   $post->changes}}</td> --}}
        @foreach($post as $posts)
        <tr>
            @if($posts->causer_type == App\User::first())
            <td>{{ App\User::findOrFail($posts->causer_id)->name }}</td>
            @elseif($posts->causer_type == App\Subscriber::get())
            <td>{{ App\Subscriber::findOrFail($posts->causer_id)->name }}</td>
            @else
            <td>User Not Found</td>
            @endif
            <td>{{ $posts->description }}</td>
            <td>{{ $posts->causer_type }}</td>
            <td><a href="/activity_log/{{$posts->id}}"><button class="btn btn-primary">Show</button> </a> </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection
