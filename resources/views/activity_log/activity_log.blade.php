@extends('layouts.admin')
@section('content')

<table class="table table-light">
    <thead>
        <tr>
            <th>Name</th>
            <th>Status</th>
            <th>Model</th>
        </tr>
    </thead>
    <tbody>
        {{-- <td>  {{   $post->changes}}</td> --}}
        @foreach($post as $posts)
        <tr>
            <td>{{ App\User::findOrFail($posts->causer_id)->name }}</td>
            <td>{{ $posts->description }}</td>
            <td>{{ $posts->causer_type }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection